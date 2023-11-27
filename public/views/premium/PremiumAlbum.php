<?php

/** @var $albums array
 **/

require_once ROOT_DIR . "src/models/PremiumAlbumModel.php";
require_once ROOT_DIR . "src/controllers/PremiumAlbumController.php";
require_once ROOT_DIR . "src/repositories/PremiumAlbumRepository.php";
require_once ROOT_DIR . "public/components/PremiumAlbumCard.php";

use models\PremiumAlbumModel;

?>

<div class="album-card-container" id="album-card-container">
    <?php
        foreach ($premiumAlbums as $album) {
            $premiumAlbumModel = new PremiumAlbumModel();
            $premiumAlbumModel->constructFromArray($album);
            $premiumAlbumModels[] = $premiumAlbumModel;
            echo AlbumCard($premiumAlbumModel);
        }
    ?>
</div>
