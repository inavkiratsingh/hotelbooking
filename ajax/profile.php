<?php
require("../admin/inc/essential.php");
require("../admin/inc/dbconfig.php");
date_default_timezone_set("Asia/Kolkata");
session_start();

if (isset($_POST['info_form'])) {
    $frm_data = filteration($_POST);

    $u_exist = select("SELECT * FROM `user_cred` WHERE `phone`=? AND `id`!=? LIMIT 1", [$frm_data['phone'], $_SESSION['u_id']], 'si');

    if (mysqli_num_rows($u_exist) != 0) {
        echo 'phone_already';
        exit;
    }

    $query = "UPDATE `user_cred` SET `name`=?,`address`=?,`pincode`=?,`phone`=?,
        `dob`=? WHERE `id`=?";
    $values = [$frm_data['name'], $frm_data['address'], $frm_data['pincode'], $frm_data['phone'], $frm_data['dob'], $_SESSION['u_id']];

    if (update($query, $values, 'sssssi')) {
        $_SESSION['u_name'] = $frm_data['name'];
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['profile_form'])) {
    
    $img = uploadUserImage($_FILES['profile']);
    
    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }
    
    
    
    // fetching old image and deleting it
    
    
    $u_exist = select("SELECT `profile` FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['u_id']], 'i');
    $u_fetch = mysqli_fetch_assoc($u_exist);
    
    delete_img($u_fetch['profile'], USERS_FOLDER);
    
    $query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=?";
    $values = [$img, $_SESSION['u_id']];
    
    if (update($query, $values, 'si')) {
        $_SESSION['u_pic'] = $img;
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['pass_form'])) {
    $frm_data = filteration($_POST);

    if($frm_data['new_pass'] != $frm_data['comfirm_pass']){
        echo 'missmatch';
        exit;
    }

    $enc_pass = password_hash($data['new_pass'], PASSWORD_BCRYPT);

    $query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";
    $values = [$_SESSION['u_id'], $enc_pass];
    
    if (update($query, $values, 'ss')) {
        echo 1;
    } else {
        echo 0;
    }
}

?>