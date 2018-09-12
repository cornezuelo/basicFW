<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Common
 *
 * @author IBERLEY\oaviles
 */
class Commmon {
	/**
	 * 
	 * @param string $v
	 */
	public static function pre($v) {				
		$uniqid = uniqid();		
		echo "<pre>";
		var_dump($v);
		echo "</pre>";		
	}
	
	/**
	 * 
	 * @param string $v
	 */
	public static function pred($v) {
		self::pre($v);
		die();
	}
}
