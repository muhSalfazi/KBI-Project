<?php
include_once("../../connection.php");

$kbndn	= $_POST["kbndn"];
$dnno	= $_POST["dn_no"];

    // echo "kbndn = ".$kbndn." <br/>";
    // echo "dnno = ".$dnno." <br/>";

    $cekJobNos= mysqli_query ($mysqli, "SELECT * FROM masterpart_mmki WHERE PartNo='$kbndn'");
	$resultcekJobNos=mysqli_fetch_array($cekJobNos);
    $job_nos = $resultcekJobNos['JobNo'];
    $job_no_last = substr($job_nos, -1);

    $cekRows = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery INNER JOIN tbl_deliverynote ON tbl_deliverynote.dn_no=tbl_kbndelivery.dn_no AND tbl_deliverynote.job_no=tbl_kbndelivery.job_no WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no='$job_nos'");
    $rowcekRows = mysqli_num_rows ($cekRows);

    $cekData = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery INNER JOIN tbl_deliverynote ON tbl_deliverynote.dn_no=tbl_kbndelivery.dn_no AND tbl_deliverynote.job_no=tbl_kbndelivery.job_no WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no='$job_nos'");
    $rowcekData = mysqli_fetch_array ($cekData);

    // echo "rowcekRows = ".$rowcekRows." <br/>";
    if($rowcekRows == 0 AND $rowcekData['seq_no']==''){
        $seq_nos = $job_no_last.'001';
    }elseif($rowcekRows >= 1 AND $rowcekData['seq_no']!=''){
        $seq_nos = $job_no_last.'00'.($rowcekRows+1);
    }

    $dndrkbndn= $dnno;
    
    // echo "job_nos = ".$job_nos." <br/>";
    // echo "job_no_last = ".$job_no_last." <br/>";
    // echo "seq_nos = ".$seq_nos." <br/>";
    // echo "dndrkbndn = ".$dndrkbndn." <br/>";
    $seq_nos3g=substr($seq_nos, -3);
    // echo "seq_nos3g = ".$seq_nos3g." <br/>";
    $kbndnall=$dnno.$job_nos.$seq_nos3g;
    // echo "kbndnall = ".$kbndnall." <br/>";
	$cekdn = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbndn_no='$kbndnall'");
    $rowcekdn = mysqli_num_rows ($cekdn);
    // echo "rowcekdn = ".$rowcekdn." <br/>";

	$cekqtydelivery = mysqli_query($mysqli, "SELECT *, COUNT(*) AS total , COUNT(*)*QtyPerKbn AS totalpcs FROM tbl_kbndelivery INNER JOIN masterpart_mmki ON masterpart_mmki.JobNo=tbl_kbndelivery.job_no INNER JOIN tbl_deliverynote ON tbl_deliverynote.dn_no=tbl_kbndelivery.dn_no AND tbl_deliverynote.job_no=tbl_kbndelivery.job_no WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no='$job_nos' ");
								
	
	$cekqtydn= mysqli_query ($mysqli, "SELECT *, COUNT(*) AS cekdatadn FROM tbl_deliverynote WHERE dn_no='$dnno' AND job_no='$job_nos'");
	$resultcekqtydn=mysqli_fetch_array($cekqtydn);


    $resultcekqtydelivery = mysqli_fetch_array($cekqtydelivery);
    
    $outstanding = $resultcekqtydelivery['qty_pcs'] - $resultcekqtydelivery['totalpcs'];
    $qty_pcs  = $resultcekqtydelivery['qty_pcs'];
    $totalpcs = $resultcekqtydelivery['totalpcs'];
    // echo "qty_pcs = ".$qty_pcs."<br/>";
    // echo "totalpcs = ".$totalpcs."<br/>";

    
    // echo "outstanding = ".$outstanding." <br/>";
    // echo "resultcekqtydn = ".$resultcekqtydn['cekdatadn']." <br/>";
	if (($dnno == $dndrkbndn AND $rowcekdn >= 0 AND $outstanding > 0 ) OR ($resultcekqtydelivery['totalpcs'] >=0 AND $resultcekqtydn['cekdatadn']>0 ))  {
        header("Location: ../delivery_smart_processkbi.php?kbndn=$kbndnall&&val=ok");
        exit();
    
    }else{
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");	
	}
	
?>