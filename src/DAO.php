<?php

namespace App\Utils;

class DAO {
    protected static $OBJECT_REFERENCES = [];
    
    public static function getReferences($object) {
        foreach (static::$OBJECT_REFERENCES as $REFERENCE) {
            $attribute_name = $REFERENCE[0];
            $function = $REFERENCE[1];
            $args = $REFERENCE[2];
            
            $args = array_map(function ($a) use (&$object, &$attribute_name) {
                return $a == "&${attribute_name}" ? $object->$attribute_name : $a;
            }, $args);
            
            $object->$attribute_name = call_user_func_array($function, $args);
        }
    }
}