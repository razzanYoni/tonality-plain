<?php

/** @var $users array*/

?>

<div class="song-table">
    <table>
        <thead>
        <th class="song-number">#</th>
        <th class="song-title">username</th>
        <th class="song-duration">isAdmin</th>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $user): ?>
            <tr class="single-song">
                <td class="song-number"><?php echo $key + 1; ?></td>
                <td class="song-title"><?php echo $user['username']; ?></td>
                <td class="song-duration-body"><?php echo $user['is_admin']; ?></td>
                <td><a href="/user/<?php echo $user['user_id']; ?>/deleteUser"><img src="public/assets/icons/trash-solid.svg" alt="Delete"></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

