<?php
require("../admin/inc/essential.php");
require("../admin/inc/dbconfig.php");
date_default_timezone_set("Asia/Kolkata");

session_start();


if (isset($_GET['fetch_room'])) {
    $chk_avail = json_decode($_GET['chk_avail'], true);

    //check in out filter
    if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($chk_avail['checkin']);
        $checkout_date = new DateTime($chk_avail['checkout']);

        if ($checkin_date == $checkout_date) {
            echo "<h3 class='text-center text-danger'>Invalid dates! Checkin and Checkout dates are not equal.</h3>";
            exit;
        } else if ($checkin_date > $checkout_date) {
            echo "<h3 class='text-center text-danger'>Invalid dates! Checkin date must be smaller than Checkout date.</h3>";
            exit;
        } else if ($checkin_date < $today_date) {
            echo "<h3 class='text-center text-danger'>Invalid dates! Check in date must be greater or equal to todays date .</h3>";
            exit;
        }
    }

    $guests = json_decode($_GET['guests'], true);
    $adults = ($guests['adults'] != '') ? $guests['adults'] : 0;
    $children = ($guests['children'] != '') ? $guests['children'] : 0;


    //facilities decode
    $facilities_list = json_decode($_GET['facilities_list'], true);


    // variables
    $count_rooms = 0;
    $output = "";

    //fetching setting table to check website is shutdown or not
    $settings_q = "SELECT * FROM `settings` WHERE srno = 1";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con, $settings_q));


    // query for rooms card with guests filter
    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status` = ? AND `removed`=?", [$adults, $children, 1, 0], 'iiii');
    while ($room_data = mysqli_fetch_assoc($room_res)) {
        if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {

            // check room is available or not
            $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
                WHERE `booking_status`=? AND `room_id`=?
                AND check_out > ? AND check_in < ?";
            $values = ['booked', $room_data['id'], $chk_avail['checkin'], $chk_avail['checkout']];

            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'siss'));


            if ($room_data['quantity'] - $tb_fetch['total_bookings'] == 0) {
                continue;
            }
        }

        // facilities of room with filters
        $fac_count = 0;

        $fac_q = mysqli_query($con, "SELECT f.name, f.id FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");

        $facilities_data = '';
        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            if (in_array($fac_row['id'], $facilities_list['facilities'])) {
                $fac_count++;
            }
            $facilities_data .= "<span class='rounded-pill me-1 mb-1 badge      text-bg-light text-wrap'>
                $fac_row[name]
            </span>";
        }

        if(count($facilities_list['facilities']) != $fac_count){
            continue;
        }



        // features querry 
        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");

        $features_data = '';
        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            $features_data .= "<span class='rounded-pill me-1 mb-1 badge text-bg-light text-wrap'>
                            $fea_row[name]
                        </span>";
        }





        // get thumbnail of room

        $room_thumb = ROOMS_IMG_PATH . 'thumbnail.jpg';
        $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`= '$room_data[id]' AND `thumb` = '1'");

        if (mysqli_num_rows($thumb_q) > 0) {
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
        }

        // front room card

        $book_btn = "";
        if (!$settings_r['shutdown']) {
            $login = 0;
            if (isset($_SESSION['login']) && ($_SESSION['login'] == true)) {
                $login = 1;
            }
            $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn w-100 btn-sm text-white custom-bg shadow-none mb-2'>Book Now</button>";
        }

        $output .= "
        <div class='card mb-4 border-0 shadow'>
            <div class='row g-0 p-3 align-items-center'>
                <div class='col-md-5 mb-lg-0 mb-md-0 mb-0'>
                    <img src='$room_thumb' class='img-fluid rounded' alt=''>
                </div>
                <div class='col-md-5  px-lg-3 px-md-3 px-0'>
                    <h5 class='card-title mb-3'>$room_data[name]</h5>
                    <div class='features mb-3'>
                        <h6 class='mb-1'>Features</h6>
                        $features_data
                    </div>
                    <div class='facilities mb-3'>
                        <h6 class='mb-1'>Facilities</h6>
                        $facilities_data
                    </div>
                    <div class='guests'>
                        <h6 class='mb-1'>Guests</h6>
                        <span class='badge text-bg-light text-wrap'>
                            $room_data[adult] Adults
                        </span>
                        <span class='badge text-bg-light text-wrap'>
                            $room_data[children] Childrens
                        </span>
                    </div>
                </div>
                <div class='col-md-2 mt-lg-0 mt-md-0 mt-4 text-center'>
                    <h6 class='mb-4'>₹$room_data[price] per night</h6>
                    $book_btn
                    <a href='room_details.php?id=$room_data[id]' class='btn w-100 btn-sm btn-outline-dark shadow-none'>More Details</a>
                </div>
            </div>
        </div>
        ";

        $count_rooms++;
    }

    if ($count_rooms > 0) {
        echo $output;
    } else {
        echo "<h3 class='text-center text-danger'>No Rooms to show</h3>";
    }
}

?>