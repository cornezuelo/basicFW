<?php
//ENVIRONMENT
if (!file_exists(__DIR__.'/../config/config.php')) {
	die('/../config/config.php file doesn\'t exist. Please, copy config.php.default to config.php and edit the file.');
}
if (!file_exists(__DIR__.'/../config/routing.php')) {
	die('routing.php file doesn\'t exist. Please, copy routing.php.default to routing.php and edit the file.');
}
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../config/routing.php';
require_once __DIR__.'/Controller.php';
require_once __DIR__.'/../vendor/autoload.php';

//AUTOLOADER
spl_autoload_register(function ($class) {       
    $file = __DIR__ . '/../managers/' . str_replace('\\', '/', $class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    } else {
		throw new Exception('Class '.$class.' couldn\'t be loaded from '.$file.'.');
	}
});

//ERRORS
if (isset($_configApp['errors']) && $_configApp['errors'] == true) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
?>