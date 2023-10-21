<?php

namespace PHPUtils;

use PHPUtils\Globals;
use PHPUtils\Request;


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
        
        $request = new Request();
        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $route_params = [];

        $request->setPath($url);
        $request->setMethod($_SERVER['REQUEST_METHOD']);


        foreach ($this->routes as $route) {
            foreach ($route->getGroups() as $group) {
                $route->addMiddlewares($group->getMiddlewares());
            }
        }

        $matched_route = array_filter($this->routes, function ($r) use (&$url, &$route_params, &$request) {
            if($r->getMethod() != $_SERVER['REQUEST_METHOD']) {
                return false;
            }

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
                        if($splitted_url[$i] !== '') {
                            $route_param = str_replace('}', '', str_replace('{', '', $args[0]));

                            $route_params[$route_param] = $splitted_url[$i];
                            $request->addParam($route_param, $splitted_url[$i]);
                        }
                        else {
                            return false;
                        }
                    }
                }
            }

            return true;
        });

        foreach ($_GET as $key => $value) {
            $request->addQuery($key, $value);
        }

        foreach ($_POST as $key => $value) {
            $request->addData($key, $value);
        }


        if (!$matched_route) {
            $this->raiseErrorPage(404);
            return;
        }
        
        $matched_route = reset($matched_route);



        //                 NOW JUST FINISH REQUEST                 //



        $request_accepted = true;
        
        foreach($matched_route->getMiddlewares() as $middleware) {
            if(call_user_func_array($middleware . "::exec", [$request])) {
                continue;
            }
            else {
                $request_accepted = false;
                break;
            }
        }

        if ($request_accepted) {
            echo count(call_user_func_array($matched_route->getController(), [$request]));
        }
        else {
            $this->raiseErrorPage(401);
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