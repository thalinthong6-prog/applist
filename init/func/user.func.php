<?php
function createUser($name, $username, $passwd, $address, $photo)
{
    global $db;

    $image_path = null;
    if (!empty($photo['name'])) {
        $image_path = uploadimages($photo);
    }

    $query = $db->prepare('INSERT INTO tbl_users (name,username,passwd,photo,address) VALUES (?,?,?,?,?)');
    $query->bind_param('sssss', $name, $username, $passwd, $image_path, $address);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

function getUsers()
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE level <> "admin"');
    $query->execute();
    $result = $query->get_result();
    return $result;
}
function readUser($id)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id=?');
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_object();
    }
    return null;
}
function deleteUser($id)
{
    global $db;
    $query = $db->prepare('DELETE FROM tbl_users WHERE id=?');
    $query->bind_param('i', $id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}
function updateUser($id, $name, $username, $passwd, $photo, $address)
{
    global $db;

    $image_path = null;
    if (!empty($photo['name'])) {
        $image_path = uploadimages($photo);
    }

    if ($image_path) {
        $query = $db->prepare('UPDATE tbl_users SET name=?, username=?, passwd=?, photo=?, address=? WHERE id=?');
        $query->bind_param('sssssi', $name, $username, $passwd, $image_path, $address, $id);
    } else {

        if ($image_path) {

            $query = $db->prepare('UPDATE tbl_users 
                                   SET name=?, username=?, photo=? , address=? 
                                   WHERE id=?');

            $query->bind_param('sssi', $name, $username, $image_path, $address, $id);

        } else {

            $query = $db->prepare('UPDATE tbl_users 
                                   SET name=?, username=?, address=? 
                                   WHERE id=?');

            $query->bind_param('sssi', $name, $username, $address, $id);
        }

    }
    
    $query->execute();
    if ($db->affected_rows >= 0) {
        return true;
    }
    return false;
}

function createUserWithPermissions($name, $username, $password, $photo, $permissions, $address) {
    $can_create = in_array('create', $permissions) ? 1 : 0;
    $can_view   = in_array('view', $permissions) ? 1 : 0;
    $can_edit   = in_array('edit', $permissions) ? 1 : 0;
    $can_delete = in_array('delete', $permissions) ? 1 : 0;

    // SQL insert here
}
?>