<?php
session_start();
include_once("../../connection.php");
$id   = $_POST['f'];

//POST DATA
$a      = $_POST['a'];
$b      = $_POST['b'];
$c      = $_POST['c'];
$d       = $_POST['d'];
$e      = $_POST['e'];
$g      = $_POST['g'];
/* $Q = mysqli_query ($mysqli, "SELECT * FROM masterpart_hino WHERE (InvId='$a' OR PartNo='$c' OR JobNo='$d') ");*/
$Q = mysqli_query($mysqli, "SELECT * FROM masterpart_hino WHERE (InvId='$a' OR PartNo='x' OR JobNo='x') ");
$R = mysqli_fetch_array($Q);
if ($R) {
	echo 'Data Sudah Ada';
	$_SESSION['alert'] = '1';
	//echo "window.location=('input_delivery.php');"
} else {
	$sql = mysqli_query($mysqli, "INSERT INTO masterpart_hino SET 
	InvId					= '$a',
    PartName         = '$b',
    PartNo      = '$c',
	JobNo      		= '$d',
	QtyPerKbn	= '$e',
    ModelNo		= '$g'
    ");
}
