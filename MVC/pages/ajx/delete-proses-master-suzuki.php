<?php
include_once("../../connection.php");
    $id   = $_POST['triger'];
    
	//POST DATA
	$InvId      = $_POST['InvId'];
	$PartName      = $_POST['PartName'];
	$PartNo      = $_POST['PartNo'];
	$JobNo       = $_POST['JobNo'];
	$QtyPerKbn      = $_POST['QtyPerKbn'];
    
    //do
$sql = mysqli_query($mysqli,"DELETE FROM masterpart_suzuki WHERE InvId = '$id'
    ");
	echo $GET_['id'];
	?>
