<?php
session_start();
include_once("../../connection.php");
$user = $_SESSION["id_user"]; //correct
$kbndnkbi	= $_POST["kbndnkbi"]; //correct
$job_no	= $_POST["job_no"]; //correct
$dndrkbndn	= $_POST["kbndn"]; 
$dn	= $_POST["dn"];

echo "user = ".$user." <br/>";
echo "kbndnkbi = ".$kbndnkbi." <br/>";
echo "job_no = ".$job_no." <br/>";
echo "dndrkbndn = ".$dndrkbndn." <br/>";
echo "dn = ".$dn." <br/>";

	//$job_nokbi = SUBSTR($kbndnkbi, -7);
	$x= strlen($kbndnkbi)-6; 

	echo "x = ".$x." <br/>";

	echo substr($a,0,$x);
	$invid = SUBSTR($kbndnkbi,0,-8); //correct

	echo "invid = ".$invid." <br/>";

	$qjob_nokbi = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_mmki WHERE InvId = '$invid'");
	$rjob_nokbi = mysqli_fetch_array ($qjob_nokbi); 

	//echo "rjob_nokbi = ".$rjob_nokbi." <br/>";

	$job_nokbi = $rjob_nokbi['JobNo'];

	echo "job_nokbi = ".$job_nokbi." <br/>";

	////$job_nokbi = SUBSTR($kbndnkbi,0,7);
	//$kbicode = SUBSTR($kbndnkbi, 0, -7);
	///$dnno = SUBSTR($dndrkbndn, 0, -11); //wrong
	$dnno = $dn;
	//$seq_nos = SUBSTR($dndrkbndn, -4); //wrong
	$seq_nos = SUBSTR($kbndnkbi,-4);

	//echo "kbicode = ".$kbicode." <br/>";
	echo "dnno = ".$dnno." <br/>";
	echo "seq_nos = ".$seq_nos." <br/>";

	//echo "$job_nokbi";
	$kbi = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbicode = '$kbndnkbi'");
	$ckbi = 	mysqli_num_rows($kbi);

	echo "ckbi = ".$ckbi." <br/>";

	if ($ckbi > 0){
		header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");
	}
	else if ($job_nokbi == $job_no)		
	{
		$Insert = mysqli_query($mysqli, "INSERT INTO tbl_kbndelivery (kbndn_no, dn_no, job_no, seq_no, kbicode, user, invid) VALUES ('$dndrkbndn', '$dnno', '$job_no', '$seq_nos', '$kbndnkbi', '$user', '$invid' )");
		$seq=round($seq_nos);
		echo "seq = ".$seq." <br/>";
		$Update = mysqli_query($mysqli, "UPDATE tbl_deliverynote SET count_process = '$seq' WHERE job_no ='$job_nokbi'");
		$Q = mysqli_query ($mysqli, "SELECT count(no) AS seq FROM tbl_kbndelivery WHERE job_no = '$job_nokbi' ");		
		$R = mysqli_fetch_array ($Q);

			if ($R["seq"]==$seq){
			//$Update = mysqli_query($mysqli, "UPDATE tbl_deliverynote SET status = 'Close' WHERE job_no ='$job_nokbi'");	
			}
			
		header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=ok");
	}
	else 
	{
		header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");
		echo "
		<style type='text/css'>
	.tg  {border-collapse:collapse;border-spacing:0;margin:0px auto;}
	.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
	.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
	.tg .tg-baqh{text-align:center;vertical-align:top}
	@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}</style>
		<div class='tg-wrap'>
		<table class='tg'>
	<tr>
		<th class='tg-baqh' colspan='5'>
		<a href='../delivery_process.php?dn_no=$dnno'><img src='../../pages/img/error.png'></a>";
	}
?>