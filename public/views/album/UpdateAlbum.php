<?php

/** @var $model \models\LoginForm */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

?>

<h1>Album</h1>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'album_id') ?>
<?php echo $form->field($model, 'album_name') ?>
<?php echo $form->field($model, 'release_date') ?>
<?php echo $form->field($model, 'genre') ?>
<?php echo $form->field($model, 'artist') ?>
<?php echo $form->field($model, 'cover_url') ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>
