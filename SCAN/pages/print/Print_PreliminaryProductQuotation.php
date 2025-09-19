<?php
include '../../connection.php';
// memanggil library FPDF
require('library/fpdf.php');

if ($_GET['ID']) {
//validasi ID

	$IdRFQForm 	= $_GET['ID'];
	$Revision 	= $_GET['REVISION'];
	$QuerySelectProductionData=mysqli_query($mysqli, "SELECT * FROM tbl_product_q INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_product_q.idrfq_p INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_product_q.id_user = tbl_user.id_user WHERE tbl_product_q.idrfq_p = ".$IdRFQForm." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$IdRFQForm.") AND tbl_product_q.revision_q = ".$Revision."");
    $ResultQuerySelectProductionData=mysqli_fetch_array($QuerySelectProductionData);

	// intance object dan memberikan pengaturan halaman PDF
	
	$pdf = new FPDF('P','mm','A4');
	// membuat halaman baru
	$pdf->AddPage();

	$pdf->SetFont('ARIAL','B',7);

	$image1 = "../img/logo_header.png";
	$pdf->Cell( 100, 6, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 2, 'C', false );

	$pdf->Cell(191,6,'',0,1); 

	$pdf->setTextColor(255, 0, 0);
	$pdf->SetFont('ARIAL','B',8);

	$pdf->Cell(47,6,'Estimate validated date 1 month',0,1);

	$pdf->setTextColor(0, 0, 0);
	$pdf->SetFont('ARIAL','B',8);

	$pdf->Cell(30,6,'CUSTOMER NAME',0,0);
	$pdf->SetFont('ARIAL','U',8);
	$pdf->Cell(84,6,$ResultQuerySelectProductionData['customer_name'],0,0);
	$pdf->SetFont('ARIAL','B',8);
	$pdf->Cell(27,6,'PREPARED BY',0,0);
	$pdf->SetFont('ARIAL','U',8);
	$pdf->Cell(47,6,'PE : '.$ResultQuerySelectProductionData['full_name'],0,1);

	$pdf->SetFont('ARIAL','B',8);
	$pdf->Cell(30,6,'P/J NAME',0,0);
	$pdf->SetFont('ARIAL','U',8);
	$pdf->Cell(84,6,$ResultQuerySelectProductionData['project_name'],0,0);
	$pdf->SetFont('ARIAL','B',8);
	$pdf->Cell(27,6,'DATE',0,0);
	$pdf->SetFont('ARIAL','U',8);
	$pdf->Cell(47,6,$ResultQuerySelectProductionData['created_q'],0,1);

	$pdf->setTextColor(255, 0, 0);
	$pdf->SetFont('ARIAL','B',8);

	$pdf->Cell(47,6,'Based on Drawing Quotation',0,1);

	$pdf->Ln();

	$pdf->setTextColor(0, 0, 0);
	$pdf->SetFont('ARIAL','B',6);

	$pdf->Cell(47,6,'Part No',1,0);
	$pdf->Cell(47,6,$ResultQuerySelectProductionData['part_no'],1,0);
	$pdf->Cell(47,6,'Material Name',1,0);
	$Loop = 0;
	$AllMaterial = '';
	$Material = explode(",",$ResultQuerySelectProductionData['mat_name']);
	foreach ($Material as $values) {

		if($values != null){

		  if($values != null && $Loop == 0){
		    $AllMaterial = $AllMaterial.$values;
		  }else if($values != null){
		  	$AllMaterial = $AllMaterial.'+'.$values;
		  }

		  $Loop++;

		}
	}
	$pdf->Cell(50,6,$AllMaterial,1,1);

	$pdf->Cell(47,6,'Part Name',1,0);
	$pdf->Cell(47,6,$ResultQuerySelectProductionData['part_name'],1,0);
	$pdf->Cell(47,6,'Master Batch',1,0);
	$Loop = 0;
	$AllMasterBatch = '';
	$MasterBatch 		= explode(",",$ResultQuerySelectProductionData['mas_batch']);
	$MasterBatchPercent = explode(",",$ResultQuerySelectProductionData['mas_percent']);
	foreach ($MasterBatch as $values) {

		if($values != null){

		  if($values != null && $Loop == 0){
		    $AllMasterBatch = $AllMasterBatch.$values.' '.$MasterBatchPercent[$Loop].'%';
		  }else if($values != null){
		  	$AllMasterBatch = $AllMasterBatch.'+'.$values.' '.$MasterBatchPercent[$Loop].'%';
		  }

		  $Loop++;

		}
	}
	$pdf->Cell(50,6,$AllMasterBatch,1,1);

	$pdf->Cell(47,6,'Quantity/month',1,0);
	$pdf->Cell(47,6,$ResultQuerySelectProductionData['volume'],1,1);

	$pdf->Cell(47,6,'Depreciation qyt',1,0);
	$pdf->Cell(47,6,$ResultQuerySelectProductionData['depreciation_qty'],1,1);

	$pdf->Ln();

	$pdf->SetFont('ARIAL','B',8);
	$pdf->Cell(30,6,'Molding process',0,1);

	$pdf->SetFont('ARIAL','B',6);

	$pdf->Cell(23,6,'Cycle time',1,0);
	$pdf->Cell(24,6,$ResultQuerySelectProductionData['cycle_time'].' Sec',1,0,'R');
	$pdf->Cell(24,6,'M/C size',1,0);
	$pdf->Cell(24,6,$ResultQuerySelectProductionData['mc_size'].' mm',1,0,'R');

	$pdf->Cell(27,6,'Die size',1,0);
	$pdf->Cell(22,6,$ResultQuerySelectProductionData['die_size'].' mm',1,0,'R');
	$pdf->Cell(24,6,'Core size',1,0);
	$pdf->Cell(24,6,$ResultQuerySelectProductionData['core_size'].' mm',1,1,'R');


	$pdf->Cell(47,6,'Extrude Material',1,0);
	$pdf->Cell(48,6,$ResultQuerySelectProductionData['ext_material'].' gr',1,0);

	$Loop = 0;
	$AllProductWeight = '';
	$AllToleransiWeight = '';
	$ProductWeight 		= explode(",",$ResultQuerySelectProductionData['product_weight']);
	$ToleransiWeight = explode(",",$ResultQuerySelectProductionData['toleransi_weight']);
	foreach ($ProductWeight as $values) {

		if($values != null){

		  if($values != null && $Loop == 0){
		    $AllProductWeight = $AllProductWeight.$values;
		    $AllToleransiWeight = $AllToleransiWeight.$ToleransiWeight[$Loop];

		  }else if($values != null){
		  	$AllProductWeight = $AllProductWeight.'+'.$values;
		  	$AllToleransiWeight = $AllToleransiWeight.'+'.$ToleransiWeight[$Loop];
		  }

		  $Loop++;

		}
	}

	$pdf->Cell(27,6,'Product Weight (g)',1,0);
	$pdf->Cell(22,6,$AllProductWeight,1,0,'R');
	$pdf->Cell(24,6,'Core size (%)',1,0);
	$pdf->Cell(24,6,$AllToleransiWeight,1,1,'R');


	$pdf->Cell(47,6,'Material change loss',1,0);
	$pdf->Cell(48,6,$ResultQuerySelectProductionData['material_change_loss'].' kg',1,0);

	$pdf->Cell(27,6,'Cavity',1,0);
	$pdf->Cell(22,6,$ResultQuerySelectProductionData['cavity'],1,1,'R');


	$pdf->Cell(47,6,'Preparation time ( Die/Core, Mold, Material )',1,0);
	$pdf->Cell(48,6,$ResultQuerySelectProductionData['preparation_time'],1,0);
	$pdf->Cell(49,6,'Defect ratio',1,0);
	$pdf->Cell(48,6,$ResultQuerySelectProductionData['defect_ratio'],1,1);


	$pdf->Cell(95,6,'',0,0);
	$pdf->Cell(49,6,'Production Qty/h',1,0);
	$pdf->Cell(48,6,$ResultQuerySelectProductionData['product_qty'].' pcs',1,1);

	$pdf->Ln();

	$pdf->SetFont('ARIAL','B',8);
	$pdf->Cell(30,6,'Finishing process',0,1);

	$pdf->SetFont('ARIAL','B',7);

	$pdf->Cell(67,6,'Process name',1,0,'C');
	$pdf->Cell(27,6,'Time (sec)',1,0,'C');
	$pdf->Cell(67,6,'Tooling name',1,0,'C');
	$pdf->Cell(30,6,'Price (Rp)',1,1,'C');

	$LoopProcessName = 0;
	$LoopToolingName = 0;
	$LoopNull = 0;
	$SumTimeSec = 0;
	$SumPrice = 0;
	$ProcessName 		= explode(",",$ResultQuerySelectProductionData['process_name']);
	$TimeSec 			= explode(",",$ResultQuerySelectProductionData['time_sec']);
	$ToolingName 		= explode(",",$ResultQuerySelectProductionData['tooling_name']);
	$Price 				= explode(",",$ResultQuerySelectProductionData['price']);
	foreach ($ProcessName as $values) {
		if($values != null){
			
			$SumTimeSec = $SumTimeSec + $TimeSec[$LoopProcessName];

		  	$LoopProcessName++;
		}
	}

	foreach ($ToolingName as $values) {
		if($values != null){

			$SumPrice = $SumPrice + $Price[$LoopToolingName];

		  	$LoopToolingName++;
		}
	}

	$pdf->SetFont('ARIAL','B',6);

	$Loop = 0;
	if($LoopProcessName >= $LoopToolingName){

		while($LoopProcessName >= 1){

			$pdf->Cell(67,6,$ProcessName[$Loop],1,0,'L');
			$pdf->Cell(27,6,$TimeSec[$Loop],1,0,'C');
			$pdf->Cell(67,6,$ToolingName[$Loop],1,0,'L');
			$pdf->Cell(30,6,'Rp '.$Price[$Loop],1,1,'R');

			$Loop++;
			$LoopProcessName = $LoopProcessName - 1;

		}

		while($LoopNull < 3){

			$pdf->Cell(67,6,'',1,0,'L');
			$pdf->Cell(27,6,'',1,0,'C');
			$pdf->Cell(67,6,'',1,0,'L');
			$pdf->Cell(30,6,'',1,1,'R');

			$LoopNull++;

		}

		$pdf->SetFont('ARIAL','B',7);

		$pdf->Cell(67,6,'Production Time',1,0,'L');
		$pdf->Cell(27,6,$SumTimeSec,1,0,'C');
		$pdf->Cell(67,6,'Process Equipment cost',1,0,'L');
		$pdf->Cell(30,6,'Rp '.$SumPrice,1,1,'R');
	
	}else if($LoopToolingName >= $LoopProcessName){

		while($LoopToolingName >= 1){

			$pdf->Cell(67,6,$ProcessName[$Loop],1,0,'L');
			$pdf->Cell(27,6,$TimeSec[$Loop],1,0,'C');
			$pdf->Cell(67,6,$ToolingName[$Loop],1,0,'L');
			$pdf->Cell(30,6,'Rp '.$Price[$Loop],1,1,'R');

			$Loop++;
			$LoopToolingName = $LoopToolingName - 1;

		}

		while($LoopNull < 3){

			$pdf->Cell(67,6,'',1,0,'L');
			$pdf->Cell(27,6,'',1,0,'C');
			$pdf->Cell(67,6,'',1,0,'L');
			$pdf->Cell(30,6,'',1,1,'R');

			$LoopNull++;

		}

		$pdf->SetFont('ARIAL','B',7);

		$pdf->Cell(67,6,'Production Time',1,0,'L');
		$pdf->Cell(27,6,$SumTimeSec,1,0,'C');
		$pdf->Cell(67,6,'Process Equipment cost',1,0,'L');
		$pdf->Cell(30,6,'Rp '.$SumPrice,1,1,'R');

	}

	$pdf->Ln();

	$pdf->SetFont('ARIAL','B',8);
	$pdf->Cell(30,6,'Other/Note',0,1);

	$pdf->SetFont('ARIAL','B',7);

	$pdf->Cell(67,6,$ResultQuerySelectProductionData['notes'],0,0);

	$pdf->Ln();
	$pdf->Ln();

	
	$FileName = date('dmYHis').'_'.'PRELIMINARY_PRODUCTION_DATA'.'_'.$ResultQuerySelectProductionData['project_name'].'.pdf';
	$pdf->Output($FileName, 'D');
}

?>
