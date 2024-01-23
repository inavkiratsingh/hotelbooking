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
    <title>ADMIN PANEL - Carousals</title>
    <?php require("inc/links.php"); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hiddeb">
                <h3 class="mb-4">CAROUSALS</h3>

                <!-- CAROUSALS SECTION  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Carousals</h5>
                            <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal"
                                data-bs-target="#carousal-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="row" id="carousal-data">
                            
                        </div>
                    </div>
                </div>


                <!-- CAROUSAL MODAL -->

                <div class="modal fade" id="carousal-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="carousal_s_form">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="model-title">Add Image</h5>
                                </div>
                                <div class="modal-body">                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Picture</label>
                                        <input type="file" name="carousal_picture" id="carousal_picture_inp"
                                            class="form-control shadow-none" accept=".jpg, .png, .jpeg" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="carousal_picture.value=''" class="btn text-secondary shadow-none"
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

    <script src = "scripts/carousal.js"></script>
</body>

</html>