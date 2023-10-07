<?php
require_once ROOT_DIR . "src/cores/Application.php";

use cores\Application;
use models\AlbumModel;

function AlbumCard(AlbumModel $album): string
{
    $albumId = $album->get('album_id');
    $coverFileName = $album->get('cover_filename') ? : 'default-cover.jpg';
    $coverUrl = STORAGE_FOLDER . '/' . $coverFileName;
    $albumName = $album->get('album_name');
    $albumArtist = $album->get('artist');

    if (Application::$app->loggedUser->isAdmin()) {
        return
        <<<"EOT"
        <a href="/albumAdmin/$albumId" class="album-card">
            <div class="album-info-container">
                <img src=$coverUrl alt="album cover image" class="album-cover-image"/>
                <div class="album-name">$albumName</div>
                <div class="artist-name">$albumArtist</div>
            </div>
        </a>
        EOT;
    } else {
        return
        <<<"EOT"
        <a href="/album/$albumId" class="album-card">
            <div class="album-info-container">
                <img src=$coverUrl alt="album cover image" class="album-cover-image"/>
                <div class="album-name">$albumName</div>
                <div class="artist-name">$albumArtist</div>
            </div>
        </a>
        EOT;
    }
}
