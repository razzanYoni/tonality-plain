<?php

namespace clients;


class SOAPClient
{
    private $ws_url;
    private $url;

    public function __construct(string $url, string $ws_url)
    {
        $this->url = $url;
        $this->ws_url = $ws_url;
    }

    public function soapHandler(
        string $function_name,
        array $data,
    ) {
        $response = $this->soapRequest($function_name, $data);
        return $this->soapResponseDataParser($response);
    }

    public function soapRequest(
        string $function_name,
        array $data
    ) {
        $envelope = '<?xml version="1.0" encoding="utf-8"?>';
        $envelope .= '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">';
        $envelope .= '<Body>';
        $envelope .= '<' . $function_name . ' xmlns="' . $this->ws_url . '">';
        foreach ($data as $key => $value) {
            if ($value != null) {
                $envelope .= '<' . $key . ' xmlns="">' . $value . '</' . $key . '>';
            }
        }
        $envelope .= '</' . $function_name . '>';
        $envelope .= '</Body>';
        $envelope .= '</Envelope>';

        $headers = [
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: ' . $this->ws_url . $function_name,
            'X-API-KEY: ' . $_ENV['SOAP_API_KEY'],
            'Accept: text/xml',
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $envelope);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = null;
        try {
            $response = curl_exec($curl);
            if ($response === false) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }
        } catch (\Exception $e) {
            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR);
        }
        curl_close($curl);
        return $response;
    }

    public function soapResponseDataParser($response)
    {
        // TODO : add parser if needed
        return $response;
    }
}