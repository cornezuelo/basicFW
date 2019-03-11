<?php
//ENVIRONMENT
require_once 'lib/env.php';
//PROCESS
try {	
	$paramsRoute = [];
	$aux = _findRoute($route);
	$routeFound = $aux['route'];
	$paramsRoute = $aux['params'];
	
	if ($routeFound != false) {
		$class = $routeFound[0];
		$method = $routeFound[1];
		$controller = __DIR__.'/controllers/'.$class.'.php';		
		if (!file_exists($controller)) {
			throw new Exception($controller. ' controller doesn\'t exist.');
		} else {
			require_once $controller;	
			$obj = new $class();													
			//Without parameters
			if (count($paramsRoute) == 0) {
				$obj->_action($method);
			} 
			//With parameters
			else {						
				$obj->_action($method, $paramsRoute);
			}
			
		}		
	} else {
		throw new Exception('No route for "'.$route.'"');
	}	
} catch (Exception $e) {
	die('<b>Exception:</b> '.$e->getMessage());
}
?>
