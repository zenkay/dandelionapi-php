<?php


include_once dirname(__DIR__)."/vendor/autoload.php";

$_p=[
    'text' => "The doctor says an apple is better than an orange",
    "include"=>"types,abstract,categories,lod",
    "appId"=>"78ef40d7",
    "appKey"=>"95df210306a920bd63cc2d023f152b06",
];

$_o = new \Dandelionapi\apis\EntityExtraction($_p);

$_res = $_o->callText();

var_dump($_res);