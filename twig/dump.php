<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dump
 *
 * @author IBERLEY\oaviles
 */
class twig_dump {
	public static function _exec() {
		return function($v) {
			echo '<pre>';print_r($v);echo '</pre>';
		};
	}
}
