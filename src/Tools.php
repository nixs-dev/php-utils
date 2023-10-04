<?php

namespace PHPUtils;


class Tools {
    public static function friendlyDateInterval($date) {
        $date = new \DateTime($date, new \DateTimeZone("GMT-03:00"));
        $now = new \DateTime("now", new \DateTimeZone("GMT-03:00"));
        $day_interval = intval($now->format("d")) - intval($date->format("d"));
        $readable_result = null;

        if(intval($now->format("Y")) != intval($date->format("Y"))) {
            $day_interval = 100; // Long days intervals don't really matter here, so we can set 100
        }

        if($day_interval == 0) {
            $readable_result = $date->format("H:i");
        }
        else if($day_interval == 1) {
            $readable_result = "Ontem às " . $date->format("H:i");
        }
        else {
            $readable_result = $date->format("d/m/Y H:i");
        }
        
        return $readable_result;
    }
    
    public static function blobToB64($object, $attributes) {
        foreach($attributes as $attribute) {
            $object->$attribute = base64_encode($object->$attribute);
        }
    }

    public static function bytesUnitRepresentation($bytes) {
        $units = ["B", "KB", "MB", "GB"];
        $current_unit = 0;
        $current_value = $bytes;

        while($current_value / 1024 >= 1) {
            $current_unit++;
            $current_value = $current_value / 1024;
        }

        if($current_unit > count($units) - 1) $current_unit = count($units) - 1;

        return strval(number_format($current_value, 2)) . $units[$current_unit];
    }
    
    public static function generatePassword($size, $digits=true, $letters=true) {
        // RANDOM NUMBERS ARE REFERENCES TO ASCII TABLE
        
        $result = "";
        $getRand = function() use (&$digits, &$letters) {
            if($letters == $digits) {
                return rand(33, 126);
            }
            else if($digits) {
                return rand(48, 57);
            }
            else if($letters) {
                $aux = rand(0, 1);
                
                return [rand(33, 47), rand(58, 126)][$aux];
            }
        };
        
        for($i = 0; $i < $size; $i++) {
            $result .= chr($getRand());
        }
        
        return $result;
    }
}