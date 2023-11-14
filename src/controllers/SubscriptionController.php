<?php

namespace controllers;

use bases\BaseController;
use cores\Application;
use cores\Request;
use middlewares\UserMiddleware;
use models\SubscriptionModel;
use repositories\SubscriptionRepository;

require_once ROOT_DIR . "src/models/SubscriptionModel.php";
require_once ROOT_DIR . "src/repositories/SubscriptionRepository.php";

class SubscriptionController extends BaseController {
    public function __construct()
    {
        $this->registerMiddleware(new UserMiddleware(['createSubscription', 'getSubscription', 'getSubscriptionByUserId']));
    }

    public function createSubscription(Request $request)
    {
        $subscriptionModel = new SubscriptionModel();
        $user_id = Application::$app->loggedUser->getUserId();
        $premium_album_id = $request->getRouteParam('premium_album_id');
        $subscriptionModel->set('user_id', $user_id);
        $subscriptionModel->set('premium_album_id', $premium_album_id);
        Application::$app->response->setHeader("Content-Type", "text/xml");
        Application::$app->response->statusCode(200);
        print_r(SubscriptionRepository::getInstance()->createSubscription($subscriptionModel));
        exit;
    }

    public function getSubscription(Request $request)
    {
        $subscriptionModel = new SubscriptionModel();
        $user_id = Application::$app->loggedUser->getUserId();
        $premium_album_id = $request->getRouteParam('premium_album_id');
        $subscriptionModel->set('user_id', $user_id);
        $subscriptionModel->set('premium_album_id', $premium_album_id);
        Application::$app->response->setHeader("Content-Type", "text/xml");
        Application::$app->response->statusCode(200);
        print_r(SubscriptionRepository::getInstance()->getSubscription($subscriptionModel));
        exit;
    }

    public function getSubscriptionByUserId(Request $request)
    {
        $subscriptionModel = new SubscriptionModel();
        $user_id = Application::$app->loggedUser->getUserId();
        $page = 1;
        $size = 15;
        if (isset($request->getBody()['page'])) $page = $request->getBody()['page'];
        if (isset($request->getBody()['size'])) $size = $request->getBody()['size'];
        $subscriptionModel->set('user_id', $user_id);
        Application::$app->response->setHeader("Content-Type", "text/xml");
        Application::$app->response->statusCode(200);
        print_r(SubscriptionRepository::getInstance()->getSubscriptionByUserId($user_id, $page, $size));
        exit;
    }
}