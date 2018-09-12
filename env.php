<?php
//ENVIRONMENT
if (!file_exists(__DIR__.'/config.php')) {
	die('config.php file doesn\'t exist. Please, copy config.php.default to config.php and edit the file.');
}
if (!file_exists(__DIR__.'/routing.php')) {
	die('routing.php file doesn\'t exist. Please, copy routing.php.default to routing.php and edit the file.');
}
require_once __DIR__.'/config.php';
require_once __DIR__.'/routing.php';
require_once __DIR__.'/utils/Common.php';
require_once __DIR__.'/controllers/Controller.php';
require_once __DIR__.'/vendor/autoload.php';

//Autoloader
spl_autoload_register(function ($class) {       
    $file = __DIR__ . '/managers/' . str_replace('\\', '/', $class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    } else {
		throw new Exception('Class '.$class.' couldn\'t be loaded.');
	}
});

//ERRORS
if (isset($config['errors']) && $config['errors'] == true) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
//DB
if (isset($config['DBEnable']) && $config['DBEnable'] == true) {
	$con = new mysqli($config['hostDB'], $config['userDB'], $config['pwdDB'], $config['dbDB']);
	$con->set_charset("utf8");
	if ($con->connect_error) {
		die('Connection error (' . $con->connect_errno . ') '
				. $con->connect_error);
	}
}
?>