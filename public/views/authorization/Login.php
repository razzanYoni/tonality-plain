<?php

/** @var $model UserLoginModel */

require_once ROOT_DIR . "src/forms/Form.php";

use forms\Form;
use models\UserLoginModel;

?>

<div class="login-container">
    <img
            class="logo"
            src="/public/assets/icons/logo.svg"
            alt="Tonality Logo"
    />

    <div class="login-title">Log in to Tonality</div>

    <?php $form = Form::begin('', 'post', ['class' =>
        'login-form']); ?>

    <div class="login-quest">
        <?php echo $form->field($model, 'username') ?>
    </div>

    <div class="login-quest">
        <?php echo $form->field($model, 'password')->passwordField() ?>
    </div>

    <div class="login-btn-container">
        <button class="login-btn">Log In</button>
    </div>

    <?php Form::end() ?>

    <div class="signup-link">
        Don't have an account?
        <a href="/signup" class="signup-text">Sign up for Tonality</a>
    </div>
</div>
