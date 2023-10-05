<?php

/** @var $model \models\UserLoginModel */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;

?>


<div class="login-title">Log in to Tonality</div>
<?php $form = Form::begin('', 'post', ['class' => 'login-form']); ?>

<div class="login-quest">
    <div class="form-label">Username</div>
    <?php echo $form->field($model, 'username')->renderInput() ?>
</div>

<div class="login-quest">
    <div class="form-label">Password</div>
    <?php echo $form->field($model, 'password')->passwordField()->renderInput() ?>
</div>

<div class="btn-for-login">
    <button class="login-btn">Log In</button>
</div>

<?php Form::end() ?>

<div class="sign-up-link">
    Don't have an account? <a href="/register" class="signup-text">Sign up for Tonality</a>
</div>