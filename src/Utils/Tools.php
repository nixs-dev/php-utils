<?php

namespace App\Utils;


class Tools {
    public static function friendlyDateInterval($date) {
        $now = new \DateTime("now", new \DateTimeZone("GMT-02:00"));
        $date = new \DateTime($date, new \DateTimeZone("GMT-02:00"));
        $result = $now->diff($date);
        $translation = [
            "y" => "anos",
            "m" => "meses",
            "d" => "dias",
            "h" => "horas",
            "i" => "minutos",
            "s" => "segundos"
        ];
        $readable_result;
        
        foreach(array_keys($translation) as $quantifier) {
            if($result->$quantifier > 0) {
                $readable_result = "{$result->$quantifier} {$translation[$quantifier]}";
                break;
            }
        }
        
        return $readable_result;
    }
    
    public static function blobToB64($object, $attributes) {
        foreach($attributes as $attribute) {
            $object->$attribute = base64_encode($object->$attribute);
        }
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