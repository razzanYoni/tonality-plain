<?php

/** @var $title string */
require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "public/components/AlbumCard.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/public/js/Delete.js"></script>
    <link rel="stylesheet" href="/public/css/Global.css" type="text/css">
    <link rel="stylesheet" href="/public/css/NavBar.css" type="text/css">
    <link rel="stylesheet" href="/public/css/UserTable.css" type="text/css">
    <link rel="stylesheet" href="/public/css/Dialog.css" type="text/css">

    <title>
        <?php
        if (isset($title)) {
            echo $title;
        }
        ?>
    </title>
</head>
<body>
<?php
echo NavBar("Users");
?>

{{content}}

</body>
</html>
