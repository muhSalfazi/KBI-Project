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
$sql = mysqli_query($mysqli, "UPDATE masterpart_mmki SET 
    InvId       = '$InvId',
	PartName					= '$PartName',
    PartNo         = '$PartNo',
    JobNo      = '$JobNo',
	QtyPerKbn      		= '$QtyPerKbn'
    WHERE InvId = '$id'
    ");
