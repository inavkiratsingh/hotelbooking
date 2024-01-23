<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>
        <?php echo $settings_r['site_title'] ?> - HOME
    </title>

    <style>
        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width:585px) {
            .availability-form {
                margin-top: 25px;
                padding: 0 10px;
            }
        }
    </style>

</head>

<body class="bg-light">

    <!-- header  -->

    <?php require('include/header.php'); ?>

    <!-- Swiper -->

    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper wiper-caru">
            <div class="swiper-wrapper">
                <?php
                $res = selectAll('carousel');

                while ($row = mysqli_fetch_assoc($res)) {
                    $path = CAROUSAL_IMG_PATH;
                    echo <<<data
                    <div class="swiper-slide">
                        <img src="$path$row[image]" class="w-100 d-block" />
                    </div>
                    data;
                }
                ?>
            </div>
        </div>
    </div>


    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Hotel Availability</h5>
                <form action="rooms.php">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label for="" class="form-label" style="font-weight:500;">Check-in</label>
                            <input type="date" class="form-control shadow-none" name="checkin" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="" class="form-label" style="font-weight:500;">Check-out</label>
                            <input type="date" class="form-control shadow-none" name="checkout" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="" class="form-label" style="font-weight:500;">Adults</label>
                            <select name="adults" id="" class="form-control shadow-none">

                                <?php
                                $guest_query = mysqli_query(
                                    $con,
                                    "SELECT MAX(adult) AS max_adult,
                                MAX(children) AS max_child FROM `rooms`
                                WHERE `status` = 1 AND `removed` = 0"
                                );
                                $guest_res = mysqli_fetch_assoc($guest_query);
                                for ($i = 1; $i <= $guest_res['max_adult']; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label for="" class="form-label" style="font-weight:500;" name="children">Children</label>
                            <select name="children" id="" class="form-control shadow-none">
                                <?php
                                for ($i = 1; $i <= $guest_res['max_child']; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="check_availability">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- our Rooms -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>

    <div class="container">
        <div class="row">

            <?php
            $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? AND `removed`=? order by `id` desc limit 3 ", [1, 0], 'ii');
            while ($room_data = mysqli_fetch_assoc($room_res)) {
                // features querry 
                $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");

                $features_data = '';
                while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                    $features_data .= "<span class='rounded-pill me-1 mb-1 badge text-bg-light text-wrap'>
                            $fea_row[name]
                        </span>";
                }

                // facilities of room
            
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");

                $facilities_data = '';
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='rounded-pill me-1 mb-1 badge text-bg-light text-wrap'>
                            $fac_row[name]
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
                    $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
                }

                $ratting_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
                WHERE `room_id`=$room_data[id] ORDER BY `sr_no` DESC LIMIT 20";

                $rating_res = mysqli_query($con, $ratting_q);

                $rating_fetch = mysqli_fetch_assoc($rating_res);

                $rating_data = "";

                if ($rating_fetch['avg_rating'] != Null) {
                    for ($i = 0; $i < $rating_fetch['avg_rating']; $i++) {
                        $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                    }
                }

                echo <<<data

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350rem; margin: auto;">
                            <img class="card-img-top" src="$room_thumb" alt="Card image cap">
                            <div class="card-body">
                                <h5>$room_data[name]</h5>
                                <h6 class="mb-4">₹$room_data[price] per night</h6>
                                <div class="features mb-4">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>
                                <div class="facilities mb-4">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                                <div class="guests mb-4">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge text-bg-light text-wrap">
                                    $room_data[adult] Adults
                                    </span>
                                    <span class="badge text-bg-light text-wrap">
                                    $room_data[children] Childrens
                                    </span>
                                </div>
                                <div class='rating mb-4'>
                                    <h6 class='mb-1'>
                                        Rating
                                    </h6>
                                    <span class='badge rounded-pill bg-light'>
                                    $rating_data
                                    </span>
                                </div>
                                <div class="d-flex justify-content-evenly mb-4">
                                    $book_btn
                                    <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    data;
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
            </div>
        </div>

    </div>


    <!-- our Facilities -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>

    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
            $res = mysqli_query($con, "select * from `facilities` order by `id` desc limit 5");
            $path = FACILITIES_IMG_PATH;

            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
                    <div class="col-lg-2 col-md-2 text-center bg-white shadow rounded py-4 my-3">
                        <img src="$path$row[icon]" alt="" width="60px">
                        <h5 class="mt-3">$row[name]</h5>
                    </div>
                    data;
            }
            ?>

        </div>

        <div class="col-lg-12 text-center mt-5">
            <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities
                >>></a>
        </div>
    </div>

    <!-- our Testimonial -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TESTIMONIALS</h2>

    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">

                <?php
                $review_q = "SELECT rr.*, uc.name AS uname,uc.profile, r.name AS rname
                FROM `rating_review`  rr
                INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                INNER JOIN `rooms` r ON rr.room_id=r.id
                ORDER BY `sr_no` DESC LIMIT 6";

                $review_res = mysqli_query($con, $review_q);
                $img_path = USERS_IMG_PATH;

                if (mysqli_num_rows($review_res) == 0) {
                    echo "No reviews yet !";
                } else {
                    while ($row = mysqli_fetch_assoc($review_res)) {
                        $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                        for ($i = 1; $i < $row['rating']; $i++) {
                            $stars .= " <i class='bi bi-star-fill text-warning'></i>";
                        }

                        echo <<<slides
                        <div class="swiper-slide bg-white p-4">

                            <div class="profile d-flex align-items-centre mb-3">
                                <img src="$img_path$row[profile]" class="rounded-circle" loading="lazy" alt="" width="30px">
                                <h6 class="m-0 ms-2">$row[uname]</h6>
                            </div>
                            <p>
                                $row[review]
                            </p>
                            <div class="rating">
                                $stars
                            </div>

                        </div>
                        slides;
                    }
                }
                ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know more >>></a>
        </div>
    </div>

    <!-- reach us -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-3 mb-lg-0 bg-white rounded">
                <iframe class="w-100" height="320" loading="lazy" src="<?php echo $contact_r['iframe'] ?>"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>"
                        class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +
                        <?php echo $contact_r['pn1'] ?>
                    </a><br>
                    <?php
                    if ($contact_r['pn2'] != '') {
                        echo <<<data
                            <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                            </a>
                           data;
                    }

                    ?>

                </div>

                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow us</h5>
                    <?php
                    if ($contact_r['tw'] != '') {
                        echo <<<data
                        <a href="$contact_r[tw]" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <span class="badge bg-light text-dark fs-6 p-2">
                                <i class="bi bi-twitter me-1"></i> Twitter
                            </span>
                        </a>
                        data;
                    }
                    ?>

                    <br>
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i> Facebook
                        </span>
                    </a>
                    <br>

                    <a href="<?php echo $contact_r['insta'] ?>"
                        class="d-inline-block mb-2 text-decoration-none text-dark">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i> Instagram
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- password reset model  -->

    <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="recovery_form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel d-flex align-items-centre">
                            <i class="bi bi-shield-lock fs-3 me-2"></i>Set-up New Password
                        </h1>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="pass" required class="form-control shadow-none">
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>
                        <div class="mb-2 text-end">

                            <button type="button" class="btn shadow-none me-2" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="submit" class="btn btn-dark shadow-none">RESET PASSWORD</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- footer  -->

    <?php require('include/footer.php'); ?>


    <?php

    if (isset($_GET['account_recovery'])) {
        $data = filteration($_GET);
        // echo "<script>console.log('$data[email]')</script>";
        $t_date = date('Y-m-d');
        // echo "<script>console.log('$t_date')</script>";
        $query = select(
            "SELECT * from `user_cred` where `email`=? AND `token`=? AND `t_expire`=? LIMIT 1",
            [$data['email'], $data['token'], $t_date],
            'sss'
        );

        if (mysqli_num_rows($query) == 1) {
            echo <<<showModal
            <script>
                var myModal = document.getElementById('recoveryModal');

                myModal.querySelector("input[name = 'email']").value = '$data[email]';
                myModal.querySelector("input[name = 'token']").value = '$data[token]';

                var modal = bootstrap.Modal.getOrCreateInstance(myModal);
                modal.show();
            </script>
            showModal;
        } else {
            alert('error', 'Invalid or Expire link!');
        }
    }

    ?>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".wiper-caru", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            }
        });
        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: "1"
                },
                640: {
                    slidesPerView: "1"
                },
                768: {
                    slidesPerView: "2"
                },
                1024: {
                    slidesPerView: "3"
                },
            }
        });


        // recovery password

        let recovery_form = document.getElementById('recovery_form');
        recovery_form.addEventListener('submit', (e) => {
            e.preventDefault();

            let data = new FormData();
            data.append('email', recovery_form.elements['email'].value);
            data.append('token', recovery_form.elements['token'].value);
            data.append('pass', recovery_form.elements['pass'].value);
            data.append('recovery_pass', '');

            var myModal = document.getElementById('recoveryModal');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

            xhr.onload = function () {
                if (this.responseText == 'failed') {
                    alert('error', 'Account reset failed! Server down');
                } else {
                    alert('success', 'Account reset seccessfull');
                    recovery_form.reset();
                }
                console.log(this.responseText);
            }
            xhr.send(data);
        })
    </script>
</body>

</html>