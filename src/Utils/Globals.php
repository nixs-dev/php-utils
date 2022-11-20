<?php

namespace App\Utils;


class Globals {
    public static $ROOT;
    public static $ROUTER;
    
    public static function set($attribute, $value) {
        self::${$attribute} = $value;
    }
}