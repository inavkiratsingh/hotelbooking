<?php
require("../admin/inc/essential.php");
require("../admin/inc/dbconfig.php");
include('smtp/PHPMailerAutoload.php');
date_default_timezone_set("Asia/Kolkata");

function sendMail($email,$token,$type)
{

    if($type == 'email_confirmation'){
        $page = 'email_confirm.php';
        $subject = "Account Verification Link";
        $content = "Confirm Your Email";
    } else{
        $page = 'index.php';
        $subject = "Account Reset Link";
        $content = "Reset Your Password";
    }

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    //$mail->SMTPDebug = 2; 
    $mail->Username = EMAIL;
    $mail->Password = "ceil pytp rwtj ozki";
    $mail->SetFrom(EMAIL);
    $mail->Subject = $subject;
    $mail->Body = "
    Click the link to $content: <br>
    <a href = '" . SITE_URL . "$page?$type&email=$email&token=$token" . "'>
    CLICK ME
    </a>
    ";
    $mail->AddAddress($email);
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if (!$mail->Send()) {
        return 0;
    } else {
        return 1;
    }
}

if (isset($_POST['register'])) {
    $data = filteration($_POST);

    // match password and confirm passsword 
    if ($data['pass'] != $data['cpass']) {
        echo 'pass_missmatch';
        exit;
    }

    // check user exist 

    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1", [$data['email'], $data['phonenum']], 'ss');

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    // upload user image to server

    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    // send confirmation link to user's email
    $token = bin2hex(random_bytes(16));

    if (!sendMail($data['email'], $token, 'email_confirmation')) {
        echo 'mail_failed';
        exit;
    }



    // currently not created  

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `pincode`, `phone`, `dob`,`profile`,`password`,`token`) VALUES (?,?,?,?,?,?,?,?,?)";

    $values = [$data['name'], $data['email'], $data['address'], $data['pincode'], $data['phonenum'], $data['dob'], $img, $enc_pass, $token];

    if (insert($query, $values, 'sssssssss')) {
        echo 1;
    } else {
        echo 'ins_failed';
    }
}

if (isset($_POST['login'])) {
    $data = filteration($_POST);

    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1", [$data['email_mob'], $data['email_mob']], 'ss');

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email_mob';
    } else {
        $ufetch = mysqli_fetch_assoc($u_exist);
        if ($ufetch['is_verified'] == 0) {
            echo 'not_verified';
        } else
            if ($ufetch['status'] == 0) {
                echo 'inactive';
            } else {
                if (!password_verify($data['pass'], $ufetch['password'])) {
                    echo 'inv_pass';
                } else {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['u_id'] = $ufetch['id'];
                    $_SESSION['u_name'] = $ufetch['name'];
                    $_SESSION['u_pic'] = $ufetch['profile'];
                    $_SESSION['u_phone'] = $ufetch['phone'];
                    $_SESSION['u_email'] = $ufetch['email'];
                    echo 1;
                }
            }
    }


}

if (isset($_POST['forgot_pass'])) {
    $data = filteration($_POST);

    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1", [$data['email']], 's');

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email';
    } else {
        $ufetch = mysqli_fetch_assoc($u_exist);
        if ($ufetch['is_verified'] == 0) {
            echo 'not_verified';
        } else
            if ($ufetch['status'] == 0) {
                echo 'inactive';
            } else {
                // send reset link to email 
                $token_for = bin2hex(random_bytes(16));
                if(!sendMail($data['email'],$token_for,'account_recovery')){
                    echo 'mail_failed';
                }
                else{
                    $date = date('Y-m-d');

                    $query = mysqli_query($con , "UPDATE `user_cred` SET `token`= '$token_for', `t_expire`= '$date' WHERE `id` = '$ufetch[id]'");

                    if($query){
                        echo 1;
                    } else {
                        echo 'upd_failed';
                    }
                }
            }
    }

}

if (isset($_POST['recovery_pass'])) {
    $data = filteration($_POST);

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "UPDATE `user_cred` SET `password`=?, `token`=?, `t_expire`=? WHERE `email`=? AND `token`=?";

    $values = [$enc_pass, null, null, $data['email'], $data['token']];

    if(update($query,$values,'sssss')){
        echo 1;
    } else{
        echo 'failed';
    }
}
?>