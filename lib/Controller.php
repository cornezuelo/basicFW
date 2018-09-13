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
		$this->twig->addFunction(new Twig_Function('dump', function($v) {
			echo '<pre>';print_r($v);echo '</pre>';
		}));		
	}
	public function action($action='main',$args=[]) {				
		if (method_exists($this, $action)) {
			if (!empty($args)) {				
				$this->$action($args);
			} else {
				$this->$action();
			}			
		} else {
			die('Method '.$action.' doesn\'t exist');
		}
	}
}