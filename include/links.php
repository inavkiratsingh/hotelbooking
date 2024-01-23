<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Merienda:wght@400;700&family=Poppins:wght@400;500;700&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="assets/css/common.css">

<?php

date_default_timezone_set("Asia/Kolkata");

session_start();

require("admin/inc/dbconfig.php");
require("admin/inc/essential.php");

$contact_q = "SELECT * FROM `contact_details` WHERE srno = ?";
$settings_q = "SELECT * FROM `settings` WHERE srno = ?";
$value = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $value, 'i'));
$settings_r = mysqli_fetch_assoc(select($settings_q, $value, 'i'));

if($settings_r['shutdown']){
    echo<<<alertbar
    <div class="bg-danger text-center p-2 fw-bold">
    <i class="bi bi-exclamation-triangle-fill"></i>
    Bookings are temporarily close !
    </div>
    alertbar;
}

?>