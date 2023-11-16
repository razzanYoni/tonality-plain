<?php

namespace repositories;

require_once ROOT_DIR . 'src/clients/RESTClient.php';

use clients\RESTClient;
use cores\Application;
use models\SubscriptionModel;

class PremiumSongRepository
{
    private static $instance;
    private $restClient;

    private function __construct() {
        $this->restClient = new RESTClient($_ENV['REST_URL']);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PremiumSongRepository();
        }
        return self::$instance;
    }

    public function getPremiumSong($premiumAlbumId) {
        $subscriptionModel = new SubscriptionModel();
        $user_id = Application::$app->loggedUser->getUserId();
        $subscriptionModel->set('user_id', $user_id);
        $subscriptionModel->set('premium_album_id', $premiumAlbumId);
        $subscription = SubscriptionRepository::getInstance()->getSubscription($subscriptionModel);

        // TODO : convert to subscription model

        return [$this->restClient->handler('premium-song',
            "GET",
            [
                'albumId' => $premiumAlbumId
            ],
        ), $subscription->status];
    }
}