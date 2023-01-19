<?php

namespace App\Controllers;

use App\Utils\Template;
use App\Utils\Globals;
use App\Utils\Tools;

class Web {
    public static function main() {
        $t = [
            "a" => 1,
            "b" => [1 => "88"]
        ];
        return json_encode($t);
    }
}