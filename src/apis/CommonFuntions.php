<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 7/29/15
 * Time: 1:29 PM
 */

namespace Dandelionapi\apis;


use ReflectionClass;
use ReflectionProperty;

Trait CommonFuntions
{
    protected function _populate($attributes)
    {
        foreach ($attributes as $key => $val) {
            $_setter = "set".$key ;
            $_me = method_exists($this, $_setter);
            if ($_me) {
                $this->$_setter($val);
            }
        }
    }

    protected function deCamelize($input)
    {
        return  ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $input)), '_');
    }

    protected function readProperties(){
        $_reflect = new ReflectionClass($this);
        $_rv   = $_reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        return $_rv;
    }
}