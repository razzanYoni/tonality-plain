<?php

/** @var $model UserLoginModel */

require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;
use models\UserLoginModel;

// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Split the URL into parts using the "/" delimiter
$urlParts = explode('/', $currentUrl);

// Find the index of "albumAdmin" in the URL
$albumAdminIndex = array_search('albumAdmin', $urlParts);

if ($albumAdminIndex !== false) {
    // Get the album ID (after "albumAdmin/")
    $albumId = $urlParts[$albumAdminIndex + 1];
} else {
    // "albumAdmin" not found in the URL
    echo "Not found";
}

?>

<div class="form-container">
  <h1>Edit Album</h1>

    <?php $form = Form::begin('', 'post', ['class' => 'form-list'], enctype: "multipart/form-data"); ?>

  <div class="album-quest">
      <?php echo $form->field($model, 'album_name') ?>
  </div>

  <div class="album-quest">
      <?php echo $form->field($model, 'artist') ?>
  </div>

  <div class="album-quest">
      <?php echo $form->field($model, 'genre') ?>
  </div>

  <div class="album-quest">
      <?php echo $form->field($model, 'cover_filename', ["id" => "input-file", "accept" => "image/*"])->fileField();
      echo '<label for="input-file" class="custom-file-upload" id="file-label">Choose Your Album Cover</label>';
      ?>
  </div>

  <div class="album-quest">
      <?php echo $form->field($model, 'release_date', ["value" => '2001-01-01'])->dateField() ?>
  </div>

  <div class="cancel-submit">
    <input type="button" class="cancel-btn" onclick="history.back()" value="Cancel">
    <button class="add-btn" formaction="/albumAdmin/<?php echo $albumId ?>/updateAlbum">Edit Album</button>
  </div>

    <?php Form::end() ?>
</div>