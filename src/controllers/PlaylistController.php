<?php

namespace controllers;

require_once ROOT_DIR . "src/bases/BaseController.php";

use bases\BaseController,
    middlewares\AuthMiddleware;
use cores\Request;

class PlaylistController extends BaseController {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(['playlist', 'insertPlaylist', 'updatePlaylist', 'deletePlaylist', 'playlistById']));
    }

    public function playlist(Request $request) {
        // TODO : implement playlist use user_id from Application::$app->loggedUser
    }

    public function insertPlaylist(Request $request) {
        // TODO : implement insertPlaylist
    }

    public function updatePlaylist(Request $request) {
        // TODO : implement updatePlaylist
    }

    public function deletePlaylist(Request $request) {
        // TODO : implement deletePlaylist
    }

    public function playlistById(Request $request) {
        // TODO : implement playlistById
    }
}