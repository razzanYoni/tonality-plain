<?php

/** @var $model \models\SongModel */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

$form = new Form();
?>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'album_id') ?>
<?php echo $form->field($model, 'title') ?>
<?php echo $form->field($model, 'artist') ?>
<?php echo $form->field($model, 'song_number') ?>
<?php echo $form->field($model, 'disc_number') ?>
<?php echo $form->field($model, 'audio_url')->fileField() ?>
<?php echo $form->field($model, 'duration') ?>

<!-- TODO : implement cancel button -->
<!--<button>Cancel</button>-->
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>