<?php
require("../inc/essential.php");
require("../inc/dbconfig.php");
admin_login();

if (isset($_POST['get_users'])) {
    $res = selectAll('user_cred');
    $i = 1;
    $path = USERS_IMG_PATH;

    $data = '';

    while ($row = mysqli_fetch_assoc($res)) {
        $verified = '<span class="badge bg-warning"><i class="bi bi-x-lg"></i></span>';
        $del_btn = "<button type='button' onclick='rem_user($row[id])' class='btn btn-sm btn-danger         shadow-none'>
            <i class='bi bi-trash'></i>
        </button>";
        if ($row['is_verified']) {
            $del_btn ='';
            $verified = '<span class="badge bg-success"><i class="bi bi-check-lg"></i></span>';
        }

        $status = "<button onclick='toggle_status($row[id], 0)' class ='btn btn-sm btn-dark shadow-none'>
            active
        </button>";

        if (!$row['status']) {
            $status = "<button onclick='toggle_status($row[id], 1)' class ='btn btn-sm btn-danger shadow-none'>
                Inactive
            </button>";
        }

        $date = date("d-m-Y", strtotime($row['dateandtime']));

        $data .= "
        <tr>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width='55px'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phone]</td>
            <td>$row[address] | $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
        </tr>
        ";
        $i++;
    }

    echo $data;

}

if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];
    if (update($q, $v, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['remove_user'])) {
    $frm_data = filteration($_POST);

    $res = delete("DELETE FROM `user_cred` WHERE `id`=? AND `is_verified`=?", [$frm_data['user_id'],0], 'ii');

    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['search_users'])) {
    $frm_data = filteration($_POST);
    $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";
    $res = select($query, ["%$frm_data[name]%"],'s');
    $i = 1;
    $path = USERS_IMG_PATH;

    $data = '';

    while ($row = mysqli_fetch_assoc($res)) {
        $verified = '<span class="badge bg-warning"><i class="bi bi-x-lg"></i></span>';
        $del_btn = "<button type='button' onclick='rem_user($row[id])' class='btn btn-sm btn-danger         shadow-none'>
            <i class='bi bi-trash'></i>
        </button>";
        if ($row['is_verified']) {
            $del_btn ='';
            $verified = '<span class="badge bg-success"><i class="bi bi-check-lg"></i></span>';
        }

        $status = "<button onclick='toggle_status($row[id], 0)' class ='btn btn-sm btn-dark shadow-none'>
            active
        </button>";

        if (!$row['status']) {
            $status = "<button onclick='toggle_status($row[id], 1)' class ='btn btn-sm btn-danger shadow-none'>
                Inactive
            </button>";
        }

        $date = date("d-m-Y", strtotime($row['dateandtime']));

        $data .= "
        <tr>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width='55px'>
                <br>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phone]</td>
            <td>$row[address] | $row[pincode]</td>
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
        </tr>
        ";
        $i++;
    }

    echo $data;

}
?>