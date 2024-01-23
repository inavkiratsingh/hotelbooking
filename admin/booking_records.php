<?php
require("inc/essential.php");
require("inc/dbconfig.php");
admin_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - Booking Records</title>
    <?php require("inc/links.php"); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hiddeb">
                <h3 class="mb-4">BOOKING RECORDS</h3>

                <!-- FEATURES SECTION  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)"
                                class="form-control shadow-none w-25 ms-auto" id="search" placeholder="type to search">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Booking Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="records-data">
                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination mt-3" id="table_pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php require("inc/scripts.php"); ?>
    <script src="scripts/booking_records.js">
    </script>
</body>

</html>