<?php

namespace bases;

require_once ROOT_DIR . "src/cores/Controller.php";

use exceptions,
    cores\Controller;

class BaseController extends Controller
{
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