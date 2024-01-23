<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>

    <title>
        <?php echo $settings_r['site_title'] ?> - BOOKING STATUS
    </title>


</head>

<body class="bg-light">

    <!-- header  -->
    <?php require('include/header.php'); ?>


    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">
                    PAYMENT STATUS
                </h2>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <?php
                $frm_data = filteration($_GET);
                if (!(isset($_SESSION['login']) && ($_SESSION['login'] == true))) {
                    redirect('index.php');
                }

                $booking_q = "SELECT * FROM `booking_order` bo
                    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                    WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status!=?";
                $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['u_id'], 'pending'], 'sis');

                if (mysqli_num_rows($booking_res) == 0) {
                    redirect('index.php');
                }
                $booking_fetch = mysqli_fetch_assoc($booking_res);

                if ($booking_fetch['trans_status'] == 'DONE') {
                    echo <<<Data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-success">
                                <i class="bi bi-check-circle-fill"></i>
                                Payment Done! Booking successful.
                                <br><br>
                                <a href="bookings.php">Go to Booking>></a>
                            </p>
                        </div>
                        Data;
                } else {
                    echo <<<Data
                        <div class="col-12 px-4">
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Payment Failed! $booking_fetch[trans_resp_msg]
                            </p>
                            <br><br>                                
                            <a href="bookings.php" class="text-dark" style="font-weight: 400;">Go to Booking>></a>
                        </div>
                        Data;
                }
                ?>
            </div>

        </div>
    </div>

    <!-- footer  -->
    <?php require('include/footer.php'); ?>

</body>

</html>