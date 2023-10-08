<?php

/* @var $count_song array
 * @var $duration int
 **/

use utils\TimeConverter;

require_once ROOT_DIR . "src/models/AlbumModel.php";
require_once ROOT_DIR . "src/controllers/AlbumController.php";
require_once ROOT_DIR . "src/repositories/AlbumRepository.php";
require_once ROOT_DIR . "src/repositories/SongRepository.php";
require_once ROOT_DIR . "public/components/AlbumCard.php";
require_once ROOT_DIR . "src/utils/TimeConverter.php";

$albumDurationTuple = TimeConverter::getInstance()->secondsToMinutesTuple($duration);
?>

<div class="album-detail-container">
  <div class="cover-detail">
    <div class="album-cover">
      <img class="album-cover-image" src="<?php echo '/' . STORAGE_FOLDER . '/' . $album->get('cover_filename') ?>"
           alt="Album Cover Image">
    </div>
    <div class="album-detail">
      <div class="album-title">
          <?php echo $album->get('album_name') ?>
      </div>
      <div class="album-artist">
          <?php echo $album->get('artist') ?>
      </div>
      <div class="album-date">
          <?php echo $album->get('release_date') ?>
      </div>
      <div class="album-songs">
          <?php echo $count_song ?>
        <span> songs</span>
      </div>
      <div class="album-duration">
          <?php echo $albumDurationTuple[0] ?>
        <span> minutes </span>
          <?php echo $albumDurationTuple[1] ?>
        <span> seconds</span>
      </div>
    </div>
  </div>
</div>
<div class="song-table">
  <table>
    <thead>
    <th class="song-number">#</th>
    <th class="song-title">Title</th>
    <th class="song-duration">Duration</th>
    </thead>
    <tbody>
    <?php foreach ($songs as $key => $song):
        $songDurationTuple = TimeConverter::getInstance()->secondsToMinutesTuple($song['duration']);
        ?>
      <tr class="single-song">
        <td class="song-number"><?php echo $key + 1; ?></td>
        <td class="song-title"><?php echo $song['title']; ?></td>
        <td class="song-duration-body"><?php echo $songDurationTuple[0] . ":" . $songDurationTuple[1]; ?></td>
        <td><a href="/album/<?php echo $album->get('album_id'); ?>/insertSong/<?php echo $song['song_id']; ?>" >
            <img src="/public/assets/icons/plus-solid.svg" alt="Add"></a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
