<?php
require("../admin/inc/essential.php");
require("../admin/inc/dbconfig.php");
include('smtp/PHPMailerAutoload.php');
date_default_timezone_set("Asia/Kolkata");

session_start();
if (!(isset($_SESSION['login']) && ($_SESSION['login'] == true))) {
    redirect('index.php');
}

if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET `booking_status`='cancelled' , `refund`=?
    WHERE `booking_id`=? AND `user_id`=?";

    $values = [0, $frm_data['id'], $_SESSION['u_id']];

    $res = update($query, $values, 'iii');

    echo $res;
}

?>