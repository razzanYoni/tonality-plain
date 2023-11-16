<?php

namespace controllers;

require_once ROOT_DIR . "src/middlewares/AdminMiddleware.php";
require_once ROOT_DIR . "src/middlewares/UserMiddleware.php";
require_once ROOT_DIR . "src/repositories/AlbumRepository.php";
require_once ROOT_DIR . "src/models/AlbumModel.php";

use bases\BaseController;
use cores\Application;
use cores\Request;
use exceptions\NotFoundException;
use middlewares\AdminMiddleware;
use middlewares\UserMiddleware;
use models\AlbumModel;
use repositories\AlbumRepository;
use repositories\SongRepository;

class AlbumController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new UserMiddleware(['albumUser', 'albumUserById', ]));
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
        if ($totalPage == 0) {
            $page = 0;
        }

        if (!$albums) {
            $albums = [];
            // return;
        }

        if ($request->getHeader("Content-Type") === 'application/json') {
            $resultJson = array();
            $resultJson['totalPage'] = json_encode($totalPage);
            $resultJson['is_admin'] = json_encode((int)Application::$app->loggedUser->isAdmin());

            $data = array();
            foreach ($albums as $album) {
                $albumModel = new AlbumModel();
                $albumModel->constructFromArray($album);
                $dataTemp = $albumModel->toArray();
                $dataTemp['album_id'] = $album['album_id'];
                $data[] = $dataTemp;
            }

            $resultJson['data'] = json_encode($data);
            $resultJson['totalData'] = json_encode($countAlbums);

            print_r(json_encode($resultJson));
            exit;
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
                'is_admin' => true
            ]
        ]);
    }

    public function insertAlbum(Request $request)
    {
        $albumModel = new AlbumModel();

        if ($request->isPost()) {
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

        if ($request->isPost()) {
            $albumModelNew = new AlbumModel();
            $albumModelNew->set('album_id', $album_id);
            $albumModelNew->loadData($request->getBody());
            if ($albumModelNew->validate() && AlbumRepository::getInstance()
                    ->update(
                        $album_id,
                        data: $albumModelNew->toArray()
                    )) {
                Application::$app->session->setFlash('success', 'Album Edited Successfully');
                Application::$app->response->redirect('/albumAdmin/' . $album_id);
                return;
            }
        }
        $this->setLayout('AlbumForm');
        return $this->render('album/UpdateAlbum', [
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
        $album_id = $request->getRouteParam('album_id');
        if ($request->isDelete()) {
            if (AlbumRepository::getInstance()->delete($album_id)) {
                Application::$app->session->setFlash('success', 'Album Deleted Successfully');
            }
        }

        Application::$app->response->redirect('/albumAdmin');
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

        $countSongs = $songRepository->getCountSongsFromAlbum($album_id);

        $duration = $songRepository->getAlbumDuration($album_id);

        if (!$songs) {
            $songs = [];
        }

        Application::$app->session->setFlash('success', 'Album Retrieved Successfully');

        $this->setLayout('AlbumContent');
        return $this->render('album/AlbumContentAdmin', [
            'view' => [
                'album' => $albumModel,
                'songs' => $songs,
                'count_song' => $countSongs,
                'duration' => $duration
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
        if ($totalPage == 0) {
            $page = 0;
        }

        if ($request->getMethod() === 'get') {
            if ($albums) {
                Application::$app->session->setFlash('success', 'Albums Retrieved Successfully');
//                return;
            }
        }

        if (!$albums) {
            $albums = [];
            // return;
        }

        if ($request->getHeader("Content-Type") === 'application/json') {
            $resultJson = array();
            $resultJson['totalPage'] = json_encode($totalPage);
            $resultJson['is_admin'] = json_encode((int)Application::$app->loggedUser->isAdmin());

            $data = array();
            foreach ($albums as $album) {
                $albumModel = new AlbumModel();
                $albumModel->constructFromArray($album);
                $dataTemp = $albumModel->toArray();
                $dataTemp['album_id'] = $album['album_id'];
                $data[] = $dataTemp;
            }

            $resultJson['data'] = json_encode($data);
            $resultJson['totalData'] = json_encode($countAlbums);

            print_r(json_encode($resultJson));
            exit;
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
                'is_admin' => false,
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

        $countSongs = $songRepository->getCountSongsFromAlbum($album_id);

        $duration = $songRepository->getAlbumDuration($album_id);

        if (!$songs) {
            $songs = [];
        }

        Application::$app->session->setFlash('success', 'Album Retrieved Successfully');

        $this->setLayout('AlbumContent');
        return $this->render('album/albumContentUser', [
            'view' => [
                'album' => $albumModel,
                'songs' => $songs,
                'count_song' => $countSongs,
                'duration' => $duration
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