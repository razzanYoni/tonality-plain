<?php

namespace controllers;

require_once ROOT_DIR . "src/models/SongModel.php";
require_once ROOT_DIR . "src/repositories/SongRepository.php";
require_once ROOT_DIR . "src/repositories/AppearsOnRepository.php";

use bases\BaseController,
    cores\Application,
    cores\Request,
    middlewares\AdminMiddleware,
    models\SongModel,
    repositories\AppearsOnRepository,
    repositories\SongRepository,
    middlewares\UserMiddleware;

class SongController extends BaseController {
    public function __construct() {
        $this->registerMiddleware(new AdminMiddleware(['insertSongToAlbum', 'updateSongFromAlbum', 'deleteSongFrom']));
        $this->registerMiddleware(new UserMiddleware(['insertSongToPlaylist', 'deleteSongFromPlaylist']));
    }

    // Admin
    public function insertSongToAlbum(Request $request)
    {
        $songModel = new SongModel();
        $album_id = $request->getRouteParam('album_id');

        if ($request->isPost()) {
            $songModel->set('album_id', $album_id);
            $songModel->loadData($request->getBody());

            if (!empty($_FILES['audio_filename'])) {
                $songModel->set('audio_filename', $_FILES['audio_filename']['name']);
            }

            if ($songModel->validate() && SongRepository::getInstance()->insert($songModel->toArray())) {
                Application::$app->session->setFlash('success', 'Song inserted successfully');
                Application::$app->response->redirect('/albumAdmin/' . $album_id . '/insertSong');
                return;
            }
        }

        // Method : GET
        $this->setLayout('AlbumForm');
        return $this->render('song/InsertSong', [
            'view' => [
                'model' => $songModel
            ]
        ]);
    }

    public function updateSongFromAlbum(Request $request)
    {
        $songModelOld = new SongModel();
        $song_id = $request->getRouteParam('song_id');
        $album_id = $request->getRouteParam('album_id');
        $songModelOld->constructFromArray(
            SongRepository::getInstance()
                ->getSongById($song_id)
        );

        if ($request->isPost()) {
            $songModelNew = new SongModel();
            $songModelNew->set('song_id', $song_id);
            $songModelNew->loadData($request->getBody());

            if (!empty($_FILES['audio_filename'])) {
                $songModelNew->set('audio_filename', $_FILES['audio_filename']['name']);
            }

            if ($songModelNew->validate() && SongRepository::getInstance()
                    ->update(
                        $song_id,
                        data: $songModelNew->toArray()
                    )) {
                Application::$app->session->setFlash('success', 'Song updated successfully');
                Application::$app->response->redirect('/albumAdmin/' . $album_id);
                return;
            }
        }

        // Method : GET
        $this->setLayout('AlbumForm');
        return $this->render('song/UpdateSong', [
            'view' => [
                'model' => $songModelOld
            ]
        ]);
    }

    public function deleteSongFromAlbum(Request $request)
    {
        $song_id = $request->getRouteParam('song_id');
        // Method : DELETE
        if ($request->isDelete()) {
            $album_id = $request->getRouteParam('album_id');
            if (SongRepository::getInstance()->delete($song_id)) {
                Application::$app->session->setFlash('success', 'Song deleted successfully');
                return;
            }
            Application::$app->response->redirect('/albumAdmin/' . $album_id);
        }
    }


    // User
    public function insertSongToPlaylist(Request $request)
    {
        $song_id = $request->getRouteParam('song_id');
        $album_id = $request->getRouteParam('album_id');

        // Method : POST
        if ($request->getMethod() === 'post') {
            $playlist_id = $request->getBody()['selected-playlist'];

            if (AppearsOnRepository::getInstance()->insertSongToPlaylist($song_id, $playlist_id)) {
                Application::$app->session->setFlash('success', 'Song inserted successfully');
                Application::$app->response->redirect('/album/' . $album_id);
                return;
            }
        }

        // Method : GET
        $this->setLayout('AlbumForm');
        return $this->render('song/InsertSongToPlaylist', [
            'view' => [
                'album_id' => $album_id,
                'song_id' => $song_id,
            ]
        ]);
    }

    public function deleteSongFromPlaylist(Request $request)
    {
        $song_id = $request->getRouteParam('song_id');
        $playlist_id = $request->getRouteParam('playlist_id');

        // Method : DELETE
        if ($request->isDelete()) {
            if (AppearsOnRepository::getInstance()->deleteSongFromPlaylist($song_id, $playlist_id)) {
                Application::$app->session->setFlash('success', 'Song deleted successfully');
                return;
            }
            Application::$app->response->redirect('/playlist/' . $playlist_id);
        }
    }

    public function __toString(): string
    {
        return 'SongController';
    }
}