<?php

namespace controllers;

require_once ROOT_DIR . "src/models/SongModel.php";
require_once ROOT_DIR . "src/repositories/SongRepository.php";

use bases\BaseController,
    cores\Application,
    cores\Request,
    middlewares\AdminMiddleware,
    models\SongModel,
    repositories\SongRepository;
use middlewares\AuthMiddleware;

class SongController extends BaseController {
    public function __construct() {
        $this->registerMiddleware(new AdminMiddleware(['insertSongToAlbum', 'updateSongFromAlbum', 'deleteSongFrom']));
        $this->registerMiddleware(new AuthMiddleware(['insertSongToPlaylist', 'deleteSongFromPlaylist']));
    }

    // Admin
    public function insertSongToAlbum(Request $request) {
        $songModel = new SongModel();
        if ($request->getMethod() === 'post') {
            $songModel->loadData($request->getBody());
            if ($songModel->validate() && SongRepository::getInstance()->insert($songModel->toArray())) {
                Application::$app->session->setFlash('success', 'Song inserted successfully');
                echo("<script>location.href = '/song/insertSong';</script>");
                return;
            }
        }

        // Method : GET
        $this->setLayout('blank');
        return $this->render('song/insertSong', [
            'view' => [
                'model' => $songModel
                ]
        ]);
    }

    public function updateSongFromAlbum(Request $request)
    {
        $songModelOld = new SongModel();
        $song_id = $request->getRouteParam('song_id');
        $songModelOld->constructFromArray(
            SongRepository::getInstance()
                ->getSongById($song_id)
        );
        echo $request->getMethod();
        echo '<br> Masuk updateSong <br>';

        if ($request->getMethod() === 'post') {
            $songModelNew = new SongModel();
            $songModelNew->set('song_id', $song_id);
            $songModelNew->loadData($request->getBody());
            if ($songModelNew->validate() && SongRepository::getInstance()
                    ->update(
                        $song_id,
                        data: $songModelNew->toArray()
                    )) {
                Application::$app->session->setFlash('success', 'Song updated successfully');
                echo("<script>location.href = `/song/${song_id};</script>");
                return;
            }
        }

        // Method : GET
        $this->setLayout('blank');
        return $this->render('song/updateSong', [
            'view' => [
                'model' => $songModelOld
                ]
        ]);
    }

    public function deleteSongFromAlbum(Request $request) {
        // TODO : implement function
        // Method : POST

        // Method : GET
    }


    // User
    public function insertSongToPlaylist(Request $request) {
        // TODO : implement function
        // Method : POST

        // Method : GET
    }

    public function deleteSongFromPlaylist(Request $request) {
        // TODO : implement function
        // Method : POST

        // Method : GET
    }

    public function __toString(): string
    {
        return 'SongController';
    }
}