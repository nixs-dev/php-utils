<?php

require 'vendor/autoload.php';

use App\Utils\Route;
use App\Utils\Group;
use App\Utils\Router;
use App\Utils\Globals;


$router = new Router();
Globals::set("ROOT", __DIR__);

$groups = [
    new Group("logged", ["App\\Middlewares\\Authentication"])
];

$routes = [
    new Route("/test1/{id}", "App\Controllers\Test::routeParams"),
    new Route("/test1/a", "App\Controllers\Test::routeParams2"),
];

$router->setRoutes($routes);
$router->run();