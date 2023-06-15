<?php
    //import PHPMailer classes into the global namespace
    //download from Github
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();//starting session*  

    require 'vendor/autoload.php';// PHPMailer Object
?>

<?php
/* declare variable */
$firstnameErr = $lastnameErr = $emailErr = $contactnoErr = $passwordErr = $confirmpasswordErr = "";
$firstname= $lastname = $email = $contactno = $password = $confirmpassword = $msg = "";

include("connection/connect.php"); // connection
  

// check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  
        //validate firstname
        if (empty($_POST["firstname"])) {
          $firstnameErr = "First name is required";// throw error message
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $_POST['firstname'])){
        $firstnameErr = "Only accept characters and white space";// throw error message
        }else{
          $firstname = mysqli_real_escape_string($db,trim($_POST["firstname"]));// receive input values from the form
        }
      

        //validate lastname
        if (empty($_POST["lastname"])) {
          $lastnameErr = "Last name is required";// throw error message
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $_POST['lastname'])){
        $lastnameErr = "Only accept characters and white space";// throw error message
        }else{
          $lastname = mysqli_real_escape_string($db,trim($_POST["lastname"]));// receive input values from the form
        }
      

         //validate email
        if (empty($_POST["email"])) {
          $emailErr = "Email is required";// throw error message
        } else {
		  	$email = mysqli_real_escape_string($db,trim($_POST["email"]));// receive input values from the form
			
              if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $emailErr = "Please enter a valid email";// throw error message
              }else{
              // check if email already exists in database
              $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
              $result = mysqli_query($db, $user_check_query);
              // fetch a result row as an associative array:
              $user = mysqli_fetch_assoc($result);
              // return $user;
       
                      if ($user) { // if user exists
                        if ($user['email'] === $email) {
                        $emailErr =  "Email already exists"; // throw error message
                        }
                      }
                    }		    
          }

        //validate contactno
        if (empty($_POST["contactno"])) {
          $contactnoErr = "Contact no is required";// throw error message
        } elseif (!preg_match("/^[0-9\-]{8,15}$/",$_POST["contactno"])){
        $contactnoErr = "Only accept contact no with integers";// throw error message
        }else{
          $contactno = mysqli_real_escape_string($db,trim($_POST["contactno"]));// receive input values from the form
        }
      

        //validate password
        if (empty($_POST["password"])) {
          $passwordErr = "Password is required";// throw error message
        } elseif (preg_match('/^[A-Z]+$/', $_POST['password'])|| (preg_match('/^[a-z]+$/', $_POST['password']))|| (preg_match("/^[0-9]{1}$/",$_POST["password"])) || strlen($_POST["password"])<6){
        $passwordErr = "Only accept 6 characters minimum, include 1 capital letter and 1 integer";// throw error message
        }else{
          $password = mysqli_real_escape_string($db,trim(md5($_POST["password"])));// receive input values from the form
        }
      

        //validate confirmpassword
        if (empty($_POST["confirmpassword"])) {
          $confirmpasswordErr = "Confirm password is required";// throw error message
        } elseif ($_POST['password'] != $_POST['confirmpassword']){
        $confirmpasswordErr = "Passwords does not match";// throw error message
        }else{
          $confirmpassword= mysqli_real_escape_string($db,trim(md5($_POST["confirmpassword"])));// receive input values from the form
        }

        // basic validation - checking null fields
if (empty($firstnameErr) && empty($lastnameErr) && empty($emailErr) && empty($contactnoErr) &&empty($confirmpasswordErr) && empty($passwordErr)){
	  
	
    // generate random email verification code
    // hash the code using MD5 before saving in the database
    $code = mysqli_real_escape_string($db, md5(rand()));


    // insert input into database
    $sql = "INSERT INTO users (firstname, lastname, email, contactno, password, code) VALUES ('$firstname', '$lastname', '$email', '$contactno', '$password','$code')";
    $results = mysqli_query($db, $sql);
          
  //if unsuccessful, prompt alert
	if(!$results){
	$sqlerr = mysqli_error($db);
	echo "<div class='alert alert-danger alert-dismissible fade show'>
    <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'>x</button>
    <strong>Error!</strong> Sorry there was an error creating your account: $sqlerr</div>";
  }
  
  // if successful, send verify email
  elseif($result){
                    echo "<div style='display: inline;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output
                        $mail->isSMTP();										          	 //Send using SMTP 
					            	$mail->SMTPDebug = 0;										         //Stop print debug log
                        $mail->Host       = 'smtp.gmail.com';            //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                        //Enable SMTP authentication
                        $mail->Username   = 'yeohxinpei123@gmail.com';   //SMTP username (set own email address)
                        $mail->Password   = 'slafwgsooybfxmqd';          //SMTP password (set own email password)
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                        $mail->Port       = 465;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('yeohxinpei123@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                              //Set email format to HTML
                        $mail->Subject = 'no reply';
                        // Send verification link with code
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost:81/exp1/login.php?verification='.$code.'">http://localhost:81/exp1/login.php?verification='.$code.'</a></b>';


                        // if successful send email, prompt alert & head to login page
                        if ($mail->send()){
    
                        $msg= '<div class="alert alert-success" style="font-size: 18px;">A verification link has send to you email.</div>';
					              header("Refresh: 5; URL=login.php");

                        }

			            		} catch (Exception $e) {
                        //require connect to wifi in order to send email
                        // throw error message if could no send the email
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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



    <!-- Register Start -->
    <div class="container-fluid">
        <?php echo $msg; ?>
        <section class="register-section">
            <div class="register-form">
                <h1>- Register Now -</h1>
                <form method="post" action="" novalidate>
                    <span class="error"> * <?php echo $firstnameErr;?></span><br>
                    <input required name="firstname" placeholder="Enter Your First Name" type="text"><br>

                    <span class="error"> * <?php echo $lastnameErr;?></span><br>
                    <input required name="lastname" placeholder="Enter Your Last Name" type="text"><br>

                    <span class="error"> * <?php echo $contactnoErr;?></span><br>
                    <input required name="contactno" placeholder="Enter Your Phone Number" type="text"><br>

                    <span class="error"> * <?php echo $emailErr;?></span><br>
                    <input required name="email" placeholder="Enter Your Email" type="text"><br>



                    <span class="error"> * <?php echo $passwordErr;?></span><br>
                    <input required name="password" placeholder="Enter Your Password" type="password"><br>

                    <span class="error"> * <?php echo $confirmpasswordErr;?></span><br>
                    <input required name="confirmpassword" placeholder="Enter Your Confirm Password"
                        type="password"><br>


                    <button type="submit" value="submit" name="submit" class="login-btn">Login</button>
                    <p>Already have an account ? <a href="login.php">Login now</a></p>
                </form>
            </div>
        </section>
    </div>
    <!-- Register End -->



    <?php
include 'footer.php';
?>

    <!--  Custom Js File Link -->
    <script src="script.js"></script>
</body>

</html>