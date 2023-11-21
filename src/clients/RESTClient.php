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
        if ((!isset($_ENV['REST_ACCESS_TOKEN'])) || (!isset($_ENV['Secure-fingerprint'])) || (!$this->verify_token())) {
            $this->login();
        }

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-KEY: ' . $_ENV['REST_API_KEY'],
        ];

        if (isset($_ENV['REST_ACCESS_TOKEN'])) {
            $headers[] = 'Authorization: Bearer ' . $_ENV['REST_ACCESS_TOKEN'];
        }
        if (isset($_ENV['Secure-fingerprint'])) {
            $headers[] = 'Cookie: Secure-fingerprint=' . $_ENV['Secure-fingerprint'];
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->base_url . $function_name_or_param);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = null;
        try {
            $response = curl_exec($curl);
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
        return json_decode($response, true);
    }

    public function login() {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-KEY: ' . $_ENV['REST_API_KEY'],
        ];

        if (isset($_ENV['REST_ACCESS_TOKEN'])) {
            $headers[] = 'Authorization: Bearer ' . $_ENV['REST_ACCESS_TOKEN'];
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->base_url . "api/login");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
            [
                'username' => $_ENV['REST_USERNAME'],
                'password' => $_ENV['REST_PASSWORD']
            ]
        ));
        if (isset($_ENV['Secure-fingerprint'])) {
            curl_setopt($curl, CURLOPT_COOKIE, $_ENV['Secure-fingerprint']);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = null;
        curl_setopt($curl, CURLOPT_HEADER, 1);
        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $secure_fingerprint = substr($header, strpos($header, 'Secure-fingerprint'));
        $secure_fingerprint =  explode("\r\n", $secure_fingerprint);
        $secure_fingerprint =  $secure_fingerprint[0];
        $secure_fingerprint = substr($secure_fingerprint, strpos($secure_fingerprint, '=') + 1);
        $response = substr($response, strpos($response, '{'));
        $response = json_decode($response, true);
        putenv('Secure-fingerprint=' . $secure_fingerprint);
        putenv('REST_ACCESS_TOKEN=' . $response["accessToken"]);
        $_ENV['Secure-fingerprint'] = $secure_fingerprint;
        $_ENV['REST_ACCESS_TOKEN'] = $response["accessToken"];
    }

    public function verify_token() {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-KEY: ' . $_ENV['REST_API_KEY'],
        ];

        if (isset($_ENV['REST_ACCESS_TOKEN'])) {
            $headers[] = 'Authorization: Bearer ' . $_ENV['REST_ACCESS_TOKEN'];
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->base_url . "api/verify-token");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        if (isset($_ENV['Secure-fingerprint'])) {
            curl_setopt($curl, CURLOPT_COOKIE, $_ENV['__Secure-fingerprint']);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        return $response["status"] == 200;
    }
}