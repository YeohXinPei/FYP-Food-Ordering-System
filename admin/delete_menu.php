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


// sending query
mysqli_query($db,"DELETE FROM dishes WHERE d_id = '".$_GET['menu_del']."'");
header("location:all_menu.php");  
}
?>