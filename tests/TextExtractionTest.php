<?php

include_once "TestHelper.php";

class TextExtractionTest extends PHPUnit_Framework_TestCase {

	public function testInizialization(){
		$element = new Dandelionapi\TextExtraction;
		$this->assertInstanceOf("Dandelionapi\TextExtraction", $element);

	}
	
}