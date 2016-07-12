<?php
    namespace Dandelionapi\Test;

    use Dandelionapi\apis\LanguageDetection;

    class LanguageDetectionTest extends \PHPUnit_Framework_TestCase
    {
        public function testInizialization()
        {
            $element = new LanguageDetection();

            static::assertInstanceOf('Dandelionapi\apis\LanguageDetection', $element);
        }
    }