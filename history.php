<?php
include("connection/connect.php"); // connection to db

session_start();

include_once 'product-action.php'; //including controller

if(empty($_SESSION['user_id']))  //if usser is not login redirected baack to login page
{
	header('location:login.php');
}
else
{


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



    <div class="history_container">

        <div class="show">
            <form method="GET" action="">
                <label for="row-count">Show by Rows:</label>
                <select id="row-count" name="row_count" onchange="this.form.submit()">
                    <option value="5"
                        <?php if(isset($_GET['row_count']) && $_GET['row_count'] == 5) echo 'selected'; ?>>5</option>
                    <option value="10"
                        <?php if(isset($_GET['row_count']) && $_GET['row_count'] == 10) echo 'selected'; ?>>10</option>
                    <option value="20"
                        <?php if(isset($_GET['row_count']) && $_GET['row_count'] == 20) echo 'selected'; ?>>20</option>
                </select>
            </form>
        </div>
        <div class="search">
            <form method="GET" action="">
                <label for="search-status">Search by Status:</label>
                <select id="search-status" name="search_status">
                    <option value="">All</option>
                    <option value="paymentreceived"
                        <?php if(isset($_GET['search_status']) && $_GET['search_status'] == 'paymentreceived') echo 'selected'; ?>>
                        Payment Received</option>
                    <option value="in kitchen"
                        <?php if(isset($_GET['search_status']) && $_GET['search_status'] == 'in kitchen') echo 'selected'; ?>>
                        In Kitchen</option>
                    <option value="booked"
                        <?php if(isset($_GET['search_status']) && $_GET['search_status'] == 'booked') echo 'selected'; ?>>
                        Booked</option>
                    <option value="confirmed"
                        <?php if(isset($_GET['search_status']) && $_GET['search_status'] == 'confirmed') echo 'selected'; ?>>
                        Confirmed</option>
                    <option value="completed"
                        <?php if(isset($_GET['search_status']) && $_GET['search_status'] == 'completed') echo 'selected'; ?>>
                        Completed</option>
                    <option value="cancelled"
                        <?php if(isset($_GET['search_status']) && $_GET['search_status'] == 'cancelled') echo 'selected'; ?>>
                        Cancelled</option>
                </select>
                <button type="submit" class="submit-btn">Search</button>
            </form>
        </div>

        <div class="title">Order History</div>


        <table class="styled-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Table</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php
            $rowCount = isset($_GET['row_count']) ? $_GET['row_count'] : 5;
            $searchStatus = isset($_GET['search_status']) ? $_GET['search_status'] : '';

            // Prepare the SQL query with optional status filter
            $sql = "SELECT * FROM users_orders WHERE u_id = '{$_SESSION['user_id']}'";
            if (!empty($searchStatus)) {
                $sql .= " AND status = '$searchStatus'";
            }
            $sql .= " LIMIT $rowCount";

            // Execute the query
            $query_res = mysqli_query($db, $sql);

            if (!mysqli_num_rows($query_res) > 0) {
                echo '<tr><td colspan="6"><center>You have no orders placed yet.</center></td></tr>';
            } else {
                while ($row = mysqli_fetch_array($query_res)) {
            ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>RM <?php echo $row['quantity'] * $row['price']; ?></td>
                    <td><?php echo $row['table_number']; ?></td>
                    <td>
                        <?php 
                        $status = $row['status'];
                        if ($status == "" or $status == "paymentreceived") {
                            echo '<button type="button" class="btn btn-primary btn-lg">Payment Received</button>';
                        } elseif ($status == "in kitchen") { 
                            echo '<button type="button" class="btn btn-warning btn-lg">In Kitchen</button>';
                        } elseif ($status == "completed") { 
                            echo '<button type="button" class="btn btn-success btn-lg">Completed</button>';
                        } elseif ($status == "cancelled") { 
                            echo '<button type="button" class="btn btn-danger btn-lg">Cancelled</button>';
                        } 
                        ?>
                    </td>
                    <td><?php echo $row['date']; ?></td>
                </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>


        <div class="title">Table Booking History</div>


        <table class="styled-table">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Table</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

                <?php
            $rowCount = isset($_GET['row_count']) ? $_GET['row_count'] : 5;
            $searchStatus = isset($_GET['search_status']) ? $_GET['search_status'] : '';

            // Prepare the SQL query with optional status filter
            $sql = "SELECT * FROM table_booking WHERE u_id = '{$_SESSION['user_id']}'";
            if (!empty($searchStatus)) {
                $sql .= " AND status = '$searchStatus'";
            }
            $sql .= " LIMIT $rowCount";

            // Execute the query
            $query_res = mysqli_query($db, $sql);

            if (!mysqli_num_rows($query_res) > 0) {
                echo '<tr><td colspan="6"><center>You have no table booked yet.</center></td></tr>';
            } else {
                while ($row = mysqli_fetch_array($query_res)) {
            ?>



                <tr>
                    <td><?php echo $row['size']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo $row['r_table']; ?></td>
                    <td>
                        <?php 
                        $status = $row['status'];
                        if ($status == "" or $status == "booked") {
                        ?>
                        <button type="button" class="btn btn-warning btn-lg">Booked</button>
                        <?php
                        } elseif ($status == "confirmed") { 
                        ?>
                        <button type="button" class="btn btn-warning btn-lg">Confirmed</button>
                        <?php
                        } elseif ($status == "completed") { 
                        ?>
                        <button type="button" class="btn btn-success btn-lg">Completed</button>
                        <?php 
                        } elseif ($status == "cancelled") { 
                        ?>
                        <button type="button" class="btn btn-danger btn-lg">Cancelled</button>
                        <?php 
                        } 
                        ?>
                    </td>
                    <td><?php echo $row['book_date']; ?></td>
                </tr>
                <?php
            }
        }
        ?>
            </tbody>
        </table>





        <!-- footer -->
        <?php
include 'footer.php'
?>



        <!--  Custom Js File Link -->
        <script src="script.js"></script>
</body>

</html>

<?php
}
?>