<?php

use models\AlbumModel;

function AlbumCard(AlbumModel $album): string
{
    $albumId = $album->get('album_id');
    $coverUrl = $albumId->get('cover_url');
    $coverUrl = $coverUrl ? : 'public/assets/default-cover.jpg';
    $albumName = $album->get('album_name');
    $albumArtist = $album->get('artist');

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