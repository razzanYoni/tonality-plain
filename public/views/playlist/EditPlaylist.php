<?php

define("ROOT_DIR", __DIR__ . "/");
require_once ROOT_DIR . "../../components/NavBar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/public/js/FormDetail.js"></script>
    <link rel="stylesheet" href="/public/css/FormDetail.css" type="text/css">
    <link rel="stylesheet" href="/public/css/NavBar.css" type="text/css">
    <!-- <link href="/public/assets/fonts" rel="stylesheet"> -->
    <title>Add New Album - Tonality</title>
</head>
<body>
    <?php
        echo NavBar();
    ?>
    <div class="form-container">
        <h1>Edit Playlist</h1>
        <form class="form-list">
            <div class="playlist-quest">
                <div class="form-label">Playlist Name</div>
                    <input type="text">
            </div>
            <div class="playlist-quest">
                <div class="form-label">Description</div>
                    <input type="text">
            </div>
            <div class="playlist-quest">
                <div class="form-label">Cover Photo</div>
                    <input type="file" id="input-file" accept="image/*">
                    <label for="input-file" class="custom-file-upload" id="file-label">Choose Your Playlist Cover</label>
            </div>
            <div class="cancel-submit">
                <button class="cancel-btn">Cancel</button>
                <button class="add-btn">Add Song</button>
            </div>
        </form>
    </div>
</body>
</html>
