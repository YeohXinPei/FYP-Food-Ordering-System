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
mysqli_query($db,"DELETE FROM category WHERE cat_id = '".$_GET['cat_del']."'");
header("location:all_category.php");  
}
?>