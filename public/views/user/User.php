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
                <td><a onclick="document.getElementById('user-<?php echo $user['user_id']; ?>').style.display='block'">
                        <img src="public/assets/icons/trash-solid.svg" alt="Delete"></a></td>
            </tr>

            <div id="user-<?php echo $user['user_id'];?>" class="modal">
                <span onclick="document.getElementById('user-<?php echo $user["user_id"]; ?>').style.display='none'" class="close" title="Close Modal">×</span>
                <div class="modal-container">
                    <h1>Delete <?php echo $user['username'] ?></h1>
                    <p>Are you sure you want to delete the User?</p>

                    <div class="clearfix">
                        <button type="button" onclick="document.getElementById('user-<?php echo $user["user_id"]; ?>').style.display='none'" class="cancel-btn">Cancel</button>
                        <button type="button" onclick="deleteUser(<?php echo $user['user_id'];?>,)" class="delete-btn" >Delete</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

