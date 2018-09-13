<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestManager
 *
 * @author IBERLEY\oaviles
 */
class TestManager {
	private $test2Manager;
	function __construct(Test2Manager $test2Manager) {
		$this->test2Manager = $test2Manager;
	}

	public function test() {
		$param = $this->test2Manager->getParam();
		return '<p>This is a test string sent from a manager with param '.$param.'.</p>';
	}
}
