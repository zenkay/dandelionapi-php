<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 7/29/15
 * Time: 1:29 PM
 */

namespace Dandelionapi\Apis;


use ReflectionClass;
use ReflectionProperty;

Trait CommonFunctions
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
        $_properties   = $_reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        $_rv = [];
        foreach ($_properties as $_k => $_v) {
            $_index  = $this->deCamelize($_v->name);
            $_func   = ucfirst(ltrim($_v->name, '_'));
            $_getter = "get{$_func}";
            $_haver  = "has{$_func}";
            if ($this->$_haver() == false) {
                continue;
            }
            if (isset(parent::$_dollarPrefix[$_index])) {
                $_rv[parent::$_dollarPrefix[$_index]] = $this->$_getter();
            } else {
                $_rv[$_index] = $this->$_getter();
            }
        }

        return $_rv;
    }
}