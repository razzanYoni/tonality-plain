<?php

/** @var $model \models\UserLoginModel */

// define("ROOT_DIR", __DIR__ . "/");
require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";
require_once ROOT_DIR . "src/controllers/AlbumController.php";

use forms\Form;
use controllers\AlbumController;

?>
<h1>Add New Album</h1>
<?php $form = Form::begin('', 'post', ['class' => 'form-list']); ?>
<div class="album-quest">
    <div class="form-label">Album Name</div>
    <?php echo $form->field($model, 'album_name')->renderInput() ?>
</div>

<div class="album-quest">
    <div class="form-label">Artist</div>
    <?php echo $form->field($model, 'artist')->renderInput() ?>
</div>

<div class="album-quest">
    <div class="form-label">Genre</div>
    <?php echo $form->field($model, 'genre')->renderInput() ?>
</div>

<div class="album-quest">
    <div class="form-label">Cover Photo</div>
    <?php echo $form->field($model, 'cover_url')->imageFileField() ?>
    <label for="input-file" class="custom-file-upload" id="file-label">Choose Your Album Cover</label>
</div>

<div class="album-quest">
    <div class="form-label">Release Date</div>
    <?php echo $form->field($model, 'release_date')->dateField(['value' => '2001-01-01', 'label' => 'Release Date'])->renderInput() ?>
</div>

<div class="cancel-submit">
    <button class="cancel-btn">Cancel</button>
    <button class="add-btn" formaction="/albumAdmin/insertAlbum"">Add Song</button>
</div>

<?php Form::end() ?>
