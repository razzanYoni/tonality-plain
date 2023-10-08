<?php

/** @var $title string
 * @var $totalPage int
 * @var $page int
 * */
require_once ROOT_DIR . "public/components/NavBar.php";
require_once ROOT_DIR . "public/components/Pagination.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/public/js/Search.js"></script>
  <link rel="stylesheet" href="/public/css/Global.css" type="text/css">
  <link rel="stylesheet" href="/public/css/NavBar.css" type="text/css">
  <link rel="stylesheet" href="/public/css/Pagination.css" type="text/css">

  <link rel="stylesheet" href="/public/css/PlaylistCard.css" type="text/css">
  <link rel="stylesheet" href="/public/css/PlaylistPage.css" type="text/css">

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
echo NavBar(currentPage: "Playlists");
?>

<div class="playlist-container">
  {{content}}
</div>

<?php
echo Pagination(totalPage: $totalPage, currentPage: $page);
?>
</body>
</html>
