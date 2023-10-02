<?php

namespace bases;

use exceptions;

abstract class BaseController {
    protected static $instance;
    protected static $srv;

    protected function __construct($srv)
    {
        $this->srv = $srv;
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static(null);
        }
        return self::$instance;
    }
    
    protected function get($urlParams) {
        throw new exceptions\MethodNotAllowedException("Method not allowed");  
    }

    protected function post($urlParams) {
        throw new exceptions\MethodNotAllowedException("Method not allowed");  
    }
    
    protected function put($urlParams) {
        throw new exceptions\MethodNotAllowedException("Method not allowed");  
    }
    
    protected function delete($urlParams) {
        throw new exceptions\MethodNotAllowedException("Method not allowed");
    }

    public function handle($method, $urlParameters) {
        echo strtolower($method)($urlParameters);
    }
}