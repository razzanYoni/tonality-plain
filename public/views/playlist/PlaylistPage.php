<?php

/** @var $playlists array
 **/

require_once ROOT_DIR . "src/models/PlaylistModel.php";
require_once ROOT_DIR . "public/components/PlaylistCard.php";

use controllers\PlaylistController;
use models\PlaylistModel;

?>

<div class="playlist-card-container">
    <?php
        foreach ($playlists as $playlist) {
            $playlistModel = new PlaylistModel();
            $playlistModel->constructFromArray($playlist);
            echo PlaylistCard($playlistModel);
        }
    ?>
</div>
