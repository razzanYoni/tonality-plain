<?php

/** @var $model \models\UserModel */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

$form = new Form();
?>

<div class="login-title">Sign up for Tonality</div>

<?php $form = Form::begin('', 'post', ['class' => 'register-form']) ?>

<div class="register-quest">
    <?php echo $form->field($model, 'username') ?>
</div>

<div class="register-quest">
    <?php echo $form->field($model, 'password')->passwordField()?>
</div>

<div class="register-quest">
    <?php echo $form->field($model, 'password_confirm')->passwordField() ?>
</div>

<div class="btn-for-signup">
    <button class="login-btn">Sign Up</button>
</div>

<?php Form::end() ?>

<div class="login-link">
    Don't have an account? <a href="/login" class="login-text">Log in to Tonality</a>
</div>