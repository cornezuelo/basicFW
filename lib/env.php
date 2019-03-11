<?php
//ENVIRONMENT
//******************************************************************************
//Config files
$_appConfigFiles = ['config.php','parameters.php','services.php','routing.php'];
foreach ($_appConfigFiles as $file) {
	if (!file_exists(__DIR__.'/../config/'.$file)) {
		die('/../config/'.$file.' file doesn\'t exist. Please, copy '.$file.'.default to '.$file.' and edit the file.');
	} else {
		include_once(__DIR__.'/../config/'.$file);
	}
}
unset($_appConfigFiles);
unset($file);

//Require config
require_once __DIR__.'/../config/config.php';

//Errors
if (isset($_configApp['errors']) && $_configApp['errors'] == true) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

//Requires
require_once __DIR__.'/../config/routing.php';
require_once __DIR__.'/Controller.php';
require_once __DIR__.'/../vendor/autoload.php';

//Autoloader
spl_autoload_register(function ($class) {	
	if (strpos($class,'twig_') === 0) {
		$file = __DIR__ . '/../twig/' . str_replace('\\', '/', str_replace('twig_','',$class)) . '.php';	
	} else {
		$file = __DIR__ . '/../managers/' . str_replace('\\', '/', $class) . '.php';	
	}
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    } else {
		throw new Exception('Class '.$class.' couldn\'t be loaded from '.$file.'.');
	}
});

//Find route
function _findRouteByAlias($route) {
	global $_routingApp;
	$routeFound = false;
	if (isset($_routingApp[$route])) {
		return $_routingApp[$route];
	}
	return $routeFound;
}

function _findRoute($route) {
	global $_routingApp;
	$paramsRoute = [];
	$routeFound = false;
	//Default
	if ($route == '__default__' && isset($_routingApp['__default__'])) {
		$routeFound = $_routingApp['__default__'];
	}
	//Non-standard
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
	return ['route' => $routeFound, 'params' => $paramsRoute];	
}

function _getPathEnv($route,$args=[]) {
	$res = _findRouteByAlias($route);		
	if ($res && isset($res[2][0])) {
		$route = $res[2][0];
		if (empty($args)) {
			return $route;
		} else {													
			$k = 0;								
			$continue = true;
			while($continue != false) {			
				$start = strpos($route, '{');
				$end = strpos($route, '}');									
				if ($start == false || $end == false) {
					$continue = false;
				} else {												
					$route = substr_replace($route, $args[$k], $start, ($end-$start)+1);
					$k++;
				}	
			}
			return $route;
		}
	} else {
		throw new Exception('Route alias '.$route.' couldn\'t be found.');
	}	
}

//Routing
$aux = explode('index.php', $_SERVER['REQUEST_URI']);
$route = $aux[count($aux)-1];
if (empty($route) || $aux[0] == $route) {
	$route = '__default__';
}
?>
