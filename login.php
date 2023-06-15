<?php
    session_start();// session start
    //update location to order.php if the session is true
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: dishes.php");
        die();
    }

	include("connection/connect.php"); // connection

    $msg = $emailErr = $passwordErr = "";// declare variable

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($db, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {// check the code with the link
           // update users (status = 1) 
            $query = mysqli_query($db, "UPDATE users SET code='', status='1'WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div class='alert alert-success' id='success-alert' style='font-size: 18px;'>Account verification has been successfully completed.</div>";
                echo '<script>setTimeout(function(){document.getElementById("success-alert").remove();}, 3000);</script>';
            }

        } else {
        header("Location: index.php");//if unccessful,update location to index.php
        }
    }

    if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($db, htmlspecialchars(trim($_POST['email'])));// receive input values from the form
    $password = mysqli_real_escape_string($db, htmlspecialchars(trim(md5($_POST['password']))));// receive input values from the form

    $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";// check the input values same with values in database
    if($result = mysqli_query($db, $sql))
             
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);

		if ($row['status'] == 0) {
			$msg = "<div class='alert alert-info'>First verify your account and try again.</div>";// throw error message
		} else {
			$_SESSION["user_id"] = $row['u_id'];
			$_SESSION['SESSION_EMAIL'] = $email;// declare session
			header("Location: index.php");// if code is correct, update location to welcome.php
		}

        }

    // check empty field
    elseif(empty($_POST['email'])){
    $emailErr = "Please fill in required field";// throw error message
    $passwordErr = "Please fill in required field";
    }
        
    //check empty field
    elseif(empty($_POST['password'])){
        $passwordErr = "Please fill in required field";// throw error message
        }

    // validate email
    elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
    $emailErr = "Please enter a valid email";// throw error message
    }
    
    // validate password
    elseif(preg_match('/^[A-Z]+$/', $_POST['password'])|| (preg_match('/^[a-z]+$/', $_POST['password']))|| (preg_match("/^[0-9]{1}$/",$_POST["password"])) || strlen($_POST["password"])<8){
    $passwordErr = "Only accept 6 characters minimum, include 1 capital letter and 1 integer";// throw error message
    }

    else{
    $msg = "<div class='alert alert-danger' id='danger-alert' style='font-size: 18px;'>Email or password do not match.</div>";// throw error message
    echo '<script>setTimeout(function(){document.getElementById("danger-alert").remove();}, 3000);</script>';
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



    <!-- Login Start -->
    <div class="container-fluid">
        <?php echo $msg; ?>
        <section class="login-section">

            <div class="login-form">
                <h1>- Login Now -</h1>
                <form method="post" action="" novalidate>

                    <span class="error"> * <?php echo $emailErr;?></span><br>
                    <input required name="email" placeholder="Enter Your Email" type="text"><br>

                    <span class="error"> * <?php echo $passwordErr;?></span><br>
                    <input required name="password" placeholder="Enter Your Password" type="password"><br>

                    <button type="submit" value="submit" name="submit" class="login-btn">Login</button>
                    <p>Don't have an account ? <a href="registration.php">Register here</a></p>
                </form>
            </div>
        </section>
    </div>
    <!-- Login End -->



    <?php
include 'footer.php';
?>

    <!--  Custom Js File Link -->
    <script src="script.js"></script>
</body>

</html>