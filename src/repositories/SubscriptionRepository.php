<?php

namespace repositories;

require_once __DIR__ . '/../clients/SOAPClient.php';

// https://www.w3docs.com/snippets/php/how-to-send-a-post-request-with-php.html
use clients\SOAPClient;

class SubscriptionRepository
{
    private static $instance;
    private $soapClient;

    private function __construct() {
        $this->soapClient = new SOAPClient($_ENV['SOAP_URL'] . "subscription", $_ENV['SOAP_WS_URL']);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new SubscriptionRepository();
        }
        return self::$instance;
    }


    public function createSubscription($subscriptionModel) {
        return $this->soapClient->handler(
            'createSubscription',
            "POST",
            $subscriptionModel->toArray(),
        );
    }

    public function getSubscription($subscriptionModel) {
        return $this->soapClient->handler(
            'getSubscription',
            "POST",
            $subscriptionModel->toArray(),
        );
    }

    public function getSubscriptionByUserId($userId, $page, $size) {
        return $this->soapClient->handler(
            'getSubscriptionsByUserId',
            "POST",
            [
                'userId' => $userId,
                'page' => $page,
                'size' => $size
            ],
        );
    }
}