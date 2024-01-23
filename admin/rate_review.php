<?php
require("inc/essential.php");
require("inc/dbconfig.php");
admin_login();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `rating_review` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'All Marked as read!');
        } else {
            alert('error', 'Operation failed!');
        }
    } else {
        $q = "UPDATE `rating_review` SET `seen`=? WHERE sr_no = ?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `rating_review`";
        if (mysqli_query($con, $q)) {
            alert('success', 'All Data Deleted!');
        } else {
            alert('error', 'Operation failed!');
        }
    } else {
        $q = "DELETE FROM `rating_review` WHERE sr_no = ?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data Deleted!');
        } else {
            alert('error', 'Operation failed!');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL - Ratings and Review</title>
    <?php require("inc/links.php"); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hiddeb">
                <h3 class="mb-4">RATINGS & REVIEWS</h3>

                <!-- CAROUSALS SECTION  -->

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill btn-sm shadow-none">
                                <i class="bi bi-check-all"></i> Mark all as read
                            </a>
                            <a href="?del=all" class="btn btn-danger rounded-pill btn-sm shadow-none">
                                <i class="bi bi-trash"></i> Delete All
                            </a>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-hover border bg-dark">
                                <thead class="">
                                    <tr class="bg-dark">
                                        <th>#</th>
                                        <th>Room Name</th>
                                        <th>User Name</th>
                                        <th>Rating</th>
                                        <th width="30%">Review</th>
                                        <th>Date</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = "SELECT rr.*, uc.name AS uname, r.name AS rname
                                        FROM `rating_review`  rr
                                        INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                                        INNER JOIN `rooms` r ON rr.room_id=r.id
                                        ORDER BY `sr_no` DESC";

                                    $data = mysqli_query($con, $q);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $date = date('d-m-Y', strtotime($row['datentime']));

                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[sr_no]' class = 'btn btn-sm rounded-pill btn-primary'>Mark as read</a>";
                                        }
                                        $seen .= "<a href='?del=$row[sr_no]' class = 'btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                                        echo <<<q
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[rname]</td>
                                                <td>$row[uname]</td>
                                                <td>$row[rating]</td>
                                                <td>$row[review]</td>
                                                <td>$date</td>
                                                <td>$seen</td>
                                            </tr>  
                                            q;
                                        $i++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require("inc/scripts.php"); ?>
</body>

</html>