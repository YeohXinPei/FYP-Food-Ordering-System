<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(empty($_SESSION["adm_id"]))
{
	header('location:index.php');
}
else
{




if(isset($_POST['submit']))           //if upload btn is pressed
{
	
			
				
										
            $status = $_POST['status'];
            $r_table = $_POST['r_table'];
            $bookingId = $_GET['booking_upd'];
            
            $sql = "UPDATE table_booking SET status = '$status', `r_table` = '$r_table' WHERE b_id = '$bookingId'";
            mysqli_query($db, $sql);
            
                                                  
			  
													$success = 	'<div class="alert alert-success alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Record Updated!</strong>.
															</div>';
                
	
										
                                    }
                                
	           
	   


?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">

    <?php
include 'header_sidebar.php'
?>

    <!-- Page wrapper  -->
    <div class="page-wrapper" style="height:1200px;">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dashboard</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->


            <?php  echo $error;
									        echo $success; ?>




            <div class="col-lg-12">
                <div class="card card-outline-primary">

                    <h4 class="m-b-0 ">Update Booking</h4>

                    <div class="card-body">
                        <form action='' method='post' enctype="multipart/form-data">
                            <div class="form-body">
                                <?php $ssql ="select * from table_booking where b_id='$_GET[booking_upd]'";
													$res=mysqli_query($db, $ssql); 
													$row=mysqli_fetch_array($res);?>
                                <hr>
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Booking Status</label>
                                            <br>

                                            <select name="status">
                                                <option value="">Select Status</option>
                                                <option value="booked">Booked</option>
                                                <option value="confirmed">Confirmed</option>
                                                <option value="completed">Completed</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>


                                        </div>



                                        <div class="form-group">
                                            <label class="control-label">Table Number</label>
                                            <br>

                                            <select name="r_table">
                                                <option value="">Select Table</option>
                                                <option value="Table 1">Table1</option>
                                                <option value="Table 2">Table2</option>
                                                <option value="Table 3">Table3</option>
                                                <option value="Table 4">Table4</option>
                                                <option value="Table 5">Table5</option>
                                                <option value="Table 6">Table6</option>
                                            </select>


                                        </div>
                                    </div>





                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" name="submit" class="btn btn-success" value="Submit">
                                <a href="all_bookings.php" class="btn btn-inverse">Close</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>







        </div>
        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->
    <!-- footer -->

    <!-- End footer -->
    </div>
    <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

</body>

</html>
<?php
}
?>