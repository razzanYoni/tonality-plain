<?php

/** @var $model \cores\Model */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

$form = new Form();
?>

<h1>Register</h1>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->field($model, 'username') ?>
<?php echo $form->field($model, 'password')->passwordField() ?>
<?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>
<button class="btn btn-success">Submit</button>
<?php Form::end() ?>
