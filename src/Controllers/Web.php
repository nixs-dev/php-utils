<?php

namespace App\Controllers;

use App\Utils\Template;
use App\Utils\Globals;

class Web {
    public static function main() {
        $t = new Template("test.php", [
            "nick" => "Joabe"
        ]);
        
        return (Globals::$ROUTER)->raiseErrorPage(401);
    }
}