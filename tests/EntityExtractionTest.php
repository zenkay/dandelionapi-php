<?php
    namespace Dandelionapi\Test;

    use Dandelionapi\Apis\EntityExtraction;
    use Dandelionapi\Dandelionapi;

    class EntityExtractionTest extends \PHPUnit_Framework_TestCase
    {
        private static $APPID  = '78ef40d7';
        private static $APPKEY = '95df210306a920bd63cc2d023f152b06';

        public function testInizialization()
        {
            $element = new EntityExtraction();

            static::assertInstanceOf('Dandelionapi\Apis\EntityExtraction', $element);
        }

        /**
         * con il wrapper si imposta la configurazione solo una volta
         * @throws \Exception
         */
        public function testDandelionApi()
        {
            $_p = [
                'url'     => 'https://twitter.com',
                'include' => '"types,abstract,categories,lod',
            ];
            $_wrapper = new Dandelionapi(
                [
                    'appId'  => static::$APPID,
                    'appKey' => static::$APPKEY
                ]
            );
            $_res = $_wrapper->EntityExtraction($_p);

            static::assertObjectHasAttribute('annotations', $_res);
        }

        /**
         * chiamata diretta all'api
         *
         * @throws \Exception
         */
        public function testEntityExtraction()
        {
            $_p = [
                'text'    => "The doctor says an apple is better than an orange",
                "include" => "types,abstract,categories,lod",
                "appId"   => static::$APPID,
                "appKey"  => static::$APPKEY,
            ];
            $_api = new EntityExtraction($_p);

            static::assertTrue($_api->hasAppId());
            static::assertTrue($_api->hasAppKey());
            static::assertFalse($_api->hasToken());

            $_res = $_api->run();

            static::assertObjectHasAttribute('annotations', $_res);
        }
    }