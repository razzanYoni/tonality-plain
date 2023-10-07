<?php

/** @var $model SongModel */

require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;
use models\SongModel;

$form = new Form();

?>

<?php
    echo NavBar();
?>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'title') ?>
<?php echo $form->field($model, 'artist') ?>
<?php echo $form->field($model, 'song_number', ["min" => '1'])->numberField() ?>
<?php echo $form->field($model, 'disc_number', ["min" => '1'])->numberField() ?>

<?php echo $form->field($model, 'audio_filename',
    ["id" => "input-file", "accept" => "audio/*"],
    '<label for="input-file" class="custom-file-upload" id="file-label">Choose Your Song</label>'
)->fileField() ?>

<?php echo $form->field($model, 'duration')->numberField() ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>

