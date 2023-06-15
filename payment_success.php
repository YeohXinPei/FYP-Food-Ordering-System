<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-mPzjCx7d4q29AzG34J1rr43xPrUueH2WUJMO3p5QHsNupSdAMRHbbTZazs6rkm40" crossorigin="anonymous">
    </script>


    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>

    <?php
include 'header.php';
error_reporting(0);
session_start();
$tableNumber = $_SESSION["table_number"];
?>

    <div class="container-fluid">
        <section class="login-section">


            <?php
// Set up PayPal API credentials
$client_id = 'ARu68cSyRE5IP7Bl8908D91_fnuH_ppGwWtUU9vvi2MF1QAw0UfzRMuffXHlV0QEsSuIknkg1qhsNIOZ';
$client_secret = 'EDplrFyV_2HqxG8E-vexSjOJ1ygxtqKCSK-UmFsfwIeIUBqooCzHaE3ntth5m5KWiIXubPLdabyhmi__';

if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    // Execute the PayPal payment
    $api_url = "https://api.sandbox.paypal.com/v1/payments/payment/$paymentId/execute"; // Use the live API URL for production
    $data = [
        'payer_id' => $payerId
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        $payment = json_decode($response);
        
        if ($payment->state === 'approved') {
            // Payment is successful
            $item_total = 0;
            foreach ($_SESSION["cart_item"] as $item) {
                $item_total += ($item["price"] * $item["quantity"]);
           
        
                $SQL = "INSERT INTO users_orders(u_id, table_number, title, quantity, price, total_price, payerID) 
                        VALUES ('".$_SESSION["user_id"]."', '$tableNumber', '".$item["title"]."', '".$item["quantity"]."', '".$item["price"]."', '$item_total', '$payerId')";
                mysqli_query($db, $SQL);
            }
        
            unset($_SESSION['cart_item']); // Clear the cart_item session
        
            // Display success message
            ?>
            <div class="payment-card">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="checkmark">✓</i>
                </div>
                <h1>Success</h1>
                <p>Thank You <br>We have received your order request !</p>
            </div>


            <?php

        } else {
            ?>

            <div class="payment-card">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="crossmark">X</i>
                </div>
                <h1 style="color: red">Failed</h1>
                <p>Sorry<br> Payment failed</p>
            </div>
            <?php
        }
    } else {
        echo "Failed to communicate with PayPal API.";
    }
} else {
    echo "Invalid PayPal payment parameters.";
}
?>
    </div>
    </section>


    <!-- footer -->
    <?php
include 'footer.php'
?>



    <!--  Custom Js File Link -->
    <script src="script.js"></script>




</body>

</html>

<?php

?>