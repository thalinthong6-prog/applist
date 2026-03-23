<?php

function usernameExists($username)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}

function registerUser($name, $username, $passwd)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_users (name,username,passwd) VALUES (?,?,?)');
    $query->bind_param('sss', $name, $username, $passwd);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

function logUserIn($username, $passwd)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ? AND passwd = ?');
    $query->bind_param('ss', $username, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return false;
}

function loggedInUser()
{
    global $db;
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id = ?');
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return null;
}

function isAdmin(){
    $user = loggedInUser();
    return ($user && isset($user->level) && $user->level === 'admin');
}

function isUserHasPassword($passwd)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare(
        "SELECT * FROM tbl_users WHERE id = ? AND passwd = ?"
    );
    $query->bind_param('ss', $user->id, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}

function setUserNewPassowrd($passwd)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare(
        "UPDATE tbl_users SET passwd = ? WHERE id = ?"
    );
    $query->bind_param('ss',  $passwd, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function updateUserPhoto($userId, $fileName) {
    global $db;
    $query = $db->prepare(
        "UPDATE tbl_users SET photo = ? WHERE id = ?"
    );
    $query->bind_param('ss',  $fileName, $userId);
    $query->execute();
    return $db->affected_rows > 0;
}
function deleteUserPhoto($userId) {
    global $db;
    $query = $db->prepare(
        "SELECT photo FROM tbl_users WHERE id = ?"
    );
    $query->bind_param('s',  $userId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        $user = $result->fetch_object();
        if ($user->photo) {
            unlink("uploads/" . $user->photo);
        }
    }

    $query = $db->prepare(
        "UPDATE tbl_users SET photo = NULL WHERE id = ?"
    );
    $query->bind_param('s',  $userId);
    $query->execute();
    return $db->affected_rows > 0;
}
function getUserPhoto($userId) {
    global $db;
    $query = $db->prepare(
        "SELECT photo FROM tbl_users WHERE id = ?"
    );
    $query->bind_param('s',  $userId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        $user = $result->fetch_object();
        return $user->photo;
    }
    return null;
}

function uploadimages($image)
{
    $img_name = $image['name'];
    $img_size = $image['size'];
    $tmp_name = $image['tmp_name'];
    $error = $image['error'];

    $dir = './assets/images/';
    $allow_exs = ['jpg', 'png', 'jpeg'];
    $images_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $image_lowercase_ex = strtolower($images_ex);

    if(!in_array($image_lowercase_ex, $allow_exs)) {
        throw new Exception('File extension is not allowed');
    }

    if ($error !== 0) {
        throw new Exception('Unkonw error occurred!');
    }

    if ($img_size > 500000) {
        throw new Exception('File size is too large!');
    }

    $new_image_name = uniqid("PI-") . '.' . $image_lowercase_ex;
    $image_path = $dir . $new_image_name;
    move_uploaded_file($tmp_name, $image_path);
    return $image_path;
}