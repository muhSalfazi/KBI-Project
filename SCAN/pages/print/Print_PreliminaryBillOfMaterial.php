<?php
include '../../connection.php';
// memanggil library FPDF
require('library/fpdf.php');

if ($_GET['ID']) {
//validasi ID

	$IdRFQForm 	= $_GET['ID'];
	$Revision 	= $_GET['REVISION'];
	$QuerySelectRFQ=mysqli_query($mysqli, "SELECT tbl_rfq.project_name, tbl_customer.customer_name, tbl_bill_of_material.revision_pbom, tbl_bill_of_material.created_b, tbl_user.full_name, tbl_rfq.issue_date, tbl_bill_of_material.level_bill, tbl_bill_of_material.part_name_bill, tbl_bill_of_material.part_no_bill, tbl_bill_of_material.id_material, tbl_bill_of_material.size, tbl_bill_of_material.mass, tbl_bill_of_material.qty, tbl_bill_of_material.name_file_image_open FROM tbl_bill_of_material INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_bill_of_material.id_user = tbl_user.id_user WHERE tbl_bill_of_material.id_rfq_bill = ".$IdRFQForm." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$IdRFQForm.") AND tbl_bill_of_material.revision_pbom = ".$Revision." AND tbl_bill_of_material.revision_bom = (SELECT MAX(tbl_bill_of_material.revision_bom) as revision_bom FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$IdRFQForm.")");
    $ResultQuerySelectRFQ=mysqli_fetch_array($QuerySelectRFQ);

	// intance object dan memberikan pengaturan halaman PDF
	
	$pdf = new FPDF('P','mm','A4');
	// membuat halaman baru
	$pdf->AddPage();

	$pdf->SetFont('TIMES','B',7);

	$image1 = "../img/logo_header.png";
	$pdf->Cell( 100, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'C', false );

	$pdf->Cell(31,6,'PROJECT NAME',1,0);
	$pdf->SetFont('TIMES','',7);
	$pdf->Cell(60,6,$ResultQuerySelectRFQ['project_name'],1,1); 

	$pdf->SetFont('TIMES','B',7);

	$pdf->Cell(100,6,'',0,0);
	$pdf->SetFont('TIMES','B',7);
	$pdf->Cell(31,6,'CUSTOMER NAME',1,0);
	$pdf->SetFont('TIMES','',7);
	$pdf->Cell(60,6,$ResultQuerySelectRFQ['customer_name'],1,1);

	$pdf->SetFont('TIMES','B',14);
	$pdf->Cell(100,7,'PART LIST',0,0,'C');

	$pdf->SetFont('TIMES','B',7);
	$pdf->Cell(31,6,'REVISION NUMBER',1,0);
	$pdf->SetFont('TIMES','',7);
	$pdf->Cell(60,6,$ResultQuerySelectRFQ['revision_pbom'],1,1); 

	$pdf->SetFont('TIMES','B',14);
	$pdf->Cell(100,7,'PRELIMINARY BILL OF MATERIAL',0,0,'C');

	$pdf->SetFont('TIMES','B',7);
	$pdf->Cell(31,6,'REVISION DATE',1,0);
	$pdf->SetFont('TIMES','',7);
	$pdf->Cell(60,6,$ResultQuerySelectRFQ['created_b'],1,1); 

	$pdf->SetFont('TIMES','B',7);
	
	$pdf->Cell(100,6,'',0,0);
	$pdf->Cell(31,6,'REVISION BY',1,0);
	$pdf->SetFont('TIMES','',7);
	$pdf->Cell(60,6,$ResultQuerySelectRFQ['full_name'],1,1); 

	// --------------------------------------

	$pdf->SetFont('TIMES','B',7);
	$pdf->Ln();
	$pdf->Cell(190,7,'ISSUE DATE	: '.$ResultQuerySelectRFQ['issue_date'],0,1,'L');

	$pdf->SetFont('TIMES','B',7);

	$pdf->Cell(191,5,'COMPONENT PART',1,1,'C'); 

	$pdf->Cell(20,5,'LEVEL',1,0,'C');

	$pdf->Cell(24,5,'PART NAME',1,0,'C');

	$pdf->Cell(21,5,'PART NO',1,0,'C');

	$pdf->Cell(21,5,'MATERIAL',1,0,'C');

	$pdf->Cell(21,5,'SIZE',1,0,'C');

	$pdf->Cell(21,5,'MASS',1,0,'C');

	$pdf->Cell(21,5,'QTY',1,0,'C');

	$pdf->Cell(21,5,'DWG',1,0,'C');

	$pdf->Cell(21,5,'REMARK',1,1,'C');

	$pdf->SetFont('TIMES','',7);

	$Level 		= explode(",",$ResultQuerySelectRFQ['level_bill']);
    $Material 	= explode(",",$ResultQuerySelectRFQ['id_material']);
    $PartName 	= explode(",",$ResultQuerySelectRFQ['part_name_bill']);
    $PartNo 	= explode(",",$ResultQuerySelectRFQ['part_no_bill']);
    $Size 		= explode(",",$ResultQuerySelectRFQ['size']);
    $Mass 		= explode(",",$ResultQuerySelectRFQ['mass']);
    $Qty 		= explode(",",$ResultQuerySelectRFQ['qty']);
    $Loop 		= 0;
	foreach ($Material as $values) {

		if($values != null){

			$pdf->Cell(20,5,$Level[$Loop],1,0,'C');

			$pdf->Cell(24,5,$PartName[$Loop],1,0,'C');

			$pdf->Cell(21,5,$PartNo[$Loop],1,0,'C');

			$pdf->Cell(21,5,$values,1,0,'C');

			$pdf->Cell(21,5,$Size[$Loop],1,0,'C');

			$pdf->Cell(21,5,$Mass[$Loop],1,0,'C');

			$pdf->Cell(21,5,$Qty[$Loop],1,0,'C');

			$pdf->Cell(21,5,'',1,0,'C');

			$pdf->Cell(21,5,'',1,1,'C');

		}
		$Loop++;
	}

	while ($Loop <= 15) {

		$pdf->Cell(20,5,'',1,0,'C');

		$pdf->Cell(24,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,0,'C');

		$pdf->Cell(21,5,'',1,1,'C');

		$Loop++;

	}

	// $pdf->Ln();

	$image1 = "../file/PreliminaryBillOfMaterial/".$ResultQuerySelectRFQ['name_file_image_open']."";
	$pdf->Cell( 100, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 191.0), 0, 0, 'C', false );

	// $pdf->Ln();

	// $pdf->SetFont('TIMES','B',7);
	// $pdf->Cell(191,7,'Note	: ',0,1,'L');
	// $pdf->Cell(191,7,$ResultQuerySelectRFQ['note'],0,1,'L');
	
	
	$FileName = date('dmYHis').'_'.'PRELIMINARY_BILL_OF_MATERIAL'.'_'.$ResultQuerySelectRFQ['project_name'].'.pdf';
	$pdf->Output($FileName, 'D');
}

?>
