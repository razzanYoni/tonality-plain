<?php

namespace repositories;

require_once __DIR__ . '/../clients/TonalitySOAPClient.php';

// https://www.w3docs.com/snippets/php/how-to-send-a-post-request-with-php.html
use clients\TonalitySOAPClient;
use models\SubscriptionModel;

class SubscriptionRepository
{
    private static $instance;
    private $soapClient;

    private function __construct() {
        $this->soapClient = new TonalitySOAPClient($_ENV['SOAP_URL'] . "subscription", $_ENV['SOAP_WS_URL']);
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
        $subscription = $this->soapClient->handler(
            'getSubscription',
            "POST",
            $subscriptionModel->toArray(),
        )->subscription;

        $subscriptionModel->set('status', $subscription->status);

        return $subscriptionModel->toArray();
    }

    public function getSubscriptionByUserId($userId, $page, $size) {
        $subscriptions = [];
        foreach ($this->soapClient->handler(
            'getSubscriptionsByUserId',
            "POST",
            [
                'userId' => $userId,
                'page' => $page,
                'size' => $size
            ],
        )->subscription as $value) {
            $subscriptionModel = new SubscriptionModel();
            $subscriptionModel->set('user_id', $value->userId);
            $subscriptionModel->set('premium_album_id', $value->premiumAlbumId);
            $subscriptionModel->set('status', $value->status);
            $subscriptions[] = $subscriptionModel->toArray();
        }
        return $subscriptions;
    }
}