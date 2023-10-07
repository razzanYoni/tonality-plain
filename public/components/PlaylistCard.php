<?php
require_once ROOT_DIR . "src/cores/Application.php";

use cores\Application;
use models\PlaylistModel;

function PlaylistCard(PlaylistModel $playlist): string
{
    $playlistId = $playlist->get('playlist_id');
    $playlistName = $playlist->get('playlist_name');
    $coverFileName = $playlist->get('cover_filename') ? : 'default-cover.jpg';
    $coverUrl = STORAGE_FOLDER . '/' . $coverFileName;

    return <<<"EOT"
    <a href="/playlist/$playlistId" class="playlist-card">
        <div class="playlist-info-container">
            <img src=$coverUrl alt="playlist cover image" class="playlist-cover-image"/>
            <div class="playlist-name">$playlistName</div>
        </div>
    EOT;

}