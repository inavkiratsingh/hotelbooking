<?php
require("admin/inc/essential.php");
require("admin/inc/dbconfig.php");

require 'include/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

date_default_timezone_set("Asia/Kolkata");

session_start();
unset($_SESSION['room']);

function regenrate_session($user_id)
{
    $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$user_id], 'i');
    $user_fetch = mysqli_fetch_assoc($user_q);
    $_SESSION['login'] = true;
    $_SESSION['u_id'] = $user_fetch['id'];
    $_SESSION['u_name'] = $user_fetch['name'];
    $_SESSION['u_pic'] = $user_fetch['profile'];
    $_SESSION['u_phone'] = $user_fetch['phone'];
    $_SESSION['u_email'] = $user_fetch['email'];
}


$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api("rzp_test_3G2uTZ548mOpgS", "cUjFrwmjzOXVg36gqAdBLvDa");

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature'],
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {


    $slct_quer = "SELECT `booking_id`,`user_id` FROM `booking_order` WHERE `order_id` = '$_SESSION[razorpay_order_id]'";
    $slct_res = mysqli_query($con, $slct_quer);
    if (mysqli_num_rows($slct_res) == 0) {
        redirect('index.php');
    }

    $slct_fetch = mysqli_fetch_assoc($slct_res);
    if (!isset($_SESSION['login']) && ($_SESSION['login'] == true)) {
        regenrate_session($slct_fetch['user_id']);
    }



    $upd_query = "UPDATE `booking_order` SET `booking_status`='booked',`trans_id`='$_SESSION[razorpay_order_id]',`trans_amt`='$_SESSION[price]',`trans_status`='DONE' WHERE `booking_id` = '$slct_fetch[booking_id]'";

    if (!mysqli_query($con, $upd_query)) {
        echo 'not upadate';
    }

    $html = "<p>Your payment was successful</p>
             <p>Payment ID: $_SESSION[razorpay_order_id] </p>";
} else {
    $upd_query = "UPDATE `booking_order` SET `booking_status`='payment_failed',`trans_id`='$_SESSION[razorpay_order_id]',`trans_amt`='$_SESSION[price]',`trans_status`='DONE', WHERE `booking_id` = '$slct_fetch[booking_id]'";
    mysqli_query($con, $upd_query);

    $html = "your payment does not verified";
}

redirect('pay_status.php?order='.$_SESSION['razorpay_order_id']);

echo $html;

?>