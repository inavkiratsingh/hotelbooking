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
    <title>ADMIN PANEL - settings</title>
    <?php require("inc/links.php"); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hiddeb">
                <h3 class="mb-4">SETTINGS</h3>

                <!-- general settings  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal"
                                data-bs-target="#general">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                        </div>
                        <h6 class="card-subtitle fw-bold mb-1">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle fw-bold mb-1">About us</h6>
                        <p class="card-text" id="site_about"></p>

                    </div>
                </div>


                <!-- general modal settings -->

                <div class="modal fade" id="general" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_form">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="model-title">General Setting</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Site Title</label>
                                        <input type="text" name="site_title" id="site_title_inp"
                                            class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">About-Us</label>
                                        <textarea class="form-control shadow-none" name="site_about" id="site_about_inp"
                                            rows="6" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn text-secondary shadow-none"
                                            data-bs-dismiss="modal"
                                            onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about">CANCEL</button>
                                        <button type="submit"
                                            class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- shutdown section  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form action="">
                                    <input onchange="upd_shutdown(this.value)" type="checkbox" class="form-check-input"
                                        id="shutdown-toggle">
                                </form>
                            </div>

                        </div>
                        <p class="card-text">
                            No customers will be alowed to book hotel room when shutdown mode is turned on
                        </p>

                    </div>
                </div>

                <!-- contact details settings  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contact Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal"
                                data-bs-target="#Contact-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Google Map</h6>
                                    <p class="card-text" id="g-map"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Phone no.</h6>
                                    <p class="card-text mb-1" id="">
                                        <i class="bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text" id="">
                                        <i class="bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Email</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Social Links</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-facebook"></i>
                                        <span id="fb"></span>

                                    </p>
                                    <p class="card-text mb-1" id="">
                                        <i class="bi bi-instagram"></i>
                                        <span id="insta"></span>
                                    </p>
                                    <p class="card-text mb-1" id="">
                                        <i class="bi bi-twitter"></i>
                                        <span id="tw"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">I-Frame</h6>
                                    <iframe class="border p-2 w-100" id="iframe" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- contact modal settings -->

                <div class="modal fade" id="Contact-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="contact_form">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="model-title">Contact Setting</h5>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Address</label>
                                                <input type="text" name="address" id="address_inp"
                                                    class="form-control shadow-none" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Google Map</label>
                                                <input type="text" name="gmap" id="gmap_inp"
                                                    class="form-control shadow-none" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Phone Number(with country
                                                    code)</label>
                                                <div class="input-group mb-3">
                                                    <span class='input-group-text'><i
                                                            class="bi-telephone-fill"></i></span>
                                                    <input type="text" name="pn1" class="form-control shadow-none"
                                                        id="pn1_inp" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class='input-group-text'><i
                                                            class="bi-telephone-fill"></i></span>
                                                    <input type="text" name="pn2" class="form-control shadow-none"
                                                        id="pn2_inp" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Email</label>
                                                <input type="text" name="email" id="email_inp"
                                                    class="form-control shadow-none" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Social Links</label>
                                                <div class="input-group mb-3">
                                                    <span class='input-group-text'><i class="bi bi-facebook"></i></span>
                                                    <input type="text" name="fb" class="form-control shadow-none"
                                                        id="fb_inp" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class='input-group-text'><i class="bi-instagram"></i></span>
                                                    <input type="text" name="insta" class="form-control shadow-none"
                                                        id="insta_inp" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class='input-group-text'><i class="bi-twitter"></i></span>
                                                    <input type="text" name="tw" class="form-control shadow-none"
                                                        id="tw_inp">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Iframe</label>
                                                <input type="text" name="iframe" id="iframe_inp"
                                                    class="form-control shadow-none" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn text-secondary shadow-none"
                                            data-bs-dismiss="modal" onclick="contacts_inp(contact_data)">CANCEL</button>
                                        <button type="submit"
                                            class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <!-- management team settings  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team</h5>
                            <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal"
                                data-bs-target="#team-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="row" id="team-data">
                            <div class="col-md-2 mb-3">
                                <div class="card bg-dark text-white">
                                    <img class="card-img" src="../assets/images/about/IMG_17352.jpg">
                                    <div class="card-img-overlay text-end">
                                        <button class="btn btn-danger btn-sm shadow-none" type="button">
                                            <i class="bi bi-trash"></i>Delete
                                        </button>
                                    </div>
                                        <p class="card-text text-center px-3 px-2">Random Name</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- management team modal settings -->

                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team_s_form">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="model-title">Add team Member</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Name</label>
                                        <input type="text" name="member_name" id="member_name_inp"
                                            class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input type="file" name="member_pic" id="member_pic_inp"
                                            class="form-control shadow-none" accept=".jpg, .png, .jpeg" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="member_name.value='',member_pic.value=''" class="btn text-secondary shadow-none"
                                            data-bs-dismiss="modal">CANCEL</button>
                                        <button type="submit"
                                            class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require("inc/scripts.php"); ?>

    <script src = "scripts/setting.js"></script>
</body>

</html>