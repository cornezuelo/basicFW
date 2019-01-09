<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Controller
 *
 * @author IBERLEY\oaviles
 */
class Controller {
	public $twig;	
	
	function __construct() {
		$loader = new Twig_Loader_Filesystem(__DIR__.'/../views');
		$this->twig = new Twig_Environment($loader, array('cache' => 'cache','auto_reload' => true));
		$this->loadTwigFunctions();		
	}
	
	public function _action($action='main',$args=[]) {				
		if (method_exists($this, $action)) {
			if (!empty($args)) {				
				call_user_func_array(array($this,$action), $args);
				//$this->$action($args);
			} else {
				$this->$action();
			}			
		} else {
			die('Method '.$action.' doesn\'t exist');
		}
	}
	
	public function _getConfig($k) {		
		if (isset($GLOBALS['_configApp'][$k])) {
			return $GLOBALS['_configApp'][$k]; 
		}
		return false;
	}		
	
	public function _getParam($k) {				
		if (isset($GLOBALS['_paramsApp'][$k])) {
			return $GLOBALS['_paramsApp'][$k]; 
		}
		return false;
	}	
	
	public function _getManager($manager) {			
		$services = $GLOBALS['_servicesApp'];
		$params = [];		
		if (isset($services[$manager])) {			
			foreach ($services[$manager] as $param) {				
				//Inject a manager
				if($param[0] == '@' && $param[strlen($param) - 1] == '@') {					
					$params[] = $this->_getManager(rtrim(ltrim($param,'@'),'@'));
				} 
				//Inject a param
				elseif($param[0] == '%' && $param[strlen($param) - 1] == '%') {
					$params[] = $this->_getParam(rtrim(ltrim($param,'%'),'%'));
				}
				//Inject a value
				else {
					$params[] = $param;
				}
			}
			$reflector = new ReflectionClass($manager);
			$obj = $reflector->newInstanceArgs($params);			
		} else {
			$obj = new $manager();
		}
		return $obj;		
	}
	
	public function loadTwigFunctions() {
		$files = scandir(__DIR__.'/../twig');
		foreach ($files as $file) {
			if (!in_array($file,['.','..'])) {
				$fName = str_replace('.php','',$file);
				$className = 'twig_'.$fName;								
				$this->twig->addFunction(new Twig_Function($fName, $className::_exec()));			
			}
		}				
	}
}