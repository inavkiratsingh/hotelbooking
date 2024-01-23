<?php

require("admin/inc/essential.php");
require("admin/inc/dbconfig.php");

require 'include/razorpay-php/Razorpay.php';
date_default_timezone_set("Asia/Kolkata");

session_start();
if (!(isset($_SESSION['login']) && ($_SESSION['login'] == true))) {
    redirect('rooms.php');
}

if (!isset($_POST['pay_now'])) {
    exit;
}
// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api("rzp_test_3G2uTZ548mOpgS", "cUjFrwmjzOXVg36gqAdBLvDa");

$CUSTOMER_ID = $_SESSION['u_id'];
$TXN_AMOUNT = $_SESSION['room']['payment'];

$orderData = [
    'receipt' => 3456,
    'amount' => $TXN_AMOUNT * 100, // 2000 rupees in paise
    'currency' => 'INR',
    'payment_capture' => 1, // auto capture
];

$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];


// insert payment into database
$frm_data = filteration($_POST);

$query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) VALUES (?,?,?,?,?)";

insert($query1, [$CUSTOMER_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $razorpayOrderId], 'issss');

$booking_id = mysqli_insert_id($con);

$query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phone`, `address`) VALUES (?,?,?,?,?,?,?)";

insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['phone'], $frm_data['address']], 'issssss');




// data



$displayAmount = $amount = $orderData['amount'];
$displayCurrency = 'INR';
if ($displayCurrency !== 'INR') {
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$data = [
    "key" => "rzp_test_3G2uTZ548mOpgS",
    "amount" => $amount,
    "name" => $_SESSION['u_name'],
    "description" => "nav",
    "prefill" => [
        "name" => $_SESSION['u_name'],
        "email" => $_SESSION['u_email'],
        "contact" => $_SESSION['u_phone'],
    ],
    "notes" => [
        "address" => "Hello World",
        "merchant_order_id" => "12312321",
    ],
    "theme" => [
        "color" => "#2ec1ac",
    ],
    "order_id" => $razorpayOrderId,
];

if ($displayCurrency !== 'INR') {
    $data['display_currency'] = $displayCurrency;
    $data['display_amount'] = $displayAmount;
}
$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$_SESSION['price']= $TXN_AMOUNT;
$json = json_encode($data);
?>




<form action="pay_response.php" method="POST">
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $data['key'] ?>"
        data-amount="<?php echo $data['amount'] ?>" data-currency="INR" data-name="<?php echo $data['name'] ?>"
        data-description="<?php echo $data['description'] ?>" data-prefill.name="<?php echo $data['prefill']['name'] ?>"
        data-prefill.email="<?php echo $data['prefill']['email'] ?>"
        data-prefill.contact="<?php echo $data['prefill']['contact'] ?>" data-notes.shopping_order_id="3456"
        data-order_id="<?php echo $data['order_id'] ?>" <?php if ($displayCurrency !== 'INR') { ?>
            data-display_amount="<?php echo $data['display_amount'] ?>" <?php } ?> <?php if ($displayCurrency !== 'INR') { ?>
            data-display_currency="<?php echo $data['display_currency'] ?>" <?php } ?>>
        </script>
    <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
    <input type="hidden" name="shopping_order_id" value="3456">
    
</form>

<script>
    $(window).on('load', function () {
        jQuery('.razorpay-payment-button').click();
    });
</script>