<?php
include_once("../connection.php");

$data = mysqli_query($mysqli,"SELECT a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	 FROM tbl_deliverynote a
	LEFT JOIN master_partadm b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	WHERE a.id ='160'
	GROUP BY CONCAT(a.dn_no,a.job_no) ORDER BY a.id desc");
	$d=mysqli_fetch_array($data);
		
	echo $d['JobNo'];
	echo $d['customerpart_no'];
?>