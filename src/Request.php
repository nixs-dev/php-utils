<?php

namespace PHPUtils;


class Request {
    public $path;
    public $method;
    public $params;
    public $query;
    public $data;


    public function __construct()
    {
        $this->params = [];
        $this->query = [];
        $this->data = [];
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function addQuery($key, $value)
    {
        $this->query[$key] = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }
    
    public function setMethod($method): self
    {
        $this->method = $method;

        return $this;
    }
}