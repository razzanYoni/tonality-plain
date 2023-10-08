<?php

/* @var $duration int
 **/

use utils\TimeConverter;

require_once ROOT_DIR . "src/models/PlaylistModel.php";
require_once ROOT_DIR . "src/controllers/PlaylistController.php";
require_once ROOT_DIR . "src/repositories/PlaylistRepository.php";
require_once ROOT_DIR . "src/repositories/SongRepository.php";
require_once ROOT_DIR . "public/components/PlaylistCard.php";
require_once ROOT_DIR . "src/utils/TimeConverter.php";

$playlistDurationTuple = TimeConverter::getInstance()->secondsToMinutesTuple($duration);
?>

<div class="playlist-detail-container">

  <div class="cover-detail">
    <div class="playlist-cover">
      <img class="playlist-cover-image"
           src="<?php echo '/' . STORAGE_FOLDER . '/' . $playlist->get('cover_filename') ?>"
           alt="Playlist Cover Image">
    </div>
    <div class="playlist-detail">
      <div class="playlist-title">
          <?php echo $playlist->get('playlist_name') ?>
      </div>
      <div class="playlist-description">
          <?php echo $playlist->get('description') ?>
      </div>
      <div class="playlist-duration">
          <?php echo $playlistDurationTuple[0] ?>
        <span> minutes </span>
          <?php echo $playlistDurationTuple[1] ?>
        <span> seconds</span>
      </div>
    </div>
  </div>

  <div class="edit-delete">
    <button class="edit-btn"
            onclick="window.location.href='/playlist/<?php echo $playlist->get('playlist_id'); ?>/updatePlaylist'">
      <img src="/public/assets/icons/pen-solid.svg" alt="Edit">
    </button>
    <button class="delete-btn"
            onclick="document.getElementById('playlist-<?php echo $playlist->get("playlist_id"); ?>').style.display='block'">
      <img src="/public/assets/icons/trash-solid.svg" alt="Delete">
    </button>

  <div id="playlist-<?php echo $playlist->get('playlist_id');?>" class="modal">
      <span onclick="document.getElementById('playlist-<?php echo $playlist->get("laylist_id"); ?>').style.display='none'" class="close" title="Close Modal">×</span>
      <div class="modal-container">
          <h1>Delete <?php echo $playlist->get('playlist_name') ?> Playlist</h1>
          <p>Are you sure you want to delete the Playlist?</p>

          <div class="clearfix">
              <button type="button" onclick="document.getElementById('playlist-<?php echo $playlist->get("playlist_id"); ?>').style.display='none'" class="cancelbtn">Cancel</button>
              <button type="button" onclick="deletePlaylist(<?php echo $playlist->get('playlist_id');?>)" class="deletebtn" >Delete</button>
          </div>
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
        <td><a href="/playlist/<?php echo $playlist->get('playlist_id'); ?>/deletePlaylist"><img
              src="/public/assets/icons/trash-solid.svg" alt="Delete"></a></td>
      </tr>

        <div id="song-<?php echo $song['song_id'];?>" class="modal">
            <span onclick="document.getElementById('song-<?php echo $song["song_id"]; ?>').style.display='none'" class="close" title="Close Modal">×</span>
            <div class="modal-container">
                <h1>Delete <?php echo $song['title'] ?> from <?php echo $playlist->get('playlist_name') ?> Playlist</h1>
                <p>Are you sure you want to delete the Playlist?</p>

                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('song-<?php echo $song["song_id"]; ?>').style.display='none'" class="cancelbtn">Cancel</button>
                    <button type="button" onclick="deleteSongFromPlaylist(<?php echo $song['song_id'];?>, <?php echo $playlist->get('playlist_id');?>)" class="deletebtn" >Delete</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
