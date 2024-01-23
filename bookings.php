<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>

    <title>
        <?php echo $settings_r['site_title'] ?> - CONFIRM BOOKING
    </title>


</head>

<body class="bg-light">

    <!-- header  -->
    <?php
    require('include/header.php');
    if (!(isset($_SESSION['login']) && ($_SESSION['login'] == true))) {
        redirect('rooms.php');
    }
    ?>

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">
                    BOOKINGS
                </h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
                </div>
            </div>


            <?php
            $query = "SELECT bo.*, bd.* 
                FROM booking_order bo
                INNER JOIN booking_details bd ON bo.booking_id = bd.booking_id
                WHERE ((bo.booking_status = 'booked')
                OR (bo.booking_status = 'cancelled')
                OR (bo.booking_status = 'payment_failed'))
                AND (bo.user_id=?)
                ORDER BY bo.booking_id DESC";

            $result = select($query, [$_SESSION['u_id']], 'i');

            while ($data = mysqli_fetch_assoc($result)) {
                $date = date("d-m-Y", strtotime($data['datentime']));
                $checkin = date("d-m-Y", strtotime($data['check_in']));
                $checkout = date("d-m-Y", strtotime($data['check_out']));

                $status_bg = "";
                $btn = "";

                if ($data['booking_status'] == 'booked') {
                    $status_bg = "bg-success";

                    if ($data['arrival'] == 1) {
                        $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark shadown-none btn-sm'>
                            Download PDF
                            </a>
                            ";
                        if ($data['rate_review'] == 0) {
                            $btn .= "<button type='button' class='btn btn-dark shadown-none btn-sm' onclick='review_room($data[booking_id],$data[room_id])' data-bs-toggle='modal' data-bs-target='#reviewModal'>
                                Rate & Review
                                </button>
                                ";
                        }
                    } else {
                        $btn = "
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger shadown-none btn-sm'>
                    Cancel
                    </button>
                    ";
                    }
                } else if ($data['booking_status'] == 'cancelled') {
                    $status_bg = "bg-danger";

                    if ($data['refund'] == 0) {
                        $btn = "<span class='badge bg-primary'>Refund in Progress</span>";
                    } else {
                        $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark hadown-none btn-sm'>
                    Download PDF
                    </a>
                    ";
                    }
                } else {
                    $status_bg = "bg-warning";
                    $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark hadown-none btn-sm'>
                Download PDF
                </a>
                ";
                }

                echo <<<bookings
                <div class="col-md-4 px-4 mb-4">
                    <div class="bg-white shadown-sm p-3 rounded">
                        <h5 class="fw-bold">$data[room_name]</h5>
                        <p>₹$data[price] per night</p>
                        <p>
                            <b>Check in:</b> $checkin<br>
                            <b>Check out:</b> $checkout
                        </p>
                        <p>
                            <b>Amount:</b> $data[trans_amt]<br>
                            <b>Order Id:</b> $data[order_id]<br>
                            <b>Date:</b> $date
                        </p>
                        <p>
                            <span class="badge $status_bg">$data[booking_status]</span>
                        </p>
                        $btn
                    </div>
                </div>
                bookings;
            }
            ?>

        </div>
    </div>

    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="review_form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel d-flex align-items-centre">
                            <i class="bi bi-chat-square-heart-fill fs-3 me-2"></i> Rate & Review
                        </h1>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select shadow-none" name="rating">
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Ok</option>
                                <option value="2">Poor</option>
                                <option value="1">Bad</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Review</label>
                            <textarea name="review" class="form-control textarea" required rows="3"></textarea>
                        </div>
                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="room_id">
                        <div class="text-end">
                            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    if (isset($_GET['cancel_status'])) {
        alert('success', 'Booking Cancelled');
    } else if (isset($_GET['review_status'])) {
        alert('success', 'Thankyou for Rating & Review');
    }
    ?>

    <!-- footer  -->
    <?php require('include/footer.php'); ?>


    <script>

        function cancel_booking(id) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/cancel_booking.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                console.log(this.responseText);
                if (this.responseText == 1) {
                    window.location.href = 'bookings.php?cancel_status=true';
                } else {
                    alert('error', 'Cancellation failed!');
                }
            }

            xhr.send('cancel_booking&id=' + id);
        }

        let review_form = document.getElementById('review_form');
        function review_room(bid, rid) {
            review_form.elements['booking_id'].value = bid;
            review_form.elements['room_id'].value = rid;
        }

        review_form.addEventListener('submit', function (e) {
            e.preventDefault();

            let data = new FormData();
            data.append('review_form', '');
            data.append('rating', review_form.elements['rating'].value);
            data.append('review', review_form.elements['review'].value);
            data.append('booking_id', review_form.elements['booking_id'].value);
            data.append('room_id', review_form.elements['room_id'].value);


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/review_room.php", true);

            xhr.onload = function () {
                if (this.responseText == 1) {
                    window.location.href = 'bookings.php?review_status=true';
                } else {
                    var myModal = document.getElementById('reviewModal');
                    var modal = bootstrap.Modal.getInstance(myModal);
                    modal.hide();

                    alert('error', 'Rating & Review failed !')
                }
            }
            xhr.send(data);
        })

    </script>
</body>

</html>