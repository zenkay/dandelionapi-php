<?php

include_once "TestHelper.php";

class EntityExtractionTest extends PHPUnit_Framework_TestCase {

	public function testInizialization(){
		$element = new Dandelionapi\EntityExtraction;
		$this->assertInstanceOf("Dandelionapi\EntityExtraction", $element);

	}
	
}