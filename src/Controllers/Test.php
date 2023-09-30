<?php

namespace App\Controllers;

use App\Utils\Template;
use App\Utils\Globals;
use App\Utils\Tools;

class Test {
    public static function routeParams($id) {
        echo $id;
    }

    public static function routeParams2() {
        echo "PASSOU2";
    }
}