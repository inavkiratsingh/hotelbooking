<?php
require("../inc/essential.php");
require("../inc/dbconfig.php");
admin_login();


if (isset($_POST['get_general'])) {
    $q = "SELECT * FROM settings WHERE `srno` = ?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $json_Data = json_encode($data);
    echo $json_Data;
}


if (isset($_POST["upd_general"])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `settings` SET `site_title`=?,`site_about`=? WHERE `srno`=?";
    $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
    $res = update($q, $values, 'ssi');

    echo $res;
}

if (isset($_POST["upd_shutdown"])) {
    $frm_data = ($_POST['upd_shutdown'] == 0) ? 1 : 0;

    $q = "UPDATE `settings` SET `shutdown`=? WHERE `srno`=?";
    $values = [$frm_data, 1];
    $res = update($q, $values, 'ii');

    echo $res;
}

if (isset($_POST["get_contact"])) {
    $q = "SELECT * FROM contact_details WHERE `srno` = ?";
    $values = [1];
    $res = select($q, $values, "i");
    $data = mysqli_fetch_assoc($res);
    $json_Data = json_encode($data);
    echo $json_Data;
}

if (isset($_POST["upd_contact"])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `contact_details` SET `address`='?',`gmap`='?',`pn1`='?',`pn2`='?',`email`='?',`fb`='?',`insta`='?',`tw`='?',`iframe`='?' WHERE `srno`='?'";
    $values = [$frm_data['address'], $frm_data['gmap'], $frm_data['pn1'], $frm_data['pn2'], $frm_data['email'], $frm_data['fb'], $frm_data['insta'], $frm_data['tw'], $frm_data['iframe'], 1];
    $res = update($q, $values, 'sssssssssi');

    echo $res;
}

if (isset($_POST["add_member"])) {
    $frm_Data = filteration($_POST);
    $img_r = upload_img($_FILES['picture'], ABOUT_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?,?)";
        $values = [$frm_Data['name'], $img_r];
        $res = insert($q, $values, 'ss');
        echo $res;
    }
}

if (isset($_POST['get_members'])) {
    $res = selectAll('team_details');

    while ($row = mysqli_fetch_assoc($res)) {
        $path = ABOUT_IMG_PATH;
        echo <<<data
        <div class="col-md-2 mb-3">
            <div class="card bg-dark text-white">
                <img class="card-img" src="$path$row[picture]">
                <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none" onclick="rem_member($row[srno])" type="button">
                        <i class="bi bi-trash"></i>Delete
                    </button>
                </div>
                    <p class="card-text text-center px-3 px-2">$row[name]</p>
            </div>
        </div>
        data;
    }
}

if (isset($_POST['rem_member'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_member']];

    $pre_q = "select * from team_details where srno = ?";
    $res = select($pre_q, $values, 'i');
    $img = mysqli_fetch_assoc($res);

    if (delete_img($img['picture'], ABOUT_FOLDER)) {
        $q = "DELETE FROM `team_details` WHERE `srno` = ?";
        $res = delete($q, $values, 'i');
        echo $res;
    } else {
        echo 0;
    }
}

?>