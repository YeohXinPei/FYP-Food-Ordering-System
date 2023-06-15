<?php
include("connection/connect.php");
error_reporting(0);
session_start();

include_once 'product-action.php';

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$_SESSION["table_number"] = $_POST["table"];
// Calculate the total price before the PayPal payment code
$item_total = 0;
foreach ($_SESSION["cart_item"] as $item) {
    $item_total += ($item["price"] * $item["quantity"]);
}

if (isset($_POST['submit'])) {
    // Set up PayPal API credentials
    $client_id = 'ARu68cSyRE5IP7Bl8908D91_fnuH_ppGwWtUU9vvi2MF1QAw0UfzRMuffXHlV0QEsSuIknkg1qhsNIOZ';
    $client_secret = 'EDplrFyV_2HqxG8E-vexSjOJ1ygxtqKCSK-UmFsfwIeIUBqooCzHaE3ntth5m5KWiIXubPLdabyhmi__';

    // Create a PayPal payment
    $api_url = 'https://api.sandbox.paypal.com/v1/payments/payment';
    $data = [
        'intent' => 'sale',
        'payer' => [
            'payment_method' => 'paypal'
        ],
        'transactions' => [
            [
                'amount' => [
                    'total' => number_format($item_total, 2, '.', ''),
                    'currency' => 'MYR'
                ]
            ]
        ],
        'redirect_urls' => [
            'return_url' => 'http://localhost:81/exp1/payment_success.php',
            'cancel_url' => 'https://example.com/payment_cancel.php'
        ]
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
        if (isset($payment->links)) {
            $approvalUrl = null;
            foreach ($payment->links as $link) {
                if ($link->rel === 'approval_url') {
                    $approvalUrl = $link->href;
                    break;
                }
            }

            if ($approvalUrl !== null) {
                // Store payer ID in the user_orders database if it is not empty
                $payerId = $payment->payer->payer_info->payer_id;
               

                header("Location: $approvalUrl");
               
                exit();
            } else {

                echo "Failed to retrieve PayPal approval URL.";
            }
        }
    }
}
?>












<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>

    <?php
include 'header.php';
?>



    <div class="cart-section h-custom">





        <div class="container-fluid py-4 px-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-7">
                                    <h5 class="cart-title">Shopping Cart</h5>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php

$item_total = 0;

foreach ($_SESSION["cart_item"] as $item)  // fetch items define current into session ID
{
?>
                                            <div class="d-flex justify-content-between" style="margin-bottom: 20px;">
                                                <div class="d-flex flex-row align-items-center">

                                                    <div class="ms-3">
                                                        <h5 class="item-name"><?php echo $item["title"]; ?></h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div style="width: 50px;">
                                                        <h5 class="fw-normal mb-0"><?php echo $item["quantity"]; ?></h5>
                                                    </div>
                                                    <div style="width: 80px;">
                                                        <h5 class="mb-0"><?php echo "$ ".$item["price"]; ?></h5>
                                                    </div>

                                                    <a href="cart.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>"
                                                        style="color: #cecece;"><i class="fa-solid fa-trash"></i></a>


                                                </div>

                                            </div>
                                            <?php
$item_total += ($item["price"]*$item["quantity"]); // calculating current price into cart
}
?>
                                        </div>

                                    </div>

                                </div>




                                <div class="col-lg-5">
                                    <div class="card bg-primary text-white rounded-3">
                                        <div class="card-body">
                                            <p>Table Number (PLEASE SELECT YOUR TABLE NUMBER!)</p>
                                            <br>
                                            <form action=" " method="Post">
                                                <select name="table" class="mb-2" style="font-size: 15px;" required>
                                                    <option value="Table1">Table 1</option>
                                                    <option value="Table2">Table 2</option>
                                                    <option value="Table3">Table 3</option>
                                                    <option value="Table4">Table 4</option>
                                                    <option value="Table5">Table 5</option>
                                                    <option value="Table6">Table 6</option>
                                                    <option value="Pickup">Pickup</option>
                                                </select>


                                                <hr class="mt-5">
                                                <br>
                                                <p class="mb-2">Payment Method</p>
                                                <br>
                                                <input type="checkbox" id="myCheckbox" name="myCheckbox"
                                                    value="isChecked" disabled>
                                                <a href="#!" type="submit" class="text-white">
                                                    <img src="https://i.imgur.com/2ISgYja.png" alt="Mastercard"
                                                        class="payment-icon" width="50" style="height: 30px;">
                                                </a>
                                                <a href="#!" type="submit" class="text-white">
                                                    <img src="https://i.imgur.com/W1vtnOV.png" alt="Visa"
                                                        class="payment-icon" width="50" style="height: 30px;">
                                                </a>
                                                <a href="#!" type="submit" class="text-white">
                                                    <img src="https://i.imgur.com/35tC99g.png" alt="American Express"
                                                        class="payment-icon" width="50" style="height: 30px;">
                                                </a>



                                                <br><br>

                                                <label for="myCheckbox">
                                                    <input type="checkbox" id="myCheckbox" name="myCheckbox"
                                                        value="isChecked" checked>
                                                    <img src="https://i.imgur.com/7kQEsHU.png" alt="PayPal" width="50"
                                                        style="height: 30px;">
                                                </label>







                                                <hr class="my-5">
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2 mt-3 ms-1">Subtotal</p>
                                                    <p class="mb-2 mt-3 ms-1"><?php echo "RM ".$item_total; ?></p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2 ms-1">Service Tax</p>
                                                    <p class="mb-2 ms-1">-</p>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <p class="mb-2 ms-1">Total</p>
                                                    <p class="mb-2 ms-1"><?php echo "RM ".$item_total; ?></p>
                                                </div>
                                                <button class="checkout ms-1" type="submit"
                                                    onclick="return confirm('Are you sure?');" name="submit"
                                                    value="Order now">Checkout
                                                </button>





                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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