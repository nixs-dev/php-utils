<?php

namespace App\Utils;


class Response {
    public $content;
    public $error;
    public $redirect;
    
    public function __construct($content, $error=false, $redirect=false) {
        $this->content = $content;
        $this->error = $error;
        $this->redirect = $redirect;
    }
    
    public function json() {
        return json_encode($this);
    }
}