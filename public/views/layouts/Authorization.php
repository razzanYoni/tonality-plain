<?php

/** @var $title string */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/Global.css" type="text/css">
    <link rel="stylesheet" href="/public/css/Authorization.css" type="text/css">
    <title>
        <?php
        if (isset($title)) {
            echo $title;
        }
        ?>
    </title>
</head>
<body>
{{content}}
</body>
</html>