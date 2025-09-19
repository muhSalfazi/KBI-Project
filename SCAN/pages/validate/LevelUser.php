<?php
session_unset();
session_destroy();
session_start();
include "../../connection.php";

$Username = $_POST["username"];
$Password = md5($_POST["password"]);
if ($Username=='user') {
		header ("Location: ../delivery_smart.php");
	}

// Validasi Login
else if ($_POST){
	
	$QuerySelectUser = mysqli_query ($mysqli, "SELECT * FROM tbl_user WHERE username='$Username' ");
		
	$ResultQuerySelectUser = mysqli_fetch_array ($QuerySelectUser);
	if($ResultQuerySelectUser["id_role"]=='4'){
			header ("Location: ../../index.php?Err=1");
	}
	
	else if($ResultQuerySelectUser){

		$_SESSION["id_user"] 			= $ResultQuerySelectUser["id_user"];
		$_SESSION["id_role"] 			= $ResultQuerySelectUser["id_role"];
		$_SESSION["username"] 			= $ResultQuerySelectUser["username"];
		$_SESSION["full_name"] 			= $ResultQuerySelectUser["full_name"];
		$_SESSION["block"]				= $ResultQuerySelectUser["block"];
		$_SESSION["Login"] 				= true;
		
		if ($_SESSION["Login"] AND !$_SESSION["block"]){
			//header ("Location: ../index.php");
			header ("Location: ../delivery_smart.php");
			exit();
		}
		else{
			session_unset();
			session_destroy();
			header("Location: ../../index.php?Err=Block");
			exit();
		}

	}
	else if (empty ($Username) && empty ($Password)){
		header ("Location: ../../index.php?Err=1");
		exit();
	}
	else if(empty ($Username)){
		header ("Location: ../../index.php?Err=2");
		exit();
	}
	else if(empty ($Password)){
		header ("Location: ../../index.php?Err=3");
		exit();
	}
	else{
		header ("Location: ../../index.php?Err=5");
		exit();
	}
}
	
?>