<?php

/** @var $model UserModel */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;
use models\UserModel;

?>

<div class="signup-container">
    <img
            class="logo"
            src="/public/assets/icons/logo.svg"
            alt="Tonality Logo"
    />

    <div class="signup-title">Sign up for Tonality</div>

    <?php $form = Form::begin('', 'post', ['class' =>
        'signup-form']); ?>

    <div class="signup-quest">
        <?php echo $form->field($model, 'username') ?>
    </div>

    <div class="signup-quest">
        <?php echo $form->field($model, 'password')->passwordField() ?>
    </div>

    <div class="signup-quest">
        <?php echo $form->field($model, 'password_confirm')->passwordField() ?>
    </div>

    <div class="signup-btn-container">
        <button class="signup-btn">Sign Up</button>
    </div>

    <?php Form::end() ?>

    <div class="login-link">
        Have an account?
        <a href="/login" class="login-text">Log in to Tonality</a>
    </div>
</div>
