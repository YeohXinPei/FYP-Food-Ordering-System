<?php
include("connection/connect.php");
error_reporting(0);
session_start(); 


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
if($_POST['submit'])
{

  date_default_timezone_set("Asia/Kuala_Lumpur");// set timezone

$datenow = date('y-m-d');// get current date
$timenow = date('h:m:s');// get current time
$userid = $row['id'];


    $SQL = "INSERT INTO table_booking(u_id, size, date, time) 
    VALUES ('".$_SESSION["user_id"]."', '".$_POST["size"]."', '".$_POST["date"]."', '".$_POST["time"]."')";
    mysqli_query($db,$SQL);

    echo '<div class="alert alert-success" id="success-alert" style="font-size: 18px; margin-bottom: 0;">Thank you! You have successfully booked a table.</div>';
    echo '<script>setTimeout(function(){document.getElementById("success-alert").remove();}, 3000);</script>';
    
}

?>


    <!-- hero -->

    <div class="bg-image" style="background-image: url(image/pic1.png);">
        <div class="content">
            <h3>Come Down & Grab a Pint</h3>
            <p>THE BEST NIGHT IN TOWN</p>
            <a href="dishes.php">
                <button class="order-btn">ORDER NOW</button>
            </a>

        </div>
    </div>



    <div class="container-fluid">
        <div class="card-container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0">
                        <a href="about.php">
                            <img src="image/pic2.png" class="card-img-top">
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0">
                        <a href="about.php">
                            <img src="image/pic3.png" class="card-img-top">
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0">
                        <a href="about.php">
                            <img src="image/pic4.png" class="card-img-top">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- reservation -->

    <div class="reserve" id="reserve">
        <form action="" method="post">
            <div class="row">
                <h1>- Reserve A Table -</h1>
                <p>To help us find the best table for you, select the preferred party size, date, and time of your
                    reservation.
                <p>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label for="party-size">Party Size:</label>
                    <input type="number" class="form-control" id="party-size" name="size" placeholder="2" min="1"
                        required>
                </div>
                <div class="col-sm-4">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="datefield" name="date"
                        min="<?php echo date('Y-m-d'); ?>" required>

                </div>
                <div class="col-sm-4">
                    <label for="time">Time:</label>
                    <input type="time" class="form-control" id="time" name="time" min="15:00" max="23:59" step="1"
                        required>
                </div>
                <div class="col-sm-2">
                    <input type="submit" name="submit" class="btn" value="RESERVE NOW" />
                </div>
            </div>
        </form>
    </div>





    <?php
if(isset($_POST['submit'])){
    session_start();
    if(empty($_SESSION['user_id']))  //if usser is not login redirected baack to login page
{
	header('location:login.php');
}
}
?>


    <!-- footer -->
    <?php
include 'footer.php'
?>


    <!--  Custom Js File Link -->
    <script src="script.js"></script>

</body>

</html>