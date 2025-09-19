<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="qrcode.js"></script>
<style>
div {float:left;  margin-left:15px; margin-top:15px; }
</style>
<?php
include_once("../connection.php");
session_start(); 
	$id	= $_REQUEST['id_kbi'];
	IF($_GET['print_all']=='1'){
		echo "<script>window.print();</script>";}
	ELSE IF($_GET['print_now']=='1'){
		$kondisi="WHERE CONCAT(SUBSTR(NOW(),9,2),'-',SUBSTR(NOW(),6,2),'-',SUBSTR(NOW(),1,4)) = a.tanggal_order AND a.status = 'Open'";
		echo "<script>window.print();</script>";}	
	ELSE IF($_GET['view_all']=='1'){ echo '';}
	Else IF($id>0){
			
			$kondisi="WHERE a.id = '$id' AND a.status = 'Open'";			
		IF($_GET['view']=='1'){echo '';}
		else {$sql = mysqli_query($mysqli,
		"INSERT INTO tbl_count_print (dn_no,job_no,id_label) VALUES('$_REQUEST[dn]','$_REQUEST[jobno]','$_REQUEST[id_kbi]')");
		echo "<script>window.print();</script>";}
		
		
	}	
	
	//echo $id;
	$data = mysqli_query($mysqli,"SELECT a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp,
	COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN master_partadm b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	LEFT JOIN tbl_count_print d ON d.id_label = a.id ".$kondisi."
	GROUP BY CONCAT(a.dn_no,a.job_no) ORDER BY a.id desc");
	while($d=mysqli_fetch_array($data))	{	
	 //IF($id<1){$id=$d['id'];}
	$id=$d['id']; 
    $date=$d['tanggal_order'];
	$dates= substr($date,8,4).substr($date,3,2).substr($date,0,2);
    $link	=	$d['JobNo'].$dates;
    $jobno	=	$d['JobNo'];
	$modelno	= $d['ModelNo'];
	$partno	=	$d['PartNo'];
	$invid	=	$d['InvId']; 
	$qtyperkbn	= $d['QtyPerKbn'];
	$partname	= $d['PartName'];
	$sequence	= $d['sequence'];
	
	$dn = $d['dn_no'];
	$cycle = $d['cycle'];
	$partnokiri = SUBSTR($partno, 6);
	
	

 
		for ($i=1; $i <= $sequence; $i++)
		{
			include 'print_kanban.php';
		}
	}
 
?>
