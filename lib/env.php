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

//Routing
$aux = explode('index.php', $_SERVER['REQUEST_URI']);
$route = $aux[count($aux)-1];
if (empty($route) || $aux[0] == $route) {
	$route = '__default__';
}
?>