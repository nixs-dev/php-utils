<?php

namespace App\Middlewares;

use App\Utils\Middleware;


class Authentication implements Middleware {
    public static function exec() {
        return false;
    }
}