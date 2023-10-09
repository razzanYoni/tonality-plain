<?php
require_once ROOT_DIR . "src/forms/Form.php";

/**
 * @var int $song_id
 * @var int $album_id
 */

use cores\Application;
use forms\Form;
use repositories\PlaylistRepository;
use repositories\SongRepository;

$form = new Form();

$songTitle = SongRepository::getInstance()->getSongById($song_id)['title'];
$playlists = PlaylistRepository::getInstance()->getPlaylistsByUserId(where: ["user_id" => Application::getInstance()->loggedUser->getUserId()]);

?>

<div class="form-container">
  <h1>
    Add Song to Playlist
  </h1>

    <?php $form = Form::begin('', 'post', ['class' => 'form-list']) ?>

  <div class="playlist-quest">
    <div class="form-label">Song</div>
    <div class="song-name"><?php echo $songTitle ?></div>
  </div>

  <div class="playlist-quest">
    <label class="form-select-label" for="playlist-item">Select a Playlist</label>
    <select id="playlist-item" name="selected-playlist">
        <?php
        foreach ($playlists as $playlist) {
            // Output an <option> element for each playlist
            echo '<option value="' . $playlist['playlist_id'] . '">' . $playlist['playlist_name'] . '</option>';
        }
        ?>
    </select>
  </div>

  <div class="cancel-submit">
    <input type="button" class="cancel-btn" onclick="window.location.href='/album/<?php echo $album_id; ?>'" value="Cancel">
    <button class="add-btn" formaction="/album/<?php echo $album_id ?>/insertSong/<?php echo $song_id ?>">Add Song
    </button>
  </div>

    <?php Form::end() ?>
</div>