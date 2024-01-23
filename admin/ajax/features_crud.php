<?php
require("../inc/essential.php");
require("../inc/dbconfig.php");
admin_login();


if (isset($_POST["add_feature"])) {
    $frm_Data = filteration($_POST);
    $q = "INSERT INTO `features`(`name`) VALUES (?)";
    $values = [$frm_Data['name']];
    $res = insert($q, $values, 's');
    echo $res;

}

if (isset($_POST['get_features'])) {
    $res = selectAll('features');
    $i = 1;

    while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
        <tr>
            <td>$i</td>
            <td>$row[name]</td>
            <td>
                <button class="btn btn-danger btn-sm shadow-none" onclick="rem_feature($row[id])" type="button">
                    <i class="bi bi-trash"></i>Delete
                </button>
            </td>
        </tr>
        data;
        $i = $i + 1;
    }
}

if (isset($_POST['rem_feature'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_feature']];

    $check_q = select("SELECT * FROM `room_features` WHERE `features_id`=?", [$frm_data['rem_feature']], 'i');
    if (mysqli_num_rows($check_q) == 0) {
        $q = "DELETE FROM `features` where id = ?";
        $res = delete($q, $values, 'i');
        echo $res;
    } else {
        echo 'room_added';
    }


}

if (isset($_POST["add_facility"])) {
    $frm_Data = filteration($_POST);
    $img_r = upload_svg($_FILES['icon'], FACILITIES_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } else if ($img_r == 'inv_size') {
        echo $img_r;
    } else if ($img_r == 'upd_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `facilities`(`icon`,`name`, `description`) VALUES (?,?,?)";
        $values = [$img_r, $frm_Data['name'], $frm_Data['desc']];
        $res = insert($q, $values, 'sss');
        echo $res;
    }
}

if (isset($_POST['get_facilities'])) {
    $res = selectAll('facilities');
    $i = 1;
    $path = FACILITIES_IMG_PATH;

    while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
        <tr class = "align-middle">
            <td>$i</td>
            <td><img src = "$path$row[icon]" width="100px"></td>
            <td>$row[name]</td>
            <td>$row[description]</td>
            <td>
                <button class="btn btn-danger btn-sm shadow-none" onclick="rem_facility($row[id])" type="button">
                    <i class="bi bi-trash"></i>Delete
                </button>
            </td>
        </tr>
        data;
        $i = $i + 1;
    }
}

if (isset($_POST['rem_facility'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_facility']];


    $check_q = select("SELECT * FROM `room_facilities` WHERE `facilities_id`=?", [$frm_data['rem_facility']], 'i');

    if (mysqli_num_rows($check_q) == 0) {
        $pre_q = "select * from facilities where id = ?";
        $res = select($pre_q, $values, 'i');
        $img = mysqli_fetch_assoc($res);


        if (delete_img($img['icon'], FACILITIES_FOLDER)) {
            $q = "DELETE FROM `facilities` where id = ?";
            $res = delete($q, $values, 'i');
            echo $res;
        } else {
            echo 0;
        }
    } else {
        echo 'room_added';
    }
}
?>