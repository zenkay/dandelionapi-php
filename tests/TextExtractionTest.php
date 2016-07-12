<?php
    namespace Dandelionapi\Test;

    use Dandelionapi\apis\TextExtraction;

    class TextExtractionTest extends \PHPUnit_Framework_TestCase
    {
        public function testInizialization()
        {
            $element = new TextExtraction();

            $this->assertInstanceOf('Dandelionapi\apis\TextExtraction', $element);
        }
    }