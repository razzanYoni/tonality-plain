<?php

/** @var $albums array
 **/

require_once ROOT_DIR . "src/models/AlbumModel.php";
require_once ROOT_DIR . "src/controllers/AlbumController.php";
require_once ROOT_DIR . "src/repositories/AlbumRepository.php";
require_once ROOT_DIR . "public/components/AlbumCard.php";

use models\AlbumModel;

?>

<div class="album-card-container">
    <?php
        foreach ($albums as $album) {
            $albumModel = new AlbumModel();
            $albumModel->constructFromArray($album);
            $albumModels[] = $albumModel;
            echo AlbumCard($albumModel);
        }
    ?>
</div>