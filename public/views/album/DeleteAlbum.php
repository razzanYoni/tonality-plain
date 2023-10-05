<?php

/** @var $model \models\LoginForm */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

?>

<h1>Album</h1>

<?php $form = Form::begin('', 'delete') ?>
<?php echo $form->field($model, 'album_id') ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>
