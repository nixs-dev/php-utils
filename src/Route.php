<?php 

namespace PHPUtils;


class Route {
    private $name;
    private $groups;
    private $controller;
    private $middlewares;
    
    public function __construct ($name, $controller, $groups=[], $middlewares=[]) {
        $this->name = $name;
        $this->controller = $controller;
        $this->groups = $groups;
        $this->middlewares = $middlewares;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getController() {
        return $this->controller;
    }
    
    public function getGroups() {
        return $this->groups;
    }
    
    public function getMiddlewares() {
        return $this->middlewares;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setController($controller) {
        $this->controller = $controller;
    }
    
    public function setGroups($groups) {
        $this->groups = $groups;
    }
    
    public function setMiddlewares($middlewares) {
        $this->middlewares = $middlewares;
    }
    
    public function addMiddlewares($middlewares) {
        if (gettype($middlewares) == "array") {
            $this->middlewares = array_merge($this->middlewares, $middlewares);
        }
        else {
            array_push($this->middlewares, $middlewares);
        }
    }
}