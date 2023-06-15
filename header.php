<?php
include_once 'product-action.php'; //including controller
    // start session if it is not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

<!-- Navbar Start -->
<div class="container-fluid">
    <header class="header">
        <section class="flex">

            <a href="index.php" class="logo">MONSANT CLUB</a>

            <nav class="navbar">
                <a href="index.php">HOME</a>
                <a href="about.php">ABOUT</a>
                <a href="dishes.php">ORDERS</a>
                <a href="index.php#reserve">RESERVATION</a>
                <a href="#footer">CONTACT</a>
            </nav>

            <div class="icons">

                <?php

            
            // check if user is logged in
            if (isset($_SESSION['SESSION_EMAIL'])) {
                include("connection/connect.php"); // connection

                // select data from database
                $query = mysqli_query($db, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");
            
                if (mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                
                    ?>
                <p style="font-size: 17px;"><?php echo "Welcome " . $row['firstname'] . " !";?></p>
                <?php
            

            if(isset($_SESSION["cart_item"])){
                $quantity = 0;
                foreach($_SESSION["cart_item"] as $item) {
                    $quantity += $item["quantity"];
                }
            } else {
                $quantity = 0;
            }
            
            echo '<a href="cart.php" class="shopping-cart-icon"><i class="fas fa-shopping-cart"></i> [' . $quantity . ']</a>';

            
        
            $sql = "SELECT * FROM users ORDER BY u_id DESC";
            $query = mysqli_query($db, $sql);
            
            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                echo '<a href="editprofile.php?user_upd=' . $row['u_id'] . '"><i class="fas fa-user"></i></a>';
            }
            
            echo '<a href="history.php"><i class="fas fa-receipt"></i></a>';
            echo '<a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>';
            
                }
                
            }else{
               echo ' <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>';
               echo ' <a href="login.php">
                <div id="user-btn" class="fas fa-user"></div>
                </a>';
            }

            ?>

                <div id="menu-btn" class="fas fa-bars"></div>
            </div>

        </section>
    </header>
</div>
<!-- Navbar End -->