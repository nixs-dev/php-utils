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
    
    public function run() {
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $routes_urls = array();
        
        // Try match a route
        foreach ($this->routes as $route) array_push($routes_urls, $route["name"]);
        
        $route_index = array_search($url, $routes_urls);
        
        if ($route_index === false) {
            $this->raiseErrorPage(404); // raise 404 error
            return;
        }
        
        $matched_route = $this->routes[$route_index];
        
        // Execute middlewares
        $request_accepted = true;
        
        if (in_array("middlewares", array_keys($matched_route), true)) {
            foreach($matched_route["middlewares"] as $middleware) {
                if(call_user_func($middleware . "::exec")) {
                    continue;
                }
                else {
                    $request_accepted = false;
                    break;
                }
            }
        }
        
        // Finish request
        if ($request_accepted) {
            echo call_user_func($matched_route["controller"]);
        }
        else {
            $this->raiseErrorPage(401); // raise 401 error
        }
    }
    
    private function raiseErrorPage($code) {
        http_response_code($code);
        
        if(!isset($this->errors_controller)) {
            echo "THE SERVER RETURNED A <strong>${code}</strong> ERROR";
        }
        else {
            $controller = $this->errors_controller;
            echo $controller::${"error" . parse_str($code)};
        }
    }
}