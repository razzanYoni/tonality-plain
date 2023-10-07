<?php

namespace controllers;

require_once ROOT_DIR . "src/middlewares/AuthMiddleware.php";
require_once ROOT_DIR . "src/repositories/PlaylistRepository.php";
require_once ROOT_DIR . "src/models/PlaylistModel.php";

use bases\BaseController,
    middlewares\AuthMiddleware;
use cores\Application,
    cores\Request;
use repositories\PlaylistRepository,
    models\PlaylistModel;
use repositories\SongRepository;

class PlaylistController extends BaseController {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(['playlist', 'insertPlaylist', 'updatePlaylist', 'deletePlaylist', 'playlistById']));
    }

    public function playlist(Request $request) {
        // TODO : implement playlist use user_id from Application::$app->loggedUser
        $user_id = Application::$app->loggedUser->getUserId();

        $playlistRepository = PlaylistRepository::getInstance();
        $playlists = $playlistRepository->getPlaylistsByUserId($user_id);

        // print_r($playlist);

        if ($request->getMethod() === 'get') {
            if ($playlists) {
                Application::$app->session->setFlash('success', 'Playlist Songs Retrieved Successfully');
                return;
            }
        }

       $this->setLayout('PlaylistPage');
        return $this->render('playlist/PlaylistPage', [
            'view' => [
                'playlist' => $playlists
            ],
            'layout' => [
                'title' => 'Tonality'
            ]
        ]);
    }

    public function insertPlaylist(Request $request) {
        $playlistModel = new PlaylistModel();

        if ($request->getMethod() === 'post') {
            $playlistModel->loadData($request->getBody());
            if ($playlistModel->validate() && AlbumRepository::getInstance()->insert($playlistModel->toArray())) {
                Application::$app->session->setFlash('success', 'Playlist Inserted Successfully');

                Application::$app->response->redirect('/playlist/insertPlaylist');
                return;
            }
        }
        $this->setLayout('playlist');
        return $this->render('playlist/insertPlaylist', [
            'view' => [
                'model' => $playlistModel
                ],
            'layout' => [
                'title' => 'Add Playlist - Tonality'
            ]
        ]);
    }

    public function updatePlaylist(Request $request) {
        $playlistModelOld = new PlaylistModel();
        $playlist_id = $request->getRouteParam('playlist_id');
        $playlistModelOld->constructFromArray(
            PlaylistRepository::getInstance()
                ->getPlaylistById($playlist_id)
        );

        if ($request->getMethod() === 'post') {
            $playlistModelNew = new PlaylistModel();
            $playlistModelNew->set('playlist_id', $playlist_id);
            $playlistModelNew->loadData($request->getBody());
            if ($playlistModelNew->validate() && PlaylistRepository::getInstance()
                    ->update(
                        $playlist_id,
                        data: $playlistModelNew->toArray()
                    )) {
                Application::$app->session->setFlash('success', 'Playlist Edited Successfully');

                Application::$app->response->redirect('/playlist/{playlist_id:\d+}/updatePlaylist');
                return;
            }
        }
        $this->setLayout('playlist');
        return $this->render('playlist/updatePlaylist', [
            'view' => [
                'model' => $playlistModelOld
                ],
            'layout' => [
                'title' => 'Update Playlist - Tonality'
            ]
        ]);
    }

    public function deletePlaylist(Request $request) {
        $playlistModel = new PlaylistModel();
        if ($request->getMethod() === 'delete') {
            $playlistModel->loadData($request->getBody());
            $playlist_id = $request->getBody();
            print_r($playlist_id);
            if ($playlistModel->validate() && PlaylistRepository::getInstance()->delete($playlist_id)) {
                Application::$app->session->setFlash('success', 'Playlist Deleted Successfully');
                return;
            }
        }
        $this->setLayout('playlist');
        return $this->render('playlist/deletePlaylist', [
            'view' => [
                'model' => $playlistModel
            ],
            'layout' => [
                'title' => 'Delete Playlist - Tonality'
            ]
        ]);
    }

    public function playlistById(Request $request) {
        $playlist_id = $request->getRouteParam('playlist_id');

        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->constructFromArray(
            PlaylistRepository::getInstance()
                ->getplaylistById($playlist_id)
        );
        $where = ['playlist_id' => $playlist_id];

        print_r($playlist);

        if ($request->getMethod() === 'get') {
            if ($playlist->validate() && PlaylistRepository::getInstance()->findOne($where)) {
                Application::$app->session->setFlash('success', 'Playlist Songs Retrieved Successfully');

                Application::$app->response->redirect('/playlist/{playlist_id:\d+}');
                // return;
            }
        }

       $this->setLayout('PlaylistContent');
        return $this->render('playlist/PlaylistContent', [
            'view' => [
                'playlist' => $playlist
            ],
            'layout' => [
                'title' => 'Tonality'
            ]
        ]);
    }

    public function __toString(): string
    {
        return 'PlaylistController';
    }
}
