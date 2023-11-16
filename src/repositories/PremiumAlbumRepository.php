<?php

namespace repositories;

require_once ROOT_DIR . 'src/clients/RESTClient.php';

use clients\RESTClient;
use cores\Application;
use models\SubscriptionModel;

class PremiumAlbumRepository
{
    private static $instance;
    private $restClient;

    private function __construct() {
        $this->restClient = new RESTClient($_ENV['REST_URL']);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PremiumAlbumRepository();
        }
        return self::$instance;
    }

    public function getPremiumAlbumById($premiumAlbumId) {
        return $this->restClient->handler(
            'premium-album'. '/' . $premiumAlbumId,
            "GET",
            [
            ],
        );
    }

    public function searchPremiumAlbum($searchQuery = null, $page = 1, $size = 10) {
        return $this->restClient->handler(
            'premium-album',
            "GET",
            [
                'searchQuery' => $searchQuery,
                'page' => $page,
                'size' => $size
            ],
        );
    }

    public function searchPremiumAlbumOwned($searchQuery = null, $page = 1, $size = 10) {
        $premiumAlbumIds = [];
        $subscriptionModel = new SubscriptionModel();
        $user_id = Application::$app->loggedUser->getUserId();
        $subscriptionModel->set('user_id', $user_id);
        $subscriptions = SubscriptionRepository::getInstance()->getSubscriptionByUserId($user_id, $page, $size);
        foreach ($subscriptions as $subscription) {
            $premiumAlbumIds[] = $subscription['premium_album_id'];
        }
        return $this->restClient->handler(
            'premium-album-owned',
            "GET",
            [
                'page' => $page,
                'size' => $size,
                'searchQuery' => $searchQuery,
                'premiumAlbumIds' => $premiumAlbumIds
            ],
        );
    }
}
