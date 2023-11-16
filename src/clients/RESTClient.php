<?php

namespace clients;

use bases\BaseClient;

class RESTClient extends BaseClient
{
    private $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
    }

    public function request($function_name_or_param, $method, $data)
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-KEY: ' . $_ENV['REST_API_KEY'],
        ];

        if (isset($_SERVER['REST_AUTH_TOKEN'])) {
            $headers[] = 'Authorization: Bearer ' . $_SERVER['REST_AUTH_TOKEN'];
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->base_url . $function_name_or_param);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        if (isset($_SERVER['__Secure-fingerprint'])) {
            curl_setopt($curl, CURLOPT_COOKIE, $_SERVER['__Secure-fingerprint']);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = null;
        try {
            $response = curl_exec($curl);

            if ($response === false) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }

            if ($function_name_or_param === "login") {
                $response = json_decode($response, true);
                $_SERVER['REST_AUTH_TOKEN'] = $response['data']['token'];
                $_SERVER['__Secure-fingerprint'] = $response['headers']['Set-Cookie'];
            }

            $response = json_decode($response, true);
            if (isset($response['title']) &&
                (
                strcmp($response['title'], 'Your access token is missing.')
            ||  strcmp($response['title'], 'Your access token is expired.')
            ||  strcmp($response['title'], 'Your access token is invalid.')
            ||  strcmp($response['title'], 'Authorization header not set.')
                )
            ) {
                $this->request(
                    "login",
                    "POST",
                    [
                        'username' => $_ENV['REST_USERNAME'],
                        'password' => $_ENV['REST_PASSWORD']
                    ]
                );

                $response = curl_exec($curl);
            }

        } catch (\Exception $e) {
            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        } finally {
            curl_close($curl);
        }
        return $response;
    }

    public function response_data_parser($response)
    {
//        return json_decode($response, true);
        return $response;
    }
}