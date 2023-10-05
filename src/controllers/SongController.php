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

class SongController extends BaseController {
    public function __construct() {
        $this->registerMiddleware(new AdminMiddleware(['insertSong', 'updateSong']));
    }

    public function insertSong(Request $request) {
        $songModel = new SongModel();
        if ($request->getMethod() === 'post') {
            $songModel->loadData($request->getBody());
            if ($songModel->validate() && $songModel->insert()) {
                Application::$app->session->setFlash('success', 'Song inserted successfully');
                echo("<script>location.href = '/song/insertSong';</script>");
                return;
            }
        }

        // Method : GET
        $this->setLayout('blank');
        return $this->render('song/insertSong', [
            'model' => $songModel
        ]);
    }

    public function updateSong(Request $request) {
        $songModelOld = new SongModel();
        $song_id = $request->getRouteParam('song_id');
        $songModelOld->constructFromArray(
            SongRepository::getInstance()
                ->getSongById($song_id)
        );

        if ($request->getMethod() === 'post') {
            $songModelNew = new SongModel();
            $songModelNew->song_id = $song_id;
            $songModelNew->loadData($request->getBody());
            if ($songModelNew->validate() && $songModelNew->update(
                where: ['song_id' => $song_id],
                    data: $songModelNew->toResponse()
                )) {
                Application::$app->session->setFlash('success', 'Song updated successfully');
                echo("<script>location.href = `/song/${song_id};</script>");
                return;
            }
        }
        // TODO : update song

        // Method : GET
        $this->setLayout('blank');
        return $this->render('song/updateSong', [
            'model' => $songModelOld
        ]);
    }

    public function __toString(): string
    {
        return 'SongController';
    }
}