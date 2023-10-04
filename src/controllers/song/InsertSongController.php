<?php

namespace controllers\song;

use bases\BaseController,
    cores\Request,
    models\SongForm,
    cores\Application,
    models\SongModel;

class InsertSongController extends BaseController {
      protected static InsertSongController $instance;
    public function insertSong(Request $request) {
        $songModel = new SongModel();

        if ($request->getMethod() === 'post') {
            $songModel->loadData($request->getBody());
            if ($songModel->validate() && $songModel->insert()) {
                Application::$app->session->setFlash('success', 'Song inserted successfully');
                /**
                 * * Jangan Lupa Ditambah Untuk nampilin flash message
                 *
                 */
                Application::$app->response->redirect('/insertSong');
                return;
            }
        }
        $this->setLayout('auth');
    }
}