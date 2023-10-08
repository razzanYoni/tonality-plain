<?php

namespace controllers;

require_once ROOT_DIR . "src/middlewares/AuthMiddleware.php";
require_once ROOT_DIR . "src/repositories/PlaylistRepository.php";
require_once ROOT_DIR . "src/models/PlaylistModel.php";

use bases\BaseController;
use cores\Application;
use cores\Request;
use exceptions\BadRequestException;
use middlewares\AuthMiddleware;
use models\PlaylistModel;
use repositories\PlaylistRepository;
use repositories\SongRepository;

class PlaylistController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['playlist', 'insertPlaylist', 'updatePlaylist', 'deletePlaylist', 'playlistById']));
    }

    public function playlist(Request $request)
    {
        // Method : GET
        $user_id = Application::$app->loggedUser->getUserId();

        $requestBody = $request->getBody();

        $page = 1;
        if (isset($requestBody['page'])) {
            $page = $requestBody['page'];
        }

        $limit = ROWS_PER_PAGE;
        $offset = ($page - 1) * ROWS_PER_PAGE;

        $where = array();
        $where['user_id'] = $user_id;

        $where_like = '';
        if (isset($requestBody['search'])) {
            $where_like = $requestBody['search'];
        }

        $orderBy = 'playlist_name';
        if (isset($requestBody['order'])) {
            $orderBy[$requestBody['order']] = $requestBody['order'];
        }

        $is_desc = false;
        if (isset($requestBody['is_desc'])) {
            $is_desc = $requestBody['is_desc'] === 'desc';
        }

        $playlistRepository = PlaylistRepository::getInstance();
        $playlist = $playlistRepository->getPlaylistsByUserId(
            order: $orderBy,
            is_desc: $is_desc,
            where: $where,
            where_like: $where_like,
            limit: $limit,
            offset: $offset
        );

        $countPlaylist = $playlistRepository->getCountPlaylistByUserId(
            where: $where,
            where_like: $where_like
        );
        $totalPages = ceil($countPlaylist / ROWS_PER_PAGE);

        if ($request->getMethod() === 'get') {
            if ($playlist) {
                Application::$app->session->setFlash('success', 'Playlist Songs Retrieved Successfully');
//                return;
            }
        }

        $this->setLayout('PlaylistPage');
        return $this->render('playlist/PlaylistPage', [
            'view' => [
                'playlists' => $playlist
            ],
            'layout' => [
                'title' => 'Playlist - Tonality',
                'totalPage' => $totalPages,
                'page' => $page,
            ]
        ]);
    }

    public function insertPlaylist(Request $request)
    {
        $playlistModel = new PlaylistModel();

        if ($request->getMethod() === 'post') {
            $playlistModel->loadData($request->getBody());
            if ($playlistModel->validate() && PlaylistRepository::getInstance()->insert($playlistModel->toArray())) {
                Application::$app->session->setFlash('success', 'Playlist Inserted Successfully');

                Application::$app->response->redirect('/playlist/insertPlaylist');
                return;
            }
        }

        $this->setLayout('PlaylistForm');
        return $this->render('playlist/InsertPlaylist', [
            'view' => [
                'model' => $playlistModel
            ],
            'layout' => [
                'title' => 'Add Playlist - Tonality'
            ]
        ]);
    }

    public function updatePlaylist(Request $request)
    {
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

    public function deletePlaylist(Request $request)
    {
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

    /**
     * @throws BadRequestException
     */
    public function playlistById(Request $request)
    {
        $playlist_id = $request->getRouteParam('playlist_id');

        $playlistRepository = PlaylistRepository::getInstance();

        if (!$playlistRepository->IsPlaylistIsOwned($playlist_id)) {
            Application::$app->session->setFlash('error', 'Playlist Not Found');
            throw new BadRequestException("Playlist Not Found", 404);
        }

        $playlist = $playlistRepository->getPlaylistById($playlist_id);

        if (!$playlist) {
            Application::$app->session->setFlash('error', 'Playlist Not Found');
            throw new BadRequestException("Playlist Not Found", 404);
        }

        $playlistModel = new PlaylistModel();
        $playlistModel->constructFromArray($playlist);

        $songRepository = SongRepository::getInstance();
        $songs = $songRepository->getSongsFromPlaylist($playlist_id);

        $duration = $songRepository->getPlaylistDuration($playlist_id);

        if (!$songs) {
            $songs = [];
            // return;
        }

        $this->setLayout('playlistContent');
        return $this->render('playlist/playlistContent', [
            'view' => [
                'playlist' => $playlistModel,
                'songs' => $songs,
                'duration' => $duration,
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
