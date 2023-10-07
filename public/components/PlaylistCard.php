<?php
require_once ROOT_DIR . "src/cores/Application.php";

use cores\Application;
use models\PlaylistModel;

function PlaylistCard(PlaylistModel $playlist): string
{
    $playlistId = $playlist->get('playlist_id');
    $coverFileName = $playlist->get('cover_filename') ? : 'default-cover.jpg';
    $coverUrl = STORAGE_FOLDER . '/' . $coverFileName;
    $playlistName = $playlist->get('playlist_name');
    $playlistArtist = $playlist->get('artist');

    return
    <<<"EOT"
    <a href="/playlist/$playlistId" class="playlist-card">
        <div class="playlist-info-container">
            <img src=$coverUrl alt="playlist cover image" class="playlist-cover-image"/>
            <div class="playlist-name">$playlistName</div>
            <div class="artist-name">$playlistArtist</div>
        </div>
    </a>
    EOT;
}
