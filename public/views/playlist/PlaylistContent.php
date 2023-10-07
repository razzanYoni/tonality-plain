<?php
require_once ROOT_DIR . "src/models/PlaylistModel.php";
require_once ROOT_DIR . "src/controllers/PlaylistController.php";
require_once ROOT_DIR . "src/repositories/PlaylistRepository.php";
require_once ROOT_DIR . "src/repositories/SongRepository.php";
require_once ROOT_DIR . "public/components/PlaylistCard.php";

use controllers\PlaylistController;
use repositories\PlaylistRepository;
use repositories\SongRepository;
use models\PlaylistModel;
?>

<div class="playlist-detail-container">
    <div class="cover-detail">
        <div class="playlist-cover">
            <img src="">
        </div>
        <div class="playlist-detail">
            <div class="playlist-title">
                <?php echo $playlist->get('playlist_name')?>
            </div>
            <div class="playlist-description">
                <?php echo $playlist->get('description')?>
            </div>
            <div class="playlist-duration">
                <?php echo SongRepository::getInstance()->getPlaylistDuration($playlist->get('playlist_id'))?>
                <span> minutes</span>
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
            <?php $songs = SongRepository::getInstance()->getSongsFromPlaylist($playlist->get('playlist_id')) ?>
            <?php foreach ($songs as $key => $song): ?>
                <tr class="single-song">
                    <td class="song-number"><?php echo $key + 1; ?></td>
                    <td class="song-title"><?php echo $song['title']; ?></td>
                    <td class="song-duration-body"><?php echo $song['duration']; ?></td>
                    <td><a href="/playlist/<?php echo $playlist->get('playlist_id'); ?>/deletePlaylist"><img src="public/assets/icons/trash-solid.svg" alt="Delete"></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </table>
</div>
