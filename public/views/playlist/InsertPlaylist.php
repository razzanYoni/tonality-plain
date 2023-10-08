<?php

/** @var $model PlaylistModel */

require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";
require_once ROOT_DIR . "src/controllers/PlaylistController.php";

use forms\Form;
use models\PlaylistModel;

?>
<div class="form-container">
  <h1>
    Add New Playlist
  </h1>

    <?php $form = Form::begin('', 'post', ['class' => 'form-list'], enctype: "multipart/form-data"); ?>

  <div class="playlist-quest">
      <?php echo $form->field($model, 'playlist_name') ?>
  </div>

  <div class="playlist-quest">
      <?php echo $form->field($model, 'description') ?>
  </div>

  <div class="playlist-quest">
      <?php
      echo $form->field($model, 'cover_filename',
          ["id" => "input-file", "accept" => "image/*"],
          '<label for="input-file" class="custom-file-upload" id="file-label">
          Select a File</label>')->fileField();
      ?>
  </div>

  <div class="cancel-submit">
    <button class="cancel-btn">Cancel</button>
    <button class="add-btn" formaction="/playlist/insertPlaylist">Add Playlist</button>
  </div>

    <?php Form::end() ?>
</div>