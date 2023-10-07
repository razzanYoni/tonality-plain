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

class AlbumController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['albumUser', 'albumUserById']));
        $this->registerMiddleware(new AdminMiddleware(['albumAdmin', 'insertAlbum', 'updateAlbum', 'deleteAlbum', 'albumAdminById']));
    }

    // Admin
    public function albumAdmin()
    {
        // Method : GET
        $albumRepository = AlbumRepository::getInstance();
        $albums = $albumRepository->findAll();

        // print_r($albums);

        if ($request->getMethod() === 'get') {
            if ($albums) {
                Application::$app->session->setFlash('success', 'Albums Retrieved Successfully');
//                return;
            }
        }

       $this->setLayout('AlbumPage');
        return $this->render('album/AlbumAdmin', [
            'view' => [
                'allAlbums' => $albums
            ],
            'layout' => [
                'title' => 'Tonality'
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
        return $this->render('album/insertAlbum', [
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
        return $this->render('album/updateAlbum', [
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
            print_r($album_id);
            if ($albumModel->validate() && AlbumRepository::getInstance()->delete($album_id)) {
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


    public function albumAdminById(Request $request)
    {
        $album_id = $request->getRouteParam('album_id');
        $albumModel = new AlbumModel();
        $album = $albumModel->constructFromArray(
            AlbumRepository::getInstance()
                ->getAlbumById($album_id)
        );
        $where = ['album_id' => $album_id];

        if ($request->getMethod() === 'get') {
            if ($albumModel->validate() && AlbumRepository::getInstance()->findOne($where)) {
                Application::$app->session->setFlash('success', 'Album Retrieved Successfully');
                return;
            }
        }
        $this->setLayout('Album');
        return $this->render('albumAdmin/detailAlbum', [
            'view' => [
                'album' => $album,
            ],
            'layout' => [
                'title' => 'Album Detail - Tonality',
            ],
        ]);
    }

    // User
    public function albumUser(Request $request)
    {
        $albumRepository = AlbumRepository::getInstance();
        $albums = $albumRepository->findAll();

        // print_r($albums);

        if ($request->getMethod() === 'get') {
            if ($albums) {
                Application::$app->session->setFlash('success', 'Albums Retrieved Successfully');
//                return;
            }
        }

       $this->setLayout('AlbumPage');
        return $this->render('album/Album', [
            'view' => [
                'allAlbums' => $albums
            ],
            'layout' => [
                'title' => 'Tonality'
            ]
        ]);
    }

    public function albumUserById(Request $request)
    {
        $album_id = $request->getRouteParam('album_id');

        $albumRepository = AlbumRepository::getInstance();
        $album = $albumRepository->getSongsFromAlbum($album_id);

        // print_r($album);

        if ($request->getMethod() === 'get') {
            if ($album) {
                Application::$app->session->setFlash('success', 'Albums Retrieved Successfully');
                return;
            }
        }

       $this->setLayout('album');
        return $this->render('album/albumContent', [
            'view' => [
                'album' => $album
            ],
            'layout' => [
                'title' => 'Tonality'
            ]
        ]);
    }

    public function __toString(): string
    {
        return 'AlbumController';
    }
}
