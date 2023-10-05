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
        $this->registerMiddleware(new AuthMiddleware(['album']));
        $this->registerMiddleware(new AdminMiddleware(['albumAdmin', 'insertAlbum', 'updateAlbum', 'deleteAlbum']));
    }

    public function insertAlbum(Request $request)
    {
        $albumModel = new AlbumModel();

        if ($request->getMethod() === 'post') {
            $albumModel->loadData($request->getBody());
            if ($albumModel->validate() && AlbumRepository::getInstance()->insert($albumModel->toArray())) {
                Application::$app->session->setFlash('success', 'Album Inserted Successfully');


                // Application::$app->response->redirect('/homeAdmin');
                return;
            }
        }
        $this->setLayout('blank');
        return $this->render('album/insertAlbum', [
            'model' => $albumModel
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
                return;
            }
        }
        $this->setLayout('blank');
        return $this->render('album/updateAlbum', [
            'model' => $albumModelOld
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
        $this->setLayout('blank');
        return $this->render('album/deleteAlbum', [
            'model' => $albumModel
        ]);
    }

    public function album()
    {
        // Method : GET
//        $this->setLayout('main');
        return $this->render('album/home', [
            'name' => Application::$app->loggedUser->getUsername()
        ]);
    }

    public function albumAdmin()
    {
        // Method : GET
//        $this->setLayout('main');
        return $this->render('album/homeAdmin', [
            'name' => Application::$app->loggedUser->getUsername()
        ]);
    }

    public function __toString(): string
    {
        return 'AlbumController';
    }
}