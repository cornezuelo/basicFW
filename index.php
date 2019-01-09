<?php
//ENVIRONMENT
require_once 'lib/env.php';
//PROCESS
try {	
	$paramsRoute = [];
	if ($route == '__default__' && isset($_routingApp['__default__'])) {
		$routeFound = $_routingApp['__default__'];
	}
	else {
		foreach ($_routingApp as $routeAux) {		
			foreach ($routeAux[2] as $currentRoute) {
				//Simple method
				if ($currentRoute == $route) {
					$routeFound = $routeAux;
					break;					
				} 
				//Regex method
				elseif (strpos($currentRoute, '{') !== false && strpos($currentRoute, '}') !== false) {										
					$re = preg_replace('/\{(.+)\}/U', '(.+)', $currentRoute); //Convert						
					$re = '/'.str_replace('/', '\/', $re).'/'; //Flags, delimiter and backslash escaping					
					preg_match_all($re, $route, $matches, PREG_SET_ORDER, 0);					
					if (isset($matches[0]) && isset($matches[0][1]) && !empty($matches[0][1])) {						
						foreach ($matches[0] as $k_match => $v_match) {
							if ($k_match != 0) {
								$paramsRoute[$k_match-1] = $v_match;
							}							
						}
						$routeFound = $routeAux;
						break;
						
					}					
				}
			}			
		}					
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