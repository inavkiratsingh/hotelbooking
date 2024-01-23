<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php'); ?>

    <title>
        <?php echo $settings_r['site_title'] ?> - rooms
    </title>


</head>

<body class="bg-light">

    <!-- header  -->
    <?php require('include/header.php'); ?>

    <?php
    $checkin_default = "";
    $checkout_default = "";
    $adults = "";
    $children = "";

    if (isset($_GET['check_availability'])) {
        $frm_data = filteration($_GET);
        $checkin_default = $frm_data['checkin'];
        $checkout_default = $frm_data['checkout'];
        $adults = $frm_data['adults'];
        $children = $frm_data['children'];
    }
    ?>


    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">
                            <span>FILTERS</span>
                            <button id="reset_all_btn" class="shadow-none btn btn-sm text-secondary d-none"
                                onclick="chk_avail_clear()">RESET</button>
                        </h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterdropdown" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- CHECK IN OUT  -->
                        <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="filterdropdown">
                            <div class="border bg-light p-3 rounded mb-3 ">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between"
                                    style="font-size: 18px;">
                                    <span>CHECK AVAILABILITY</span>
                                    <button id="checkavail" class="shadow-none btn btn-sm text-secondary d-none"
                                        onclick="chk_avail_clear()">RESET</button>
                                </h5>
                                <label for="" class="form-label">Check-in</label>
                                <input type="date" value="<?php echo $checkin_default ?>" class="form-control shadow-none mb-3" id="checkin"
                                    onchange="chk_avail()">
                                <label for="" class="form-label">Check-out</label>
                                <input type="date" value="<?php echo $checkout_default ?>" class="form-control shadow-none" id="checkout"
                                    onchange="chk_avail()">
                            </div>


                            <!-- FACILITIES  -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between"
                                    style="font-size: 18px;">
                                    <span>GUESTS</span>
                                    <button id="facilities_btn" class="shadow-none btn btn-sm text-secondary d-none"
                                        onclick="facilities_clear()">RESET</button>
                                </h5>

                                <?php
                                $facilities_q = selectAll('facilities');
                                while ($row = mysqli_fetch_assoc($facilities_q)) {
                                    echo <<<fac
                                        <DIV class="mb-2">
                                            <input type="checkbox" onclick="fetch_room()" name="facilities" value="$row[id]" id="$row[id]" class="form-check-input shadow-none md-1">
                                            <label for="$row[id]" class="form-check-label">$row[name]</label>
                                        </DIV>
                                        fac;
                                }
                                ?>
                            </div>


                            <!-- GUESTS  -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between"
                                    style="font-size: 18px;">
                                    <span>GUESTS</span>
                                    <button id="guest_btn" class="shadow-none btn btn-sm text-secondary d-none"
                                        onclick="guest_clear()">RESET</button>
                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label for="" class="form-label">Adult</label>
                                        <input type="number" class="shadow-none form-control" min="1" value="<?php echo $adults ?>"
                                            oninput="guets_filter()" id="adults">
                                    </div>
                                    <div>
                                        <label for="" class="form-label">Children</label>
                                        <input type="number" class="shadow-none form-control" min="1" id="children" value="<?php echo $children ?>"
                                            oninput="guets_filter()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4" id="room_data">

            </div>
        </div>
    </div>

    <script>
        let room_data = document.getElementById('room_data');
        let checkin = document.getElementById('checkin');
        let checkout = document.getElementById('checkout');
        let checkavail = document.getElementById('checkavail');
        let adults = document.getElementById('adults');
        let children = document.getElementById('children');
        let guest_btn = document.getElementById('guest_btn');
        let facilities_btn = document.getElementById('facilities_btn');
        let reset_all_btn = document.getElementById('reset_all_btn');


        function fetch_room() {
            let chk_avail = JSON.stringify({
                checkin: checkin.value,
                checkout: checkout.value
            });

            let guests = JSON.stringify({
                adults: adults.value,
                children: children.value
            });

            let facilities_list = [];

            let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
            if (get_facilities.length > 0) {
                get_facilities.forEach((facility) => {
                    facilities_list.push(facility.value);
                })
                facilities_btn.classList.remove('d-none');
            } else {
                facilities_btn.classList.add('d-none');
            }
            facilities_list = JSON.stringify({ "facilities": facilities_list });

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php?fetch_room&chk_avail=" + chk_avail + "&guests=" + guests + "&facilities_list=" + facilities_list, true);

            xhr.onprogress = function () {
                room_data.innerHTML = `
                <div class="spinner-border text-info mb-3 mx-auto d-block" id="info_loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`;
            }

            xhr.onload = function () {
                room_data.innerHTML = this.responseText;
            }
            xhr.send();
        }

        function chk_avail() {
            if (checkin.value != '' && checkout.value != '') {
                fetch_room();
                checkavail.classList.remove('d-none');
            }
        }

        function chk_avail_clear() {
            checkin.value = '';
            checkout.value = '';
            checkavail.classList.add('d-none');
            fetch_room();
        }

        function guets_filter() {
            if (adults.value > 0 || children.value > 0) {
                fetch_room();
                guest_btn.classList.remove('d-none');
            }
        }

        function guest_clear() {
            adults.value = '';
            children.value = '';
            guest_btn.classList.add('d-none');
            fetch_room();
        }

        function facilities_clear() {
            let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
            get_facilities.forEach((facility) => {
                facility.checked = false;
            })
            facilities_btn.classList.add('d-none');
            fetch_room();
        }

        let get_facilities = document.querySelectorAll('[name="facilities"]:checked');

        if ((checkin.value != '' && checkout.value != '') || (adults.value > 0 || children.value > 0) || (get_facilities.length > 0)) {
            reset_all_btn.classList.remove('d-none');
        }

        fetch_room();
    </script>

    <!-- footer  -->
    <?php require('include/footer.php'); ?>

</body>

</html>