<?php
    namespace Dandelionapi\Test;

    use Dandelionapi\Apis\TextExtraction;

    class TextExtractionTest extends \PHPUnit_Framework_TestCase
    {
        public function testInizialization()
        {
            $element = new TextExtraction();

            $this->assertInstanceOf('Dandelionapi\Apis\TextExtraction', $element);
        }
    }