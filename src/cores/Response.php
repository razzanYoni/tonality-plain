<?php

namespace cores;

class Response
{
    public function setHeader(string $key, string $value)
    {
        header("$key: $value");
    }

    public function statusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}