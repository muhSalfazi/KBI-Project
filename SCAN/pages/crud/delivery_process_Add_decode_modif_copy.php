<?php
include_once("../../connection.php");

$kbndn	= $_POST["kbndn"];
$dnno	= $_POST["dn_no"];

    echo "kbndn = ".$kbndn." <br/>";
    echo "dnno = ".$dnno." <br/>";

    $cekJobNos= mysqli_query ($mysqli, "SELECT * FROM masterpart_mmki WHERE PartNo='$kbndn'");
	$resultcekJobNos=mysqli_fetch_array($cekJobNos);
    $job_nos = $resultcekJobNos['JobNo']; //Untuk TMMIN cari job_nos dari query
    //$job_nos = SUBSTR($kbndn, 16, 7); //UNTUK ADM
	$seq_nos = SUBSTR($kbndn, 23); //cari seqnos dari query
    $dndrkbndn= SUBSTR($kbndn, 0, 16);
    
    echo "job_nos = ".$job_nos." <br/>";
    echo "seq_nos = ".$seq_nos." <br/>";
    echo "dndrkbndn = ".$dndrkbndn." <br/>";

	$cekdn = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbndn_no='$kbndn'");
    $rowcekdn = mysqli_num_rows ($cekdn);
    echo "rowcekdn = ".$rowcekdn." <br/>";

	$cekqtydelivery = mysqli_query($mysqli, "SELECT *, COUNT(*) AS total , COUNT(*)*QtyPerKbn AS totalpcs FROM tbl_kbndelivery INNER JOIN masterpart_mmki ON masterpart_mmki.JobNo=tbl_kbndelivery.job_no INNER JOIN tbl_deliverynote ON tbl_deliverynote.dn_no=tbl_kbndelivery.dn_no AND tbl_deliverynote.job_no=tbl_kbndelivery.job_no WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no='$job_nos' ");
								
	
	$cekqtydn= mysqli_query ($mysqli, "SELECT *, COUNT(*) AS cekdatadn FROM tbl_deliverynote WHERE dn_no='$dnno' AND job_no='$job_nos'");
	$resultcekqtydn=mysqli_fetch_array($cekqtydn);


    $resultcekqtydelivery = mysqli_fetch_array($cekqtydelivery);
    
    $outstanding = $resultcekqtydelivery['qty_pcs'] - $resultcekqtydelivery['totalpcs'];
    $qty_pcs  = $resultcekqtydelivery['qty_pcs'];
    $totalpcs = $resultcekqtydelivery['totalpcs'];
    echo "qty_pcs = ".$qty_pcs."<br/>";
    echo "totalpcs = ".$totalpcs."<br/>";
    
    echo "outstanding = ".$outstanding." <br/>";
    
	if (($dnno == $dndrkbndn AND $rowcekdn == 0 AND $outstanding > 0 ) OR ($resultcekqtydelivery['totalpcs'] ==0 AND $resultcekqtydn['cekdatadn']>0 ))  {
	//$Select2 = mysqli_query($mysqli, "UPDATE tbl_deliverynote SET status = 'Process' WHERE job_no = '$job_nos' ");	
	//if($Insert  ){

	    header("Location: ../delivery_smart_processkbi.php?kbndn=$kbndn&&val=ok");
	exit();
	}else{
	    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");	
	//echo SUBSTR($insertkbndn, 3, 16);
//echo $kbndn, $dnno , $dndrkbndn , $rowcekdn , $resultcekqtydelivery['qty_pcs'] , $resultcekqtydelivery['totalpcs'] , $outstanding;
	}
	
?>