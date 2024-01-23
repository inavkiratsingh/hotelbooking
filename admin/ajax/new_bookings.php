<?php
require("../inc/essential.php");
require("../inc/dbconfig.php");
admin_login();

if (isset($_POST['get_bookings'])) {

    $frm_data = filteration($_POST);

    // $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    //     INNER JOIN `booking_details` bd on bo.booking_id=bd.booking_id
    //     WHERE (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.user_name LIKE ?) AND
    //     WHERE (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id ASC";
    $query = "SELECT bo.*, bd.* 
    FROM booking_order bo
    INNER JOIN booking_details bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phone LIKE ? OR bd.user_name LIKE ?) 
    AND bo.booking_status = ? AND bo.arrival = ?
    ORDER BY bo.booking_id ASC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", 'booked', 0], 'sssss');
    $i = 1;
    $booking_data = '';

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No User Found !</b>";
        exit;
    }
    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));
        $booking_data .= "
        <tr>
            <td>$i</td>
            <td>
                <span class='badge bg-primary'>
                    Order Id: $data[order_id]
                </span>    
                <br>
                <b>Name :</b> $data[user_name]
                <br>
                <b>Phone no. :</b> $data[phone]
            </td>
            <td>
                <b>Room :</b> $data[room_name]
                <br>
                <b>Price :</b> ₹$data[price]
            </td>
            <td>
                <b>Check in :</b> $checkin
                <br>
                <b>Check out :</b> $checkout
                <br>
                <b>Paid :</b> ₹$data[trans_amt]
                <br>
                <b>Date :</b> $date
            </td>
            <td>
            <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white fw-bold custom-bg shadown-none btn-small' data-bs-toggle='modal' data-bs-target='#assign-room'>
                <i class='bi bi-check2-square'></i> Assign Room
            </button>
            <br>
            <button type='button' onclick='cancel_booking($data[booking_id])' class='btn fw-bold btn-outline-danger mt-2 shadown-none btn-small'>
                <i class='bi bi-trash'></i> Cancel Booking
            </button>
            </td>
        </tr>
        ";
        $i++;
    }
    echo $booking_data;
}

if (isset($_POST['assign_room'])) {
    $frm_data = filteration($_POST);

    // $q = "UPDATE `booking_order` bo 
    //     INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
    //     SET bo.arrival=? AND bd.room_no=? WHERE bo.booking_id=?";

    $q1 = update("UPDATE `booking_order` SET `arrival`=?, `rate_review`=? Where booking_id = ?", [1, 0, $frm_data['booking_id']], 'iii');
    $q2 = update("UPDATE `booking_details` SET `room_no`=? Where booking_id = ?", [$frm_data['room_num'], $frm_data['booking_id']], 'ii');
    echo $q1;


    // $values = [1, $frm_data['room_num'], $frm_data['booking_id']];

    // $res = update($q, $values, 'isi');

    // echo ($res == 2) ? 1 : 0;
}

if (isset($_POST['cancel_booking'])) {

    $frm_data = filteration($_POST);

    $res = update("UPDATE `booking_order` SET `booking_status`=?, `refund`=? Where booking_id = ?", ['cancelled', 0, $frm_data['booking_id']], 'sii');

    echo $res;
}



?>