<?php
namespace Dandelionapi;

use Dandelionapi\apis\EntityExtraction;

class Dandelionapi{

    // implementazione statica?
    public static function EntityExtraction($params = []){
        $_o = new EntityExtraction($params);
        try{
            $_rv = $_o->callText();
        } catch(\Exception $e){
            throw $e;
        }
        return $_rv;
    }
}