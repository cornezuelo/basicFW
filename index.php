<?php
//ENVIRONMENT
require_once 'env.php';
//ROUTING
if (!isset($_REQUEST['route'])) {
	$_REQUEST['route'] = 'default'; //Default route
}
try {
	if (isset($routing[$_REQUEST['route']])) {
		$class = $routing[$_REQUEST['route']][0];
		$method = $routing[$_REQUEST['route']][1];
		$controller = __DIR__.'/controllers/'.$class.'.php';		
		if (!file_exists($controller)) {
			throw new Exception($controller. ' controller doesn\'t exist.');
		} else {
			require_once $controller;			
			$obj = new $class();						
			$obj->action($method);
		}
	} else {
		throw new Exception('No route for '.$_REQUEST['route']);
	}	
} catch (Exception $e) {
	die('<b>Exception:</b> '.$e->getMessage());
}
?>