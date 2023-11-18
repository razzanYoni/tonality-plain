<?php

namespace clients;

require_once ROOT_DIR . 'src/bases/BaseClient.php';

use bases\BaseClient;
use SoapClient;

class TonalitySOAPClient extends BaseClient
{
    private SoapClient $soapClient;
    private $ws_url;

    /**
     * @throws \SoapFault
     */
    public function __construct(string $url, string $ws_url)
    {
        $this->soapClient = new SoapClient(
            $url . '?wsdl',
            array(
                "exceptions" => 0,
                "trace" => 1,
                'stream_context' => stream_context_create(array(
                    'http' => array(
                        'header' => 'X-API-KEY: ' . $_ENV['SOAP_API_KEY']
                    ),
                )),
            )
        );
        $this->ws_url = $ws_url;
    }

    public function request(
        $function_name_or_param,
        $method,
        $data
    ) {
    $response = null;
        try {
            $response = $this->soapClient->__soapCall(
                $function_name_or_param,
                [
                    'parameters' => $data,
                ]
            );
        } catch (\Exception $e) {
            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }
        return $response;
    }

    public function response_data_parser($response)
    {
        return $response;
    }

}
