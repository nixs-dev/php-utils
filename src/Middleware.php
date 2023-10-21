<?php

namespace PHPUtils;


interface Middleware
{
    public static function exec($request);
}