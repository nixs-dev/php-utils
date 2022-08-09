<?php

define ("ROOT", __DIR__);
require 'vendor/autoload.php';

use App\Utils\Router;


$router = new Router();

$routes = [
    ["name" => "/main", "controller" => "App\Controllers\Web::main", "middlewares" => []]
]; // route, controller, middlewares[]

$router->setRoutes($routes);
$router->run();