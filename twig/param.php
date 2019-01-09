<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of param
 *
 * @author IBERLEY\oaviles
 */
class twig_param {
	public static function _exec() {		
		return function($k) {
			if (isset($GLOBALS['_paramsApp'][$k])) {
				return $GLOBALS['_paramsApp'][$k]; 
			}
			return false;
		};
	}
}
