<?php
require("../inc/essential.php");
require("../inc/dbconfig.php");
admin_login();

if (isset($_POST['booking_analytics'])) {

    $frm_data = filteration($_POST);

    $condition = "";
    if ($frm_data['period'] == 1) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    } else if ($frm_data['period'] == 2) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    } else if ($frm_data['period'] == 3) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $results = mysqli_fetch_assoc(mysqli_query($con, "SELECT
        COUNT(CASE WHEN booking_status != 'pending' AND booking_status!='payment_failed' THEN 1 END) AS `total_bookings`,
        SUM(CASE WHEN booking_status != 'pending' AND booking_status!='payment_failed' THEN `trans_amt` END) AS `total_amount`,

        COUNT(CASE WHEN booking_status = 'booked' AND arrival=1 THEN 1 END) AS `active_bookings`,
        SUM(CASE WHEN booking_status = 'booked' AND arrival=1 THEN `trans_amt` END) AS `active_amount`,

        COUNT(CASE WHEN booking_status = 'cancelled' AND refund=1 THEN 1 END) AS `cancelled_bookings`,
        SUM(CASE WHEN booking_status = 'cancelled' AND refund=1 THEN `trans_amt` END) AS `cancelled_amount` 

        FROM `booking_order` $condition"));

    $output = json_encode($results);

    echo $output;
}

if (isset($_POST['user_analytics'])) {

    $frm_data = filteration($_POST);

    $condition = "";
    if ($frm_data['period'] == 1) {
        $condition_q = "WHERE date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        $condition_r = "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        $condition_u = "WHERE dateandtime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";

    } else if ($frm_data['period'] == 2) {
        $condition_q = "WHERE date BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        $condition_r = "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        $condition_u = "WHERE dateandtime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";

    } else if ($frm_data['period'] == 3) {
        $condition_q = "WHERE date BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        $condition_r = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        $condition_u = "WHERE dateandtime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";

    }

    $total_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(srno) AS `count` 
    FROM `user_queries` $condition_q"));

    $total_reviews = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS `count` 
        FROM `rating_review` $condition_r"));

    $total_new_reg = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS `count` 
        FROM `user_cred` $condition_u"));

    $output = [
        'total_queries' => $total_queries['count'],
        'total_reviews' => $total_reviews['count'],
        'total_users' => $total_new_reg['count']
    ];

    $output = json_encode($output);

    echo $output;
}





?>