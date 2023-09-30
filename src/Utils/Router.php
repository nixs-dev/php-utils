<?php

namespace App\Utils;

use App\Utils\Globals;


class Router {
    public $routes;
    private $error_route;
    
    public function __construct($routes=NULL, $error_route=NULL) {
        $this->routes = $routes;
        $this->error_route = $error_route;
    }
    
    public function getRoutes() {
        return $this->routes;
    }
    
    public function setRoutes($routes) {
        $this->routes = $routes;
    }
    
    public function setErrorRoute($handler) {
        $this->error_route = $handler;
    }
    
    public function run() {
        Globals::set("ROUTER", $this);
        
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $route_params = [];
        
        // Setup routes groups
        foreach ($this->routes as $route) {
            foreach ($route->getGroups() as $group) {
                $route->addMiddlewares($group->getMiddlewares());
            }
        }
        
        // Try match a route
        $matched_route = array_filter($this->routes, function ($r) use (&$url, &$route_params) {
            if($r->getName() == $url) {
                return true;
            }

            $splitted_route = explode("/", $r->getName());
            $splitted_url = explode("/", $url);

            if(count($splitted_route) != count($splitted_url)) {
                return false;
            }

            for($i = 0; $i < count($splitted_route); $i++) {
                if(!($splitted_route[$i] == $splitted_url[$i])) {
                    $args = [];

                    if(!preg_match("/{.+}/", $splitted_route[$i], $args)) {
                        return false;
                    }
                    else {
                        $route_params[str_replace('}', '', str_replace('{', '', $args[0]))] = $splitted_url[$i];
                    }
                }
            }

            return true;
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
            echo count(array_keys($route_params)) > 0 ? call_user_func_array($matched_route->getController(), array_values($route_params)) : call_user_func($matched_route->getController());
        }
        else {
            $this->raiseErrorPage(401); // raise 401 error
        }
    }
    
    public function raiseErrorPage($code, $message=NULL) {
        http_response_code($code);
        
        if(isset($this->error_route)) {
            $handler = $this->error_route;
            
            self::redirect($handler);
        }
    }
    
    public function redirect ($url) {
        header("location: $url");
        die();
    }
}