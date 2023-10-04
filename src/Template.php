<?php

namespace PHPUtils;

use PHPUtils\Globals;


class Template {
    public $url;
    public $variables;

    public function __construct($url, $variables) {
        $this->url = $url;
        $this->variables = $variables;
    }
    
    public function render() {
        $keys = array_keys($this->variables);
        $content = NULL;
        
        foreach ($keys as $key) {
            ${$key} = $this->variables[$key];
        }
        
        ob_start();
        include Globals::$ROOT . "/resources/templates/" . $this->url;
        
        $content = ob_get_clean();
        
        foreach ($keys as $key) {
            unset(${$key});
        }
        
        return $content;
    }
}