<?php

namespace bases;

abstract class BaseClient
{
    public function handler($function_name_or_param, $method, $data) {
        $response = $this->request($function_name_or_param, $method, $data);
        return $this->response_data_parser($response);
    }
    abstract public function request($function_name_or_param, $method, $data);
    abstract public function response_data_parser($response);
}