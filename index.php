<?php

define('ROOT_DIR', __DIR__ . '/');

require_once 'public/bootstrap.php';
require_once ROOT_DIR . 'src/cores/Application.php';
require_once ROOT_DIR . 'src/controllers/AuthorizationController.php';
require_once ROOT_DIR . 'src/controllers/AlbumController.php';
require_once ROOT_DIR . 'src/controllers/SongController.php';

use cores\Application;

$app = Application::getInstance();

$app->on(Application::EVENT_BEFORE_REQUEST, function () {
//    echo "Before request event is triggered";
});


$app->router->get('/album', [\controllers\AlbumController::class, 'album']);
$app->router->get('/albumAdmin', [\controllers\AlbumController::class, 'albumAdmin']);

$app->router->get('/login', [\controllers\AuthorizationController::class, 'login']);
$app->router->post('/login', [\controllers\AuthorizationController::class, 'login']);
$app->router->get('/logout', [\controllers\AuthorizationController::class, 'logout']);
$app->router->get('/register', [\controllers\AuthorizationController::class, 'register']);
$app->router->post('/register', [\controllers\AuthorizationController::class, 'register']);

$app->router->get('/song/insertSong', [\controllers\SongController::class, 'insertSong']);
$app->router->post('/song/insertSong', [\controllers\SongController::class, 'insertSong']);
$app->router->get('/song/{song_id:\d+}', [\controllers\SongController::class, 'updateSong']);
$app->router->post('/song/{song_id:\d+}', [\controllers\SongController::class, 'updateSong']);


$app->run();

echo $app->controller;

//set router default to login
if ($_SERVER['REQUEST_URI'] === '/' && !isset($_SESSION['user_id'])) {
    echo("<script>location.href = '/login';</script>");
} else if ($_SERVER['REQUEST_URI'] === '/' && isset($_SESSION['user_id'])) {
    if ($_SESSION['is_admin'] === '1') {
        echo("<script>location.href = '/albumAdmin';</script>");
    } else {
        echo("<script>location.href = '/album';</script>");
    }
}

//$viewRoutes = array(
//    '/' => ROOT_DIR . 'public/pages/index.php',
//
//    '/add-album' => ROOT_DIR . 'public/views/AddAlbum.php',
//    '/add-song' => ROOT_DIR . 'public/views/InsertSong.php',
//);
//
//$router = new \router\PageRouter($viewRoutes, ROOT_DIR . 'public/pages/404.php');
//$router->routing($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);