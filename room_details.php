<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>

    <title>
        <?php echo $settings_r['site_title'] ?> - ROOM DETIALS
    </title>


</head>

<body class="bg-light">

    <!-- header  -->
    <?php require('include/header.php'); ?>

    <?php
    if (!isset($_GET['id'])) {
        redirect('rooms.php');
    }

    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `id` = ? AND `status` = ? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    ?>







    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">
                    <?php echo $room_data['name'] ?>
                </h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // get thumbnail of room
                        
                        $room_img = ROOMS_IMG_PATH . 'thumbnail.jpg';
                        $img_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`= $room_data[id]");

                        if (mysqli_num_rows($img_q) > 0) {
                            $active_class = 'active';
                            while ($img_res = mysqli_fetch_assoc($img_q)) {
                                echo "
                                <div class='carousel-item $active_class'>
                                    <img class='d-block w-100 rounded' src='" . ROOMS_IMG_PATH . $img_res['image'] . "'>
                                </div>
                                ";
                                $active_class = '';
                            }


                        } else {
                            echo <<<data
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="$room_img" alt="First slide">
                            </div>
                            data;
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#roomCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only"></span>
                    </a>
                    <a class="carousel-control-next" href="#roomCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only"></span>
                    </a>
                </div>

            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo <<<price
                        <h4 class="">₹$room_data[price] per night</h4>
                        price;

                        $ratting_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
                WHERE `room_id`=$room_data[id] ORDER BY `sr_no` DESC LIMIT 20";

                        $rating_res = mysqli_query($con, $ratting_q);

                        $rating_fetch = mysqli_fetch_assoc($rating_res);

                        $rating_data = "";

                        if ($rating_fetch['avg_rating'] != 0) {
                            for ($i = 0; $i < $rating_fetch['avg_rating']; $i++) {
                                $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                            }
                        }

                        echo <<<rating
                            <div class="mb-3">
                                $rating_data
                            </div>
                        rating;

                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");

                        $features_data = '';
                        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                            $features_data .= "<span class='rounded-pill badge text-bg-light text-wrap me-1 mb-1'>
                            $fea_row[name]
                        </span>";
                        }

                        echo <<<fea
                        <div class="features mb-3">
                            <h6 class="mb-1">Features</h6>
                             $features_data
                        </div>
                        fea;

                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");

                        $facilities_data = '';
                        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                            $facilities_data .= "<span class='rounded-pill me-1 mb-1 badge text-bg-light text-wrap'>
                                    $fac_row[name]
                                </span>";
                        }

                        echo <<<fac
                        <div class="features mb-3">
                            <h6 class="mb-1">Facilities</h6>
                             $facilities_data
                        </div>
                        fac;

                        echo <<<guest
                        <div class="mb-3">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge text-bg-light text-wrap">
                                $room_data[adult] Adults
                            </span>
                            <span class="badge text-bg-light text-wrap">
                                $room_data[children] Childrens
                            </span>
                        </div>
                        guest;

                        echo <<<area
                        <div class="mb-3">
                            <h6 class="mb-1">Area</h6>
                            <span class='rounded-pill badge text-bg-light text-wrap me-1 mb-1'>
                            $room_data[area] sq. ft.
                        </span>
                        </div>
                        area;

                        if (!$settings_r['shutdown']) {
                            $login = 0;
                            if (isset($_SESSION['login']) && ($_SESSION['login'] == true)) {
                                $login = 1;
                            }
                            echo <<<btn
                            <button onclick='checkLoginToBook($login,$room_data[id])' class="btn w-100 text-white custom-bg shadow-none mb-1">Book Now</button>
                            btn;
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-4 px-4">
                <div class="mb-4">
                    <h5>Description</h5>
                    <p>
                        <?php
                        echo $room_data['description'];
                        ?>
                    </p>
                </div>
                <div class="review-rating">
                    <h5 class="mb-3">Revies & Ratings</h5>

                    <?php
                    $review_q = "SELECT rr.*, uc.name AS uname,uc.profile, r.name AS rname
                        FROM `rating_review`  rr
                        INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                        INNER JOIN `rooms` r ON rr.room_id=r.id
                        WHERE rr.room_id = $room_data[id]
                        ORDER BY `sr_no` DESC LIMIT 15";

                    $review_res = mysqli_query($con, $review_q);
                    $img_path = USERS_IMG_PATH;

                    if (mysqli_num_rows($review_res) == 0) {
                        echo "No reviews yet !";
                    } else {
                        while ($row = mysqli_fetch_assoc($review_res)) {
                            $stars = "";
                            for ($i = 0; $i < $row['rating']; $i++) {
                                $stars .= "<i class='bi bi-star-fill text-warning'></i> ";
                            }

                            echo <<<rating
                            <div class="mb-4">
                                <div class="d-flex align-items-centre mb-2">
                                    <img src="$img_path$row[profile]" class="rounded-circle" alt="" width="30px">
                                    <h6 class="m-0 ms-2">$row[uname]</h6>
                                </div>
                                <p>
                                    $row[review]
                                </p>
                                <div class="rating">
                                    $stars
                                </div>
                            </div>
                            rating;
                        }
                    }
                    ?>

                </div>
            </div>

            <div class="col-lg-9 col-md-12 px-4">
                <?php

                //     echo<<<data
                //     <div class="card mb-4 border-0 shadow">
                //         <div class="row g-0 p-3 align-items-center">
                //             <div class="col-md-5 mb-lg-0 mb-md-0 mb-0">
                //                 <img src="$room_thumb" class="img-fluid rounded" alt="">
                //             </div>
                //             <div class="col-md-5  px-lg-3 px-md-3 px-0">
                //                 <h5 class="card-title mb-3">$room_data[name]</h5>
                //                 <div class="features mb-3">
                //                     <h6 class="mb-1">Features</h6>
                //                     $features_data
                //                 </div>
                //                 <div class="facilities mb-3">
                //                     <h6 class="mb-1">Facilities</h6>
                //                     $facilities_data
                //                 </div>
                //                 <div class="guests">
                //                     <h6 class="mb-1">Guests</h6>
                //                     <span class="badge text-bg-light text-wrap">
                //                         $room_data[adult] Adults
                //                     </span>
                //                     <span class="badge text-bg-light text-wrap">
                //                         $room_data[children] Childrens
                //                     </span>
                //                 </div>
                //             </div>
                //             <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                //                 <h6 class="mb-4">₹$room_data[price] per night</h6>
                //                 <a href="#" class="btn w-100 btn-sm text-white custom-bg shadow-none mb-2">Book Now</a>
                //                 <a href="room_details.php?id=$room_data[id]" class="btn w-100 btn-sm btn-outline-dark shadow-none">More Details</a>
                //             </div>
                //         </div>
                //     </div>
                //     data;
                // }
                ?>

            </div>
        </div>
    </div>

    <!-- footer  -->
    <?php require('include/footer.php'); ?>

</body>

</html>