<?php

define ("ROOT", __DIR__);
require 'vendor/autoload.php';

use App\Utils\Route;
use App\Utils\Group;
use App\Utils\Router;


$router = new Router();

$groups = [
    new Group("logged", ["App\\Middlewares\\Authentication"])
];

$routes = [
    new Route("/main", "App\Controllers\Web::main", [$groups[0]]),
];

$router->setRoutes($routes);
$router->run();