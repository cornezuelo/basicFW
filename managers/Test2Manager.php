<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test2Manager
 *
 * @author IBERLEY\oaviles
 */
class Test2Manager {
	private $param;	
	
	function __construct($param) {
		$this->param = $param;
	}
	
	function getParam() {
		return $this->param;
	}
}
