    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo text -->
                        <span>Monsant Club</span>
                    </a>
                </div>
                <!-- End Logo -->
                <?php
                        $query = mysqli_query($db, "SELECT * FROM admin WHERE adm_id='{$_SESSION["adm_id"]}'");
                        if (mysqli_num_rows($query) > 0) {
                           
                            $row = mysqli_fetch_assoc($query);
                            ?>
                <div style="font-size: 20px; "><?php echo "Welcome " . $row['username'] . " !";?></div>
                <?php
                        }
                        ?>

                <div class="navbar-collapse">


                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">

                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  "
                                href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>

                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  "
                                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>


                    </ul>





                    <!-- Profile -->
                    <li class="nav-item dropdown">




                        <div class="dropdown-menu dropdown-menu-right animated zoomIn">


                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>

                </div>
                </li>

        </div>
        </nav>
    </div>
    <!-- End header header -->







    <!-- Left Sidebar  -->
    <div class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-devider"></li>
                    <li class="nav-label">Home</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span
                                class="hide-menu">Dashboard</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="dashboard.php">Dashboard</a></li>

                        </ul>
                    </li>
                    <li class="nav-label">Log</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"> <span><i
                                    class="fa fa-user f-s-20 "></i></span><span class="hide-menu">Users</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="allusers.php">All Users</a></li>



                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i
                                class="fa fa-archive f-s-20 color-warning"></i><span
                                class="hide-menu">Category</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="all_category.php">All Category</a></li>
                            <li><a href="add_category.php">Add Category</a></li>

                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery"
                                aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="all_menu.php">All Menues</a></li>
                            <li><a href="add_menu.php">Add Menu</a></li>


                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-shopping-cart"
                                aria-hidden="true"></i><span class="hide-menu">Orders</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="all_orders.php">All Orders</a></li>

                        </ul>
                    </li>

                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-calendar"
                                aria-hidden="true"></i><span class="hide-menu">Reservations</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="all_bookings.php">All Table Reservations</a></li>

                        </ul>
                    </li>


                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </div>
    <!-- End Left Sidebar  -->