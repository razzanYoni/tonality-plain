<?php

/** @var $Playlists array
 **/

require_once ROOT_DIR . "src/models/PlaylistModel.php";
require_once ROOT_DIR . "src/controllers/PlaylistController.php";
require_once ROOT_DIR . "src/repositories/PlaylistRepository.php";
require_once ROOT_DIR . "public/components/PlaylistCard.php";

use controllers\PlaylistController;
use models\PlaylistModel;

?>

<div class="playlist-card-container">
    <?php
        foreach ($playlists as $playlist) {
            $playlistsModel = new PlaylstModel();
            $playlistsModel->constructFromArray($playlists);
            $playlistsModels[] = $playlistsModel;
            echo PlaylistCard($playlistModel);
        }
    ?>
</div>
