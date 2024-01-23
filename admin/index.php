<?php
require("inc/essential.php");
require("inc/dbconfig.php");

session_start();
    if((isset($_SESSION["admin_login"]) && $_SESSION["admin_login"]==true)){
        redirect("dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- links  -->
    <?php require("inc/links.php") ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>

    <style>
        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="login-form rounded overflow-hidden bg-white shadow text-center">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <DIV class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center"
                        placeholder="Admin name">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" required type="password" class="form-control shadow-none text-center"
                        placeholder="Password">
                </div>
                <button name="login" type="submit" class="btn text-white custom-bg">LOGIN</button>
            </DIV>
        </form>
    </div>

    <?php
    if (isset($_POST["login"])) {
        $frm_data = filteration($_POST);

        $query = "SELECT * FROM `admin` where `admin_name`=? AND `admin_pass`=?";
        $values = [$frm_data['admin_name'], $frm_data['admin_pass']];

        $res = select($query, $values, "ss");

        if ($res->num_rows == 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['admin_login'] = true;
            $_SESSION['adminID'] = $row['srno'];
            redirect('dashboard.php');
        } else {
            alert('error','Login failed- Invalid credentials.');
        }
    }
    ?>



    <?php require("inc/scripts.php"); ?>
</body>

</html>