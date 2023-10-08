<?php
require_once ROOT_DIR . "src/cores/Application.php";

use cores\Application;
use models\PlaylistModel;
use repositories\AlbumRepository;

function DropDown(): string
{
    $genres = AlbumRepository::getInstance()->getAlbumGenres();
    $options = '';
    foreach ($genres as $genreData) {
        $genre = $genreData['genre'];
        $options .= '<option>' . $genre . '</option>';
    }

    return <<<"EOT"
    <div class="container">
        <select class="filter">
            <option disabled selected>Genre</option>
            {$options}
        </select>

        <select class="sort">
            <option disabled selected>Sort</option>
            <option>Name</option>
            <option>Release Date</option>
        </select>

        <select class="desc">
            <option disabled selected>Order</option>
            <option>Descending</option>
            <option>Ascending</option>
        </select>
    </div>
    EOT;
}
