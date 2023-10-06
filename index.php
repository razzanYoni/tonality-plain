<?php

const ROOT_DIR = __DIR__ . '/';

require_once 'public/bootstrap.php';
require_once ROOT_DIR . 'src/cores/Application.php';
require_once ROOT_DIR . 'src/controllers/AuthorizationController.php';
require_once ROOT_DIR . 'src/controllers/AlbumController.php';
require_once ROOT_DIR . 'src/controllers/SongController.php';
require_once ROOT_DIR . 'src/controllers/PlaylistController.php';

use cores\Application,
    controllers\AuthorizationController,
    controllers\AlbumController,
    controllers\PlaylistController,
    controllers\SongController;

$app = Application::getInstance();

$app->on(Application::EVENT_BEFORE_REQUEST, function () {
//    echo "Before request event is triggered";
});

// Authorization
$app->router->get('/signup', [AuthorizationController::class, 'signup']);
$app->router->post('/signup', [AuthorizationController::class, 'signup']);
$app->router->get('/login', [AuthorizationController::class, 'login']);
$app->router->post('/login', [AuthorizationController::class, 'login']);
$app->router->get('/logout', [AuthorizationController::class, 'logout']);


// Album
// Admin
$app->router->get('/albumAdmin', [AlbumController::class, 'albumAdmin']);
$app->router->get('/albumAdmin/insertAlbum', [AlbumController::class, 'insertAlbum']);
$app->router->post('/albumAdmin/insertAlbum', [AlbumController::class, 'insertAlbum']);
$app->router->get('/albumAdmin/{album_id:\d+}/updateAlbum', [AlbumController::class, 'updateAlbum']);
$app->router->post('/albumAdmin/{album_id:\d+}/updateAlbum', [AlbumController::class, 'updateAlbum']);
$app->router->get('/albumAdmin/{album_id:\d+}/deleteAlbum', [AlbumController::class, 'deleteAlbum']);
$app->router->post('/albumAdmin/{album_id:\d+}/deleteAlbum', [AlbumController::class, 'deleteAlbum']);
$app->router->get('/albumAdmin/{album_id:\d+}', [AlbumController::class, 'albumAdminById']);
// User
$app->router->get('/album', [AlbumController::class, 'albumUser']);
$app->router->get('/album/{album_id:\d+}', [AlbumController::class, 'albumUser']);
$app->router->get('/album/{album_id:\d+}', [AlbumController::class, 'albumUserById']);


// Playlist
$app->router->get('/playlist', [PlaylistController::class, 'playlist']);
$app->router->get('/playlist/insertPlaylist', [PlaylistController::class, 'insertPlaylist']);
$app->router->post('/playlist/insertPlaylist', [PlaylistController::class, 'insertPlaylist']);
$app->router->get('/playlist/{playlist_id:\d+}/updatePlaylist', [PlaylistController::class, 'updatePlaylist']);
$app->router->post('/playlist/{playlist_id:\d+}/updatePlaylist', [PlaylistController::class, 'updatePlaylist']);
$app->router->get('/playlist/{playlist_id:\d+}/deletePlaylist', [PlaylistController::class, 'deletePlaylist']);
$app->router->post('/playlist/{playlist_id:\d+}/deletePlaylist', [PlaylistController::class, 'deletePlaylist']);
$app->router->get('/playlist/{playlist_id:\d+}', [PlaylistController::class, 'playlistById']);


// Song
// Admin
$app->router->get('/albumAdmin/insertSong', [SongController::class, 'insertSongToAlbum']);
$app->router->post('/albumAdmin/insertSong', [SongController::class, 'insertSongToAlbum']);
$app->router->get('/albumAdmin/{album_id:\d+}/updateSong/{song_id:\d+}', [SongController::class, 'updateSongFromAlbum']);
$app->router->post('/albumAdmin/{album_id:\d+}/updateSong/{song_id:\d+}', [SongController::class, 'updateSongFromAlbum']);
$app->router->get('/albumAdmin/{album_id:\d+}/deleteSong/{song_id:\d+}', [SongController::class, 'deleteSongFromAlbum']);
$app->router->post('/albumAdmin/{album_id:\d+}/deleteSong/{song_id:\d+}', [SongController::class, 'deleteSongFromAlbum']);
// User
// TODO : add schema for add song to playlist
$app->router->get('/album/{album_id:\d+}/insertSong', [SongController::class, 'insertSongToPlaylist']);
$app->router->post('/album/{album_id:\d+}/insertSong', [SongController::class, 'insertSongToPlaylist']);
$app->router->get('/playlist/{playlist_id:\d+}/deleteSong/{song_id:\d+}', [SongController::class, 'deleteSongFromPlaylist']);
$app->router->post('/playlist/{playlist_id:\d+}/deleteSong/{song_id:\d+}', [SongController::class, 'deleteSongFromPlaylist']);


$app->run();

//echo $app->controller;

// TODO : default / without direct to 404
// Set router default to login
if ($_SERVER['REQUEST_URI'] === '/' && !isset($_SESSION['user_id'])) {
    echo("<script>location.href = '/login';</script>");
} else if ($_SERVER['REQUEST_URI'] === '/' && isset($_SESSION['user_id'])) {
    if ($_SESSION['is_admin'] === '1') {
        echo("<script>location.href = '/albumAdmin';</script>");
    } else {
        echo("<script>location.href = '/album';</script>");
    }
}
