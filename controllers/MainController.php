<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainController
 *
 * @author IBERLEY\oaviles
 */
class MainController extends Controller {
	public function mainAction() {				
		$obj = new TestManager();
		$test_string = $obj->test();
		echo $this->twig->render('index.html.twig', ['test_string' => $test_string]);
	}	
}
