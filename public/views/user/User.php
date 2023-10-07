<?php

/** @var $users array*/

?>

<div class="user-table">
    <table>
        <thead>
        <th class="user-number">#</th>
        <th class="user-title">username</th>
        <th class="user-duration">isAdmin</th>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $user): ?>
            <tr class="single-user">
                <td class="user-number"><?php echo $key + 1; ?></td>
                <td class="user-title"><?php echo $user['username']; ?></td>
                <td class="user-duration-body"><?php echo $user['is_admin']; ?></td>
                <td><a href="/user/<?php echo $user['user_id']; ?>/deleteUser"><img src="public/assets/icons/trash-solid.svg" alt="Delete"></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

