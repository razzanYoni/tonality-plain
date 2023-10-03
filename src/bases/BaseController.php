<?php

namespace bases;

use exceptions;
use exceptions\MethodNotAllowedException;

abstract class BaseController
{
    protected static BaseController $instance;
    protected BaseService $service;

    protected function __construct($service)
    {
        $this->service = $service;
    }

    public static function getInstance($service): BaseController|static
    {
        if (!isset(self::$instance)) {
            self::$instance = new static($service);
        }
        return self::$instance;
    }

    /**
     * @throws MethodNotAllowedException
     */
    protected function get($urlParameters)
    {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }

    /**
     * @throws MethodNotAllowedException
     */
    protected function post($urlParameters)
    {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }

    /**
     * @throws MethodNotAllowedException
     */
    protected function put($urlParameters)
    {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }

    /**
     * @throws MethodNotAllowedException
     */
    protected function delete($urlParameters)
    {
        throw new exceptions\MethodNotAllowedException("Method Not Allowed");
    }
}