<?php
session_start();
include_once("../../connection.php");
    $id   = $_POST['triger'];
    
	//POST DATA
	$xx      = $_POST['xx'];
	$xxx      = $_POST['xxx'];
	$xxxx      = $_POST['xxxx'];
	$xxxxx       = $_POST['xxxxx'];
	$cycle       = $_POST['cycle'];
	$plan       = $_POST['plan'];
	$status      = $_POST['status'];
	$tgl = substr($_POST['status'],8,2).'-'.substr($_POST['status'],5,2).'-'.substr($_POST['status'],0,4);
	//$bln = substr($status,0,2);
	//$thn = substr($status,6,4);
	//$date = $tgl.'-'.$bln.'-'$thn;
	$Q = mysqli_query ($mysqli, "SELECT * FROM tbl_deliverytmmin WHERE dn_no='$xx' AND job_no='$xxx'");		
	$R = mysqli_fetch_array ($Q);
	if ($R){
		echo 'Data Sudah Ada';
		$_SESSION['alert']='1';
	}
	else{
$sql = mysqli_query($mysqli,"INSERT INTO tbl_deliverytmmin SET 
	dn_no					= '$xx',
	job_no					= '$xxx',
    customerpart_no         = '$xxxx',
    qty_pcs      = '$xxxxx',
	plan      = '$plan',
	cycle      = '$cycle',
	tanggal_order      		= '$tgl'
    
    ");
	}
	?>
	