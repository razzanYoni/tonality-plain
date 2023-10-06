<?php

/** @var $model \models\UserLoginModel */

// define("ROOT_DIR", __DIR__ . "/");
require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

?>
<h1>Update Playlist</h1>
<?php $form = Form::begin('', 'post', ['class' => 'form-list']); ?>
<div class="playlist-quest">
    <?php echo $form->field($model, 'playlist_name') ?>
</div>

<div class="playlist-quest">
    <?php echo $form->field($model, 'description') ?>
</div>

<div class="playlist-quest">
    <?php
    echo $form->field($model, 'cover_url', ["id" => "input-file", "accept" => "image/*"])->fileField();
    echo '<label for="input-file" class="custom-file-upload" id="file-label">Choose Your Playlist Cover</label>';
    ?>
</div>

<div class="cancel-submit">
    <button class="cancel-btn">Cancel</button>
    <button class="add-btn" formaction="/playlist/insertPlaylist">Add Song</button>
</div>

<?php Form::end() ?>
