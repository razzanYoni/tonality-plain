<?php

/** @var $model \models\SongModel */

require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

$form = new Form();

?>

<?php
    echo NavBar();
?>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'album_id') ?>
<?php echo $form->field($model, 'title') ?>
<?php echo $form->field($model, 'artist') ?>
<?php echo $form->field($model, 'song_number') ?>
<?php echo $form->field($model, 'audio_url')->fileField() ?>
<?php echo $form->field($model, 'duration') ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>

