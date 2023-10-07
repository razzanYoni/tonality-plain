<?php

namespace controllers;

require_once ROOT_DIR . "src/middlewares/AuthMiddleware.php";
require_once ROOT_DIR . "src/middlewares/AdminMiddleware.php";
require_once ROOT_DIR . "src/repositories/AlbumRepository.php";
require_once ROOT_DIR . "src/models/AlbumModel.php";

use bases\BaseController,
    middlewares\AuthMiddleware,
    middlewares\AdminMiddleware;
use cores\Application,
    cores\Request;
use repositories\AlbumRepository,
    models\AlbumModel;
use repositories\SongRepository,
    exceptions\NotFoundException;

class AlbumController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['albumUser', 'albumUserById']));
        $this->registerMiddleware(new AdminMiddleware(['albumAdmin', 'insertAlbum', 'updateAlbum', 'deleteAlbum', 'albumAdminById']));
    }

    // Admin
    public function albumAdmin(Request $request)
    {
        // Method : GET
        $requestBody = $request->getBody();

        $page = 1;
        if (isset($requestBody['page'])) {
            $page = $requestBody['page'];
        }

        $limit = ROWS_PER_PAGE;
        $offset = ($page - 1) * ROWS_PER_PAGE;

        $where = [];
        if (isset($requestBody['genre'])) {
            $where['genre'] = $requestBody['genre'];
        }

        $where_like = '';
        if (isset($requestBody['search'])) {
            $where_like = $requestBody['search'];
        }

        $orderBy = 'album_name';
        if (isset($requestBody['order'])) {
            $orderBy[$requestBody['order']] = $requestBody['order'];
        }

        $is_desc = false;
        if (isset($requestBody['is_desc'])) {
            $is_desc = $requestBody['is_desc'] === 'desc';
        }

        $albumRepository = AlbumRepository::getInstance();
        $albums = $albumRepository->getAllAlbum(
            order: $orderBy,
            is_desc: $is_desc,
            where: $where,
            where_like: $where_like,
            limit: $limit,
            offset: $offset,
        );

        $countAlbums = $albumRepository->getCountAlbums(
            where: $where,
            where_like: $where_like,
        );
        $totalPage = ceil($countAlbums / ROWS_PER_PAGE);

        if ($request->getMethod() === 'get') {
            if ($albums) {
                Application::$app->session->setFlash('success', 'Albums Retrieved Successfully');
                // return;
            }
        }

        $this->setLayout('AlbumPage');
        return $this->render('album/albumAdmin', [

            'view' => [
                'albums' => $albums
            ],
            'layout' => [
                'title' => 'Tonality',
                'totalPage' => $totalPage,
                'page' => $page,
            ]
        ]);
    }

    public function insertAlbum(Request $request)
    {
        $albumModel = new AlbumModel();

        if ($request->getMethod() === 'post') {
            $albumModel->loadData($request->getBody());
            if ($albumModel->validate() && AlbumRepository::getInstance()->insert($albumModel->toArray())) {
                Application::$app->session->setFlash('success', 'Album Inserted Successfully');

                Application::$app->response->redirect('/albumAdmin/insertAlbum');
                return;
            }
        }
        $this->setLayout('AlbumForm');
        return $this->render('album/InsertAlbum', [
            'view' => [
                'model' => $albumModel
                ],
            'layout' => [
                'title' => 'Add Album - Tonality'
            ]
        ]);
    }

    public function updateAlbum(Request $request)
    {
        $albumModelOld = new AlbumModel();
        $album_id = $request->getRouteParam('album_id');
        $albumModelOld->constructFromArray(
            AlbumRepository::getInstance()
                ->getAlbumById($album_id)
        );

        if ($request->getMethod() === 'post') {
            $albumModelNew = new AlbumModel();
            $albumModelNew->set('album_id', $album_id);
            $albumModelNew->loadData($request->getBody());
            if ($albumModelNew->validate() && AlbumRepository::getInstance()
                    ->update(
                        $album_id,
                        data: $albumModelNew->toArray()
                    )) {
                Application::$app->session->setFlash('success', 'Album Edited Successfully');
                Application::$app->response->redirect('/albumAdmin/{album_id:\d+}/updateAlbum');
                return;
            }
        }
        $this->setLayout('AlbumForm');
        return $this->render('album/EditAlbum', [
            'view' => [
                'model' => $albumModelOld
            ],
            'layout' => [
                'title' => 'Update Album - Tonality'
            ]
        ]);
    }

    public function deleteAlbum(Request $request)
    {
        $albumModel = new AlbumModel();
        if ($request->getMethod() === 'delete') {
            $albumModel->loadData($request->getBody());
            $album_id = $request->getBody();
            // print_r($album_id);
            if (AlbumRepository::getInstance()->delete($album_id)) {
                Application::$app->session->setFlash('success', 'Album Deleted Successfully');
                return;
            }
        }
        $this->setLayout('AlbumForm');
        return $this->render('albumAdmin/deleteAlbum', [

            'view' => [
                'model' => $albumModel
            ],
            'layout' => [
                'title' => 'Delete Album - Tonality'
            ]
        ]);
    }


    /**
     * @throws NotFoundException
     */
    public function albumAdminById(Request $request)
    {
        $album_id = $request->getRouteParam('album_id');

        $album = AlbumRepository::getInstance()->getAlbumById($album_id);

        if (!$album) {
            Application::$app->session->setFlash('error', 'Album Not Found');
            throw new NotFoundException("Album Not Found", 404);
            // return;
        }

        $albumModel = new AlbumModel();
        $albumModel = $albumModel->constructFromArray($album);

        $songRepository = SongRepository::getInstance();
        $songs = $songRepository->getSongsFromAlbum($album_id);

        if (!$songs) {
            $songs = [];
        }

        Application::$app->session->setFlash('success', 'Album Retrieved Successfully');

        $this->setLayout('AlbumContent');
        return $this->render('album/AlbumContentAdmin', [
            'view' => [
                'album' => $albumModel,
                'songs' => $songs
            ],
            'layout' => [
                'title' => 'Album Detail - Tonality',
            ],
        ]);
    }

    // User
    public function albumUser(Request $request)
    {
        // Method : GET
        $requestBody = $request->getBody();

        $page = 1;
        if (isset($requestBody['page'])) {
            $page = $requestBody['page'];
        }

        $limit = ROWS_PER_PAGE;
        $offset = ($page - 1) * ROWS_PER_PAGE;

        $where = [];
        if (isset($requestBody['genre'])) {
            $where['genre'] = $requestBody['genre'];
        }

        $where_like = '';
        if (isset($requestBody['search'])) {
            $where_like = $requestBody['search'];
        }

        $orderBy = 'album_name';
        if (isset($requestBody['order'])) {
            $orderBy[$requestBody['order']] = $requestBody['order'];
        }

        $is_desc = false;
        if (isset($requestBody['is_desc'])) {
            $is_desc = $requestBody['is_desc'] === 'desc';
        }

        $albumRepository = AlbumRepository::getInstance();
        $albums = $albumRepository->getAllAlbum(
            order: $orderBy,
            is_desc: $is_desc,
            where: $where,
            where_like: $where_like,
            limit: $limit,
            offset: $offset,
        );

        $countAlbums = $albumRepository->getCountAlbums(
            where: $where,
            where_like: $where_like,
        );
        $totalPage = ceil($countAlbums / ROWS_PER_PAGE);

        if ($request->getMethod() === 'get') {
            if ($albums) {
                Application::$app->session->setFlash('success', 'Albums Retrieved Successfully');
//                return;
            }
        }

        $this->setLayout('AlbumPage');
        return $this->render('album/albumUser', [
            'view' => [
                'albums' => $albums
            ],
            'layout' => [
                'title' => 'Tonality',
                'totalPage' => $totalPage,
                'page' => $page,
            ]
        ]);
    }

    public function albumUserById(Request $request)
    {
        $album_id = $request->getRouteParam('album_id');

        $album = AlbumRepository::getInstance()->getAlbumById($album_id);

        if (!$album) {
            Application::$app->session->setFlash('error', 'Album Not Found');
            throw new NotFoundException("Album Not Found", 404);
        }

        $albumModel = new AlbumModel();
        $albumModel = $albumModel->constructFromArray($album);

        $songRepository = SongRepository::getInstance();
        $songs = $songRepository->getSongsFromAlbum($album_id);

        if (!$songs) {
            $songs = [];
        }

        Application::$app->session->setFlash('success', 'Album Retrieved Successfully');

       $this->setLayout('AlbumContent');
        return $this->render('album/albumContentUser', [
            'view' => [
                'album' => $albumModel,
                'songs' => $songs
            ],
            'layout' => [
                'title' => 'Album Detail - Tonality'
            ]
        ]);
    }

    public function __toString(): string
    {
        return 'AlbumController';
    }
}
