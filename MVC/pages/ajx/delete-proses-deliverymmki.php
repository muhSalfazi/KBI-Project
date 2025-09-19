<?php
include_once("../../connection.php");
    $id   = $_POST['triger'];
    
	//POST DATA
	$dn_no      = $_POST['xx'];
	$job_no      = $_POST['xxx'];
	$customerpart_no      = $_POST['xxxx'];
	$qty_pcs       = $_POST['xxxxx'];
	$status      = $_POST['status'];
    
    //do
$sql = mysqli_query($mysqli,"DELETE FROM tbl_deliverynote WHERE id = '$id'
    ");
	
	?>