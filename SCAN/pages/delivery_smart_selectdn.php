<?php
include_once("../connection.php");
$dnno	= $_POST["dnno"];

$Select = mysqli_query($mysqli, "SELECT * FROM tbl_deliverynote WHERE dn_no = '$dnno' AND status = 'Open'");
$ditemukandn = 	mysqli_num_rows($Select);
if($ditemukandn > 0){
	header("Location: delivery_process.php?dn_no=$dnno");
	exit();
}else{
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
	<a href='delivery.php'><img src='../pages/img/error.png'></a>";
}

?>
