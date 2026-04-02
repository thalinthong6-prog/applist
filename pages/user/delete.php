<?php
$id = $_GET['id'];
$targetUser = readUser($id);
if ($targetUser == null || $targetUser->level == 'admin') {
    header('./?page=user/list');
}else {
    if (deleteUser($id)) {
        echo '<div class="alert alert-success" role="alert">
        Delete successful! <a href="./?page=user/list">Employee list</a>
        </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Delete failed! Please try again.
        </div>';
    }
}