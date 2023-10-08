<?php

/** @var $model PlaylistModel */

require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;
use models\PlaylistModel;

?>

<div class="form-container">
  <h1>
    Edit Playlist
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
      echo $form->field($model, 'cover_filename', ["id" => "input-file", "accept" => "image/*"],
          '<label for="input-file" class="custom-file-upload" id="file-label">Select a File</label>'
      )->fileField();
      ?>
  </div>

  <div class="cancel-submit">
    <input type="button" class="cancel-btn" onclick="history.back()" value="Cancel">
    <button class="add-btn" formaction="/playlist/<?php echo $model->get('playlist_id') ?>/updatePlaylist">Edit
      Playlist
    </button>
  </div>

    <?php Form::end() ?>
</div>
