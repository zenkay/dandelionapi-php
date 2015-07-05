<?php

include_once "TestHelper.php";

class LanguageDetectionTest extends PHPUnit_Framework_TestCase {

	public function testInizialization(){
		$element = new Dandelionapi\LanguageDetection;
		$this->assertInstanceOf("Dandelionapi\LanguageDetection", $element);

	}
	
}