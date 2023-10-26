<?php

/** @var $title string
 * @var $totalPage int
 * @var $page int
 * @var $is_admin bool
 * */
require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "public/components/Pagination.php";
require_once ROOT_DIR . "public/components/FilterSort.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/public/js/Search.js"></script>
  <script src="/public/js/FilterSort.js"></script>
  <link rel="stylesheet" href="/public/css/Global.css" type="text/css">
  <link rel="stylesheet" href="/public/css/NavBar.css" type="text/css">
  <link rel="stylesheet" href="/public/css/Pagination.css" type="text/css">

  <link rel="stylesheet" href="/public/css/AlbumCard.css" type="text/css">
  <link rel="stylesheet" href="/public/css/AlbumPage.css" type="text/css">
  <link rel="stylesheet" href="/public/css/FilterSort.css" type="text/css">

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
echo NavBar(currentPage: "Albums");
?>

<div class="album-page-controls">
    <?php
    echo FilterSort();

    if ($is_admin) {
        // If the user is an admin, echo the "Add Album" button
        echo '
        <button class="add-album-btn" onclick="window.location.href=\'/albumAdmin/insertAlbum\'">
            <img src="/public/assets/icons/plus-solid.svg" alt="Add Album">
        </button>';
    }
    ?>
</div>

<div class="albums">
  {{content}}
</div>

<?php
echo Pagination(totalPage: $totalPage, currentPage: $page);
?>
</body>
</html>
