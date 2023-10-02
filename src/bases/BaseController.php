<?php

use exceptions;

abstract class BaseController {
    protected static $instance;
    protected $service;

    protected function __construct($service) {
        $this->service = $service;
    }
    
    public static function getInstance($service) {
        if (!isset(self::$instance)) {
            self::$instance = new static($service);
        }
        return self::$instance;
    }

    protected function get($urlParameters) {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }

    protected function post($urlParameters) {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }

    protected function put($urlParameters) {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }

    protected function delete($urlParameters) {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }
}