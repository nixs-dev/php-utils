<?php

namespace App\Utils;


class Router {
    public $routes;
    private $errors_controller;
    
    public function __construct($routes=NULL, $errors_controller=NULL) {
        $this->routes = $routes;
        $this->errors_controller = $errors_controller;
    }
    
    public function getRoutes() {
        return $this->routes;
    }
    
    public function setRoutes($routes) {
        $this->routes = $routes;
    }
    
    public function setErrorsController($controller) {
        $this->errors_controller = $controller;
    }
    
    public function run() {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        
        // Setup routes groups
        foreach ($this->routes as $route) {
            foreach ($route->getGroups() as $group) {
                $route->addMiddlewares($group->getMiddlewares());
            }
        }
        
        // Try match a route
        $matched_route = array_filter($this->routes, function ($r) use (&$url) {
            return $r->getName() == $url;
        });
        
        if (!$matched_route) {
            $this->raiseErrorPage(404); // raise 404 error
            return;
        }
        
        $matched_route = reset($matched_route);
        
        // Execute middlewares
        $request_accepted = true;
        
        foreach($matched_route->getMiddlewares() as $middleware) {
            if(call_user_func($middleware . "::exec")) {
                continue;
            }
            else {
                $request_accepted = false;
                break;
            }
        }
        
        // Finish request
        if ($request_accepted) {
            echo call_user_func($matched_route->getController());
        }
        else {
            $this->raiseErrorPage(401); // raise 401 error
        }
    }
    
    private function raiseErrorPage($code, $message=NULL) {
        http_response_code($code);
        
        if(!isset($this->errors_controller)) {
            echo "THE SERVER RETURNED A <strong>${code}</strong> ERROR";
        }
        else {
            $controller = $this->errors_controller;
            echo call_user_func($controller . "::error" . strval($code), $message);
        }
    }
}