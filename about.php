<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title><?php echo $settings_r['site_title'] ?> - FACILITIES</title>

    <style>
        .box:hover {
            border-top-color: var(--maincolor) !important;
        }
    </style>

</head>

<body class="bg-light">

    <!-- header  -->
    <?php require('include/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>

        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste ipsum <br>
            dolores temporibus voluptate vero sapiente praesentium asperiores modi.
        </p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde
                    praesentium reprehenderit, quisquam mollitia nam veritatis.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde
                    praesentium reprehenderit, quisquam mollitia nam veritatis.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-1">
                <img src="assets/images/about/about.jpg" class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="assets/images/about/hotel.svg" width="70px" alt="">
                    <h4 class="mt-3">100+ ROOMS</h4>
                </div>

            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="assets/images/about/customers.svg" width="70px" alt="">
                    <h4 class="mt-3">200+ CUSTOMERS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="assets/images/about/staff.svg" width="70px" alt="">
                    <h4 class="mt-3">200+ staffs</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="assets/images/about/rating.svg" width="70px" alt="">
                    <h4 class="mt-3">150+ ROOMS</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold text-center h-font">MANAGEMENT TEAM</h3>


    <div class="container px-4">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php
                $path = ABOUT_IMG_PATH;
                $about_r = selectAll('team_details');
                while ($row = mysqli_fetch_assoc($about_r)) {
                    echo <<<data
                    <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                        <img src="$path$row[picture]" class="w-100">
                        <h5 class="mt-2">$row[name]</h5>
                    </div>
                    data;
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

    <!-- footer  -->
    <?php require('include/footer.php'); ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidePerView: 4,
            spaceBetween: 40,
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
                    slidesPerView: "3"
                },
                1024: {
                    slidesPerView: "3"
                },
            }
        });
    </script>

</body>

</html>