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
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dashboard</h3>
            </div>

        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-12">



                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">All User Orders</h4>
                            <div class="table-responsive m-t-40">
                                <form method="GET" action="">
                                    <label for="search-date">Search by date:</label>
                                    <input type="date" id="search-date" name="search_date">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>

                                <table id="example23"
                                    class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Table Number</th>
                                            <th>Title</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Reg-Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                    $searchDate = $_GET['search_date'] ?? '';

                    $sql = "SELECT users.*, users_orders.*, users_orders.quantity * users_orders.price AS total_item_price
                            FROM users
                            INNER JOIN users_orders ON users.u_id = users_orders.u_id";

                    if (!empty($searchDate)) {
                        // Modify the query to include the date filter
                        $sql .= " WHERE DATE(users_orders.date) = '$searchDate'";
                    }

                    $query = mysqli_query($db, $sql);

                    if (mysqli_num_rows($query) > 0) {
                        while ($rows = mysqli_fetch_array($query)) {
                            echo '<tr>
																					           <td>'.$rows['firstname'].'</td>
                                                                                               <td>'.$rows['table_number'].'</td>
																								<td>'.$rows['title'].'</td>
                                                                                                <td>'.$rows['quantity'].'</td>
																								<td>$'.$rows['price'].'</td>
                                                                                                <td>$' . $rows['total_item_price'] . '</td>';
                                                                                                
                                                                              
																								?>


                                        <?php 
    $status = $rows['status'];
    if ($status == "" or $status == "paymentreceived") {
?>
                                        <td>
                                            <button type="button" class="btn btn-info" style="font-weight:bold;">
                                                <span class="fa fa-bars" aria-hidden="true">Payment Received
                                            </button>
                                        </td>
                                        <?php 
    } elseif ($status == "in kitchen") {
?>
                                        <td>
                                            <button type="button" class="btn btn-warning">
                                                <span class="fa fa-cog fa-spin" aria-hidden="true"></span>In Kitchen!
                                            </button>
                                        </td>
                                        <?php
    } elseif ($status == "completed") {
?>
                                        <td>
                                            <button type="button" class="btn btn-success">
                                                <span class="fa fa-check-circle" aria-hidden="true">Completed
                                            </button>
                                        </td>
                                        <?php 
    } elseif ($status == "cancelled") {
?>
                                        <td>
                                            <button type="button" class="btn btn-danger">
                                                <i class="fa fa-close"></i>Cancelled
                                            </button>
                                        </td>
                                        <?php 
    } 
?>


                                        <?php																									
																							echo '	<td>'.$rows['date'].'</td>';
																							?>
                                        <td>
                                            <a href="delete_orders.php?order_del=<?php echo $rows['o_id'];?>"
                                                onclick="return confirm('Are you sure?');"
                                                class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                    class="fa fa-trash-o" style="font-size:16px"></i></a>
                                            <?php
																								echo '<a href="order_update.php?form_id='.$rows['o_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
																									</td>
																									</tr>';
																					 
																						
																						
																		}	
														}
												
											
											?>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->





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


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>
<?php
}
?>