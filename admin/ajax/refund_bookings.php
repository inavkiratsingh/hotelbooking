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
    AND bo.booking_status = ? AND bo.refund = ?
    ORDER BY bo.booking_id ASC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", 'cancelled', 0], 'sssss');
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
                <b>Check in :</b> $checkin
                <br>
                <b>Check out :</b> $checkout
                <br>
                <b>Date :</b> $date
            </td>
            <td>
                <b>$data[trans_amt]</b>
            </td>
            <td>
                <button type='button' onclick='refund_booking($data[booking_id])' class='btn fw-bold btn-success shadown-none btn-small'>
                    <i class='bi bi-cash-stack'></i> Refund Booking
                </button>
            </td>
        </tr>
        ";
        $i++;
    }
    echo $booking_data;
}


if (isset($_POST['refund_booking'])) {

    $frm_data = filteration($_POST);

    $res = update("UPDATE `booking_order` SET `refund`=? Where booking_id = ?", [1, $frm_data['booking_id']], 'ii');

    echo $res;
}



?>