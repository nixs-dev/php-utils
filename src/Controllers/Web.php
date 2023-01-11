<?php

namespace App\Controllers;

use App\Utils\Template;
use App\Utils\Globals;
use App\Utils\Tools;

class Web {
    public static function main() {
        return json_encode(new \DateTime("now", new \DateTimeZone('GMT-02:00')));
    }
}