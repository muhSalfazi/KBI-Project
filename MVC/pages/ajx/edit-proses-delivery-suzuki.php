<?php
include_once("../../connection.php");
$id   = $_POST['triger'];

//POST DATA
$dn_no      = $_POST['xx'];
$job_no      = $_POST['xxx'];
$customerpart_no      = $_POST['xxxx'];
$qty_pcs       = $_POST['xxxxx'];
$plan       = $_POST['plan'];
$cycle       = $_POST['cycle'];
$status      = $_POST['status'];
$tgl = substr($_POST['tgl'], 8, 2) . '-' . substr($_POST['tgl'], 5, 2) . '-' . substr($_POST['tgl'], 0, 4);

//do
$sql = mysqli_query($mysqli, "UPDATE tbl_deliverysuzuki SET 
	dn_no					= '$dn_no',
	job_no					= '$job_no',
    customerpart_no         = '$customerpart_no',
    qty_pcs      = '$qty_pcs',
    plan      = '$plan',
	cycle      = '$cycle',
	status      = '$status',
	tanggal_order      		= '$tgl'
    WHERE id = '$id'
    ");
