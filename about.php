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



    <div class="marquee">
        <p>THE BEST NIGHT IN TOWN ! THE BEST NIGHT IN TOWN ! THE BEST NIGHT IN TOWN !</p>
    </div>



    <div class="container-fluid">
        <div class="about">
            <div class="row">
                <div class="col-md-6">
                    <img src="image/pic5.png" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>Live Band On Every Friday</h2>
                    <h3>8pm - 12am</h3>
                    <a href="index.php#reserve">
                        <button class="book-btn">Book a Table</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="about">
            <div class="row">
                <div class="col-md-6">
                    <h2>Dart Board</h2>
                    <p>Welcome to our club!. Our dart board is a popular source of enjoyment for our members and guests,
                        along with a range of other activities and events we offer throughout the year. Come and check
                        us out!</p>
                    <a href="index.php#reserve">
                        <button class="book-btn">Book a Table</button>
                    </a>
                </div>
                <div class="col-md-6">
                    <img src="image/pic6.png" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="about">
            <div class="row">
                <div class="col-md-6">
                    <img src="image/pic7.png" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2>Happy Hour</h2>
                    <h3> Monday - Friday </h3>
                    <p>Free Extra Snacks</P>
                    <a href="index.php#reserve">
                        <button class="book-btn">Book a Table</button>
                    </a>

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