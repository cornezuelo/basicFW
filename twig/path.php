<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of path
 *
 * @author IBERLEY\oaviles
 */
class twig_path {
	public static function _exec() {		
		return function($route) {
			$_routingApp = $GLOBALS['_routingApp'];
			foreach ($_routingApp as $routeAux) {		
				if (in_array($route,$routeAux[2])) {
					return $routeAux[2][0];					
				}
			}			
			return false;
		};
	}
}
