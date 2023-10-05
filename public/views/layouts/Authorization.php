<?php

/** @var $title string */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/Authorization.css" type="text/css">
    <script src="/public/js/Login.js"></script>
    <title>
        <?php
            if (isset($title))
            {
                echo $title;
            }
        ?>
    </title>
</head>
<body>

<div class="login-container">
    <img class="logo" src="/public/assets/icons/logo.svg" alt="Tonality Logo">
    {{content}}
</div>
</body>
</html>