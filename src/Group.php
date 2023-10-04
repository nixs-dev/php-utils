<?php 

namespace PHPUtils;

class Group {
    private $name;
    private $middlewares;
    
    public function __construct ($name, $middlewares=[]) {
        $this->name = $name;
        $this->middlewares = $middlewares;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getMiddlewares() {
        return $this->middlewares;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setMiddlewares($middlewares) {
        $this->middlewares = $middlewares;
    }
}