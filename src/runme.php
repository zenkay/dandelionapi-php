<?php

// configurazioni da mettere nel config
define("APPID","78ef40d7");
define("APPKEY","95df210306a920bd63cc2d023f152b06");

// autoloader, di solito implementato dal framework
include_once dirname(__DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";


// chiamata diretta all'api
$_p=[
    'text' => "The doctor says an apple is better than an orange",
    "include"=>"types,abstract,categories,lod",
    "appId"=>APPID,
    "appKey"=>APPKEY,
];
$_api = new \Dandelionapi\apis\EntityExtraction($_p);
$_res = $_api->run();
var_dump($_res);


// con il wrapper si imposta la configurazione solo una volta
$_p=[
    'url' => "http://redooc.com/it/matematica-statistica/calcolo-combinatorio/permutazioni",
    "include"=>"types,abstract,categories,lod",
];
$_wrapper = new \Dandelionapi\Dandelionapi(APPID,APPKEY);
$_res = $_wrapper->EntityExtraction($_p);
var_dump($_res);
