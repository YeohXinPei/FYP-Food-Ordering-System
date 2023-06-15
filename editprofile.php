<!DOCTYPE html>
<html lang="en">
<?php

error_reporting(0);
session_start();

include("connection/connect.php"); // connection to db

if(isset($_POST['submit'] ))
{
    if(empty($_POST['firstname']) ||
   	    empty($_POST['lastname'])|| 
		empty($_POST['contactno']) ||  
		empty($_POST['email']))
		{
			$msg = "<div class='alert alert-danger' id='danger-alert' style='font-size: 18px;'>All fields is required</div>";
		echo '<script>setTimeout(function(){document.getElementById("danger-alert").remove();}, 3000);</script>';
		}
	else
	{
		

	if (!preg_match('/^[a-zA-Z ]+$/', $_POST['firstname'])){
		$msg = "<div class='alert alert-danger' id='danger-alert' style='font-size: 18px;'>First name only accept characters and white space</div>";
		echo '<script>setTimeout(function(){document.getElementById("danger-alert").remove();}, 3000);</script>';
	}

	elseif(!preg_match('/^[a-zA-Z ]+$/', $_POST['lastname'])){
		$msg = "<div class='alert alert-danger' id='danger-alert' style='font-size: 18px;'>Last name only accept characters and white space</div>";
		echo '<script>setTimeout(function(){document.getElementById("danger-alert").remove();}, 3000);</script>';
	}

	elseif (!preg_match("/^[0-9\-]{8,15}$/",$_POST["contactno"])){
		$msg = "<div class='alert alert-danger' id='danger-alert' style='font-size: 18px;'>Contact no only accept integer</div>";
		echo '<script>setTimeout(function(){document.getElementById("danger-alert").remove();}, 3000);</script>';
	}
	
    elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
    {
		$msg = "<div class='alert alert-danger' id='danger-alert' style='font-size: 18px;'>Incorrect email format</div>";
		echo '<script>setTimeout(function(){document.getElementById("danger-alert").remove();}, 3000);</script>';
    }
	
	else{

		
	
	$mql = "update users set firstname='$_POST[firstname]', lastname='$_POST[lastname]',email='$_POST[email]', contactno='$_POST[contactno]' where u_id='$_GET[user_upd]' ";
	mysqli_query($db, $mql);
	$msg = "<div class='alert alert-success' id='success-alert' style='font-size: 18px;'>Account successfully updated.</div>";
	echo '<script>setTimeout(function(){document.getElementById("success-alert").remove();}, 3000);</script>';
                                                              
	
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



    <!-- Edit Start -->
    <div class="container-fluid">
        <?php 
echo $msg; ?>
        <section class="edit-section">
            <div class="edit-form">
                <h1>- Your Profile -</h1>
                <?php $ssql ="select * from users where u_id='$_GET[user_upd]'";
													$res=mysqli_query($db, $ssql); 
													$newrow=mysqli_fetch_array($res);?>
                <form action='' method='post'>

                    <input required name="firstname" placeholder="Enter Your First Name" type="text"
                        value="<?php  echo $newrow['firstname']; ?>"><br>

                    <input required name="lastname" placeholder="Enter Your Last Name" type="text"
                        value="<?php  echo $newrow['lastname']; ?>"><br>


                    <input required name="contactno" placeholder="Enter Your Phone Number" type="text"
                        value="<?php  echo $newrow['contactno']; ?>"><br>


                    <input required name="email" placeholder="Enter Your Email" type="text"
                        value="<?php  echo $newrow['email']; ?>"><br>


                    <button type="submit" value="save" name="submit" class="edit-btn">Update</button>

                </form>
            </div>
        </section>
    </div>
    <!-- Edit End -->



    <?php
include 'footer.php';
?>

    <!--  Custom Js File Link -->
    <script src="script.js"></script>
</body>

</html>