<html>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="qrcode.js"></script>
<style>
div {float:left;  margin-left:15px; margin-top:15px; }

</style>
<?php 
 include_once("../connection.php");
 echo $_GET['var'].'</br>';?>
<?php echo $_GET['seq'];
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;

session_start();
require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");


$IdUser = $_SESSION["id_user"];


  include('phpqrcode/qrlib.php');
  if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
  
  
  
  //html PNG location prefix
  $PNG_WEB_DIR = 'uploads/';
  
  if(!file_exists($PNG_TEMP_DIR)){
	  mkdir($PNG_TEMP_DIR);
  }
  
  
  
  $filename	=	$PNG_WEB_DIR.time().uniqid('-QR-').'.png';
  
  //processing form input
  //remember to sanitize user input in real-life solution !!!
  $errorCorrectionLevel = $_REQUEST['level'];
  $matrixPointSize = $_REQUEST['size'];
//Database//
$data = mysqli_query($mysqli,"SELECT a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	 FROM tbl_deliverynote a
	LEFT JOIN master_partadm b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	GROUP BY CONCAT(a.dn_no,a.job_no) ORDER BY a.id desc LIMIT 5");
	
		
	//echo $d['dn_no'].'-'.$i; 
	$jobno	=	$d['jobno'];
	$modelno	= $d['jobno'];
	$partno	=	$d['jobno'];
	$invid	=	$d['jobno'];
	$qtyperkbn	= $_POST['qtyperkbn'];
	$partname	= $_POST['partname'];
	$sequence	= $_POST['sequence'];
	$id	= $_POST['id_kbi'];
	$partnokiri = SUBSTR($partno, 6);
?>

<?php 
for ($i=1; $i <= $sequence; $i++)
{
	include 'print_kanban.php';
}?>
<?php

	}
	?>
<?php
  //require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?> 
</html>

  
