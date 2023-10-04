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
    <title>Edit Album - Tonality</title>
</head>
<body>
    <?php
        echo NavBar();
    ?>
    <div class="form-container">
        <h1>Edit Album</h1>
        <form class="form-list">
            <div class="album-quest">
                <div class="form-label">Album Name</div>
                    <input type="text">
            </div>
            <div class="album-quest">
                <div class="form-label">Artist</div>
                    <input type="text">
            </div>
            <div class="album-quest">
                <div class="form-label">Genre</div>
                    <input type="text">
            </div>
            <div class="album-quest">
                <div class="form-label">Cover Photo</div>
                    <input type="file" id="input-file" accept="image/*">
                    <label for="input-file" class="custom-file-upload" id="file-label">Choose Your Album Cover</label>
            </div>
            <div class="album-quest">
                <div class="form-label">Release Year</div>
                    <input type="date" value="2001-01-01">
            </div>
            <div class="cancel-submit">
                <button class="cancel-btn">Cancel</button>
                <button class="add-btn">Add Song</button>
            </div>
        </form>
    </div>
</body>
</html>
