<?php
    namespace Dandelionapi\Test;

    use Dandelionapi\apis\EntityExtraction;

    class EntityExtractionTest extends \PHPUnit_Framework_TestCase
    {
        public function testInizialization()
        {
            $element = new EntityExtraction();

            static::assertInstanceOf('Dandelionapi\apis\EntityExtraction', $element);
        }
    }