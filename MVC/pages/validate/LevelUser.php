<?php
session_unset();
session_destroy();
session_start();
include "../../connection.php";

$Username = $_POST["username"];
$Password = md5($_POST["password"]);

// Validasi Login
if ($_POST) {

	$QuerySelectUser = mysqli_query($mysqli, "SELECT * FROM tbl_user WHERE username='$Username' AND password='$Password'");

	$ResultQuerySelectUser = mysqli_fetch_array($QuerySelectUser);

	if ($ResultQuerySelectUser) {

		$_SESSION["id_user"] 			= $ResultQuerySelectUser["id_user"];
		$_SESSION["id_role"] 			= $ResultQuerySelectUser["id_role"];
		$_SESSION["username"] 			= $ResultQuerySelectUser["username"];
		$_SESSION["full_name"] 			= $ResultQuerySelectUser["full_name"];
		$_SESSION["block"]				= $ResultQuerySelectUser["block"];
		$_SESSION["Login"] 				= true;

		if ($_SESSION["Login"] and !$_SESSION["block"]) {
			$query = "UPDATE tbl_user SET last_login = NOW() ";
			$query .= "WHERE id_user = {$_SESSION["id_user"]} LIMIT 1";

			$result_set = mysqli_query($mysqli, $query);

			header("Location: ../index.php");
			exit();
		} else {
			session_unset();
			session_destroy();
			header("Location: ../../index.php?Err=Block");
			exit();
		}
	} else if (empty($Username) && empty($Password)) {
		header("Location: ../../index.php?Err=1");
		exit();
	} else if (empty($Username)) {
		header("Location: ../../index.php?Err=2");
		exit();
	} else if (empty($Password)) {
		header("Location: ../../index.php?Err=3");
		exit();
	} else {
		header("Location: ../../index.php?Err=5");
		exit();
	}
}
