<?php
//ENVIRONMENT
require_once 'lib/env.php';
//PROCESS
try {
	if (isset($routing[$route])) {
		$class = $routing[$route][0];
		$method = $routing[$route][1];
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