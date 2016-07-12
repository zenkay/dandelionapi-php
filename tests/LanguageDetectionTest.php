<?php
    namespace Dandelionapi\Test;

    use Dandelionapi\Apis\LanguageDetection;

    class LanguageDetectionTest extends \PHPUnit_Framework_TestCase
    {
        public function testInizialization()
        {
            $element = new LanguageDetection();

            static::assertInstanceOf('Dandelionapi\Apis\LanguageDetection', $element);
        }
    }