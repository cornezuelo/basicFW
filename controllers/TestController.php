<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author IBERLEY\oaviles
 */
class TestController extends Controller {
	public function testAction() {				
		$obj = new TestManager();
		$test_string = $obj->test();
		echo $this->twig->render('test.html.twig', [
			'test_string' => $test_string,
			'errors_app_param' => $this->_getAppParam('errors')
			
		]);
	}	
}
