<?php
//ENVIRONMENT
require_once 'lib/env.php';
//PROCESS
try {	
	if ($route == '__default__' && isset($_routingApp['__default__'])) {
		$routeFound = $_routingApp['__default__'];
	}
	else {
		foreach ($_routingApp as $routeAux) {		
			if (in_array($route,$routeAux[2])) {
				$routeFound = $routeAux;
				break;
			}
		}	
		unset($routeAux);
	}
	
	if (isset($routeFound)) {
		$class = $routeFound[0];
		$method = $routeFound[1];
		$controller = __DIR__.'/controllers/'.$class.'.php';		
		if (!file_exists($controller)) {
			throw new Exception($controller. ' controller doesn\'t exist.');
		} else {
			require_once $controller;			
			$obj = new $class();						
			$obj->_action($method);
		}
	} else {
		throw new Exception('No route for "'.$route.'"');
	}	
} catch (Exception $e) {
	die('<b>Exception:</b> '.$e->getMessage());
}
?>