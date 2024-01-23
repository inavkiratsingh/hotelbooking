<?php

// frontend purpose data
define('SITE_URL', 'http://127.0.0.1/HOTELBOOKING/');
define('ABOUT_IMG_PATH', SITE_URL . 'assets/images/about/');
define('CAROUSAL_IMG_PATH', SITE_URL . 'assets/images/carousel/');
define('FACILITIES_IMG_PATH', SITE_URL . 'assets/images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL . 'assets/images/rooms/');
define('USERS_IMG_PATH', SITE_URL . 'assets/images/users/');


// backend use only

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/HOTELBOOKING/assets/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSAL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');


// email sending backend

define('EMAIL', 'w0438414@gmail.com');
define('USERNAME', 'HOTEL');

function admin_login()
{
    session_start();
    if (!(isset($_SESSION["admin_login"]) && $_SESSION["admin_login"] == true)) {
        echo "
        <script>
        window.location.href='index.php';
        </script>        
    ";
        exit;
    }
}

function redirect($url)
{
    echo "
        <script>
        window.location.href='$url';
        </script>
    ";
    exit;
}

function alert($type, $msg)
{
    $bs_type = ($type == 'success') ? 'alert-success' : 'alert-danger';
    echo <<<alert
    <div id="#alert" class="alert $bs_type alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">$msg</strong>
        <button type="button" class="btn-close" data-dismiss="#alert" aria-label="Close"></button>
    </div>
    alert;
}

function upload_img($image, $folder)
{
    $valid = ["image/jpeg", 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid)) {
        return 'inv_img'; //invalid image format
    } else if ($image['size'] / (1024 * 1024) > 2) {
        return 'inv_size'; //invalid size
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(111, 999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

function upload_svg($image, $folder)
{
    $valid = ['image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid)) {
        return 'inv_img'; //invalid image format
    } else if ($image['size'] / (1024 * 1024) > 1) {
        return 'inv_size'; //invalid size
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(111, 999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}


function delete_img($image, $folder)
{
    if (unlink(UPLOAD_IMAGE_PATH . $folder . $image)) {
        return true;
    } else {
        return false;
    }
}

function uploadUserImage($image)
{
    $valid = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    // Convert both MIME types to lowercase for case-insensitive comparison
    $img_mime_lower = strtolower($img_mime);
    $valid_lower = array_map('strtolower', $valid);

    if (!in_array($img_mime_lower, $valid_lower)) {
        return 'inv_img'; //invalid image format
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(111, 999) . ".jpeg";

        $img_path = UPLOAD_IMAGE_PATH . USERS_FOLDER . $rname;

        if ($ext == 'png' || $ext == 'PNG') {
            $img = imagecreatefrompng($image['tmp_name']);
        } else if ($ext == 'webp' || $ext == 'WEBP') {
            $img = imagecreatefromwebp($image['tmp_name']);
        } else {
            $img = imagecreatefromjpeg($image['tmp_name']);
        }

        if (imagejpeg($img, $img_path, 75)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}
?>