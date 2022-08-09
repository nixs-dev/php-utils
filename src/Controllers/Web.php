<?php

namespace App\Controllers;

use App\Utils\Template;


class Web {
    public static function main() {
        $t = new Template("test.php", [
            "nick" => "Joabe"
        ]);
        
        return $t->render();
    }
}