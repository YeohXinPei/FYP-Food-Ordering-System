<?php
include("connection/connect.php");
error_reporting(0);
session_start(); 
include_once 'product-action.php'; //including controller
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

    <div class="menu_container">
        <?php
if(isset($_SESSION['message'])){
    echo '<div class="alert alert-success" id="success-alert" style="font-size: 18px;">' . $_SESSION['message'] . '</div>';
    echo '<script>setTimeout(function(){document.getElementById("success-alert").remove();}, 3000);</script>';
    unset($_SESSION['message']); // remove the message from the session
}
?>
        <!--side bar-->

        <nav class="sidebar">
            <ul>
                <?php 
        $ress = mysqli_query($db, "SELECT * FROM category");
        while ($rows = mysqli_fetch_array($ress)) {
            echo '<li><a href="dishes.php?res_id=' . $rows['cat_id'] . '">' . $rows['title'] . '</a></li>';
        }
        ?>
            </ul>
        </nav>
        <!--Side bar ends-->



        <?php
// display values and item of food/dishes
if (!isset($_GET['res_id'])) {
    $stmt = $db->prepare("select * from dishes");
} else {
    $stmt = $db->prepare("select * from dishes where cat_id='$_GET[res_id]'");
}
$stmt->execute();
$products = $stmt->get_result();
if (!empty($products)) {
    foreach($products as $product) {



?>

        <form method="post"
            action='dishes.php?res_id=<?php echo $_GET['res_id'];?>&action=add&id=<?php echo $product['d_id']; ?>'>
            <div class="box">
                <div class="menu">
                    <?php echo '<img src="admin/Res_img/dishes/'.$product['img'].'" alt="Food logo"  style="max-width: auto;">'; ?>
                    <h3><?php echo $product['title']; ?></h3>
                    <p><?php echo $product['slogan']; ?></p>
                    <span class="price">RM <?php echo $product['price']; ?></span>
                    <br>
                    <input class="qty" type="text" name="quantity" value="1" oninput="limitQuantity(this, 100)">

                    <input type="submit" name="submit" class="btn" value="Add to cart" />
                </div>
            </div>
        </form>
        <?php


    }
}

if(isset($_POST['submit'])){
    session_start();
    if(empty($_SESSION['user_id']))  //if usser is not login redirected baack to login page
{
	header('location:login.php');
}
else
{
    $_SESSION['message'] = "Item added to cart!";
    header("Location: dishes.php");
    exit();
}
}


?>




    </div>

    <!-- footer -->
    <?php
include 'footer.php'
?>


    <!--  Custom Js File Link -->
    <script src="script.js"></script>
</body>

</html>