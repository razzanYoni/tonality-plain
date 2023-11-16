<?php

namespace controllers;

require_once ROOT_DIR . 'src/repositories/PremiumAlbumRepository.php';

use bases\BaseController;
use cores\Application;
use cores\Request;
use exceptions\NotFoundException;
use middlewares\UserMiddleware;
use models\PremiumAlbumModel;
use repositories\PremiumAlbumRepository;
use repositories\PremiumSongRepository;

class PremiumAlbumController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new UserMiddleware(['searchPremiumAlbums', 'getPremiumAlbum', 'getPremiumAlbumOwned']));
    }

    public function searchPremiumAlbums(Request $request) {
        $page = 1;
        $size = ROWS_PER_PAGE;
        $searchQuery = '';
        if (isset($request->getBody()['page'])) $page = $request->getBody()['page'];
        if (isset($request->getBody()['size'])) $size = $request->getBody()['size'];
        if (isset($request->getBody()['searchQuery'])) $searchQuery = $request->getBody()['searchQuery'];
        $premiumAlbums = PremiumAlbumRepository::getInstance()->searchPremiumAlbum($page, $size, $searchQuery);
        $premiumAlbumsTotalPage = ceil($premiumAlbums->paging->totalAlbums / ROWS_PER_PAGE);
        $premiumAlbums = $premiumAlbums->data;

        $this->setLayout('PremiumAlbumPage');
        return $this->render('PremiumAlbumPage', [
            'view' => [
                'premiumAlbums' => $premiumAlbums,
                'premiumAlbumsCount' => $premiumAlbumsTotalPage,
                'page' => $page,
                'size' => $size,
            ],
            'layout' => [
                'title' => 'Premium Albums'
            ]
        ]);
    }

    public function searchPremiumAlbumOwned(Request $request) {
        $page = 1;
        $size = ROWS_PER_PAGE;
        $searchQuery = '';
        if (isset($request->getBody()['page'])) $page = $request->getBody()['page'];
        if (isset($request->getBody()['size'])) $size = $request->getBody()['size'];
        if (isset($request->getBody()['searchQuery'])) $searchQuery = $request->getBody()['searchQuery'];
        $premiumAlbums = PremiumAlbumRepository::getInstance()->searchPremiumAlbumOwned($page, $size, $searchQuery);
        $premiumAlbumsTotalPage = ceil($premiumAlbums->paging->totalAlbums / ROWS_PER_PAGE);
        $premiumAlbums = $premiumAlbums->data;

        // TODO : UI
    }

    public function premiumAlbumById(Request $request) {
        $premium_album_id = $request->getRouteParam('premium_album_id');

        $premium_album = PremiumAlbumRepository::getInstance()->getPremiumAlbumById($premium_album_id);

        if (!$premium_album) {
            Application::$app->session->setFlash('error', 'Premium album not found');
            throw new NotFoundException("Premium Album Not Found", 404);
        }

        $premiumAlbumModel = new PremiumAlbumModel();
        $premiumAlbumModel->constructFromArray($premium_album->data);

        $premiumSongs = PremiumSongRepository::getInstance()->getPremiumSong($premium_album_id);
        $countPremiumSongs = count($premiumSongs);

        $duration = $premium_album->duration;

        if (!$premiumSongs) {
            $premiumSongs = [];
        }

        Application::$app->session->setFlash('success', 'Premium album Retrieved successfully');

        // TODO : UI
    }
}