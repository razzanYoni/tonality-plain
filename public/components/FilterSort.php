<?php
require_once ROOT_DIR . "src/cores/Application.php";

use repositories\AlbumRepository;

function FilterSort(): string
{
    $genres = AlbumRepository::getInstance()->getAlbumGenres();

    $default_genre = '<option disabled selected>Genre</option>';
    if (isset($_GET['genre'])) {
        $genre_from_get = $_GET['genre'];
        $default_genre = '<option disabled>Genre</option>';
    }

    $options = '';
    foreach ($genres as $genreData) {
        $genre = $genreData['genre'];
        if (isset($genre_from_get) && $genre === $genre_from_get) {
            $options .= '<option selected>' . $genre . '</option>';
            continue;
        }
        $options .= '<option>' . $genre . '</option>';
    }

    $default_sort = '<option disabled selected>Sort</option>';
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $default_sort = '<option disabled>Sort</option>';

        if ($sort === 'album_name') {
            $default_sort .= '<option selected>Name</option>';
            $default_sort .= '<option>Release Date</option>';
        } else {
            $default_sort .= '<option>Name</option>';
            $default_sort .= '<option selected>Release Date</option>';
        }
    } else {
        $default_sort .= '<option>Name</option>';
        $default_sort .= '<option>Release Date</option>';
    }

    $default_desc = '<option disabled selected>Order</option>';
    if (isset($_GET['is_desc'])) {
        $desc = $_GET['is_desc'];
        $default_desc = '<option disabled>Order</option>';

        if ($desc === 'desc') {
            $default_desc .= '<option selected>Descending</option>';
            $default_desc .= '<option>Ascending</option>';
        } else {
            $default_desc .= '<option>Descending</option>';
            $default_desc .= '<option selected>Ascending</option>';
        }
    } else {
        $default_desc .= '<option>Descending</option>';
        $default_desc .= '<option>Ascending</option>';
    }

    return <<<"EOT"
    <div class="filter-sort-container">
        <select class="filter">
            {$default_genre}
            {$options}
        </select>

        <select class="sort">
            {$default_sort}
        </select>

        <select class="desc">
            {$default_desc}
        </select>
    </div>
    EOT;
}
