<?php
include '../../connection.php';
// memanggil library FPDF
require('library/fpdf.php');

if ($_GET['ID']) {
//validasi ID

	$IdRFQForm = $_GET['ID'];
	$Revision = $_GET['REVISION'];
	$QuerySelectRFQ=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm AND tbl_rfq.revision = $Revision");
    $ResultQuerySelectRFQ=mysqli_fetch_array($QuerySelectRFQ);

	// intance object dan memberikan pengaturan halaman PDF
	$pdf = new FPDF('L','mm','A4');
	// membuat halaman baru
	$pdf->AddPage();
	// setting jenis font yang akan digunakan
	$pdf->SetFont('TIMES','B',18);
	// mencetak string 
	$pdf->Cell(170,7,'RFQ',0,0,'C');

	$pdf->SetFont('TIMES','B',12);

	$pdf->Cell(31,6,'Company',1,0);
	$pdf->Cell(72,6,'PT.Kyoraku Blowmolding Indonesia',1,1); 

	$pdf->SetFont('TIMES','B',18);

	$pdf->Cell(170,7,'( REQUEST FOR QUOTATION )',0,0,'C');

	$pdf->SetFont('TIMES','B',12);

	$pdf->Cell(31,6,'Section',1,0);
	$pdf->Cell(72,6,'MKT (Marketing)',1,1); 

	$pdf->Cell(170,6,'',0,0);
	$pdf->Cell(31,6,'Name',1,0);
	$pdf->Cell(72,6,$ResultQuerySelectRFQ['full_name'],1,1); 

	$pdf->Cell(170,6,'',0,0);
	$pdf->Cell(31,6,'Revision',1,0);
	$pdf->Cell(72,6,$ResultQuerySelectRFQ['revision'],1,1); 

	// --------------------------------------

	$pdf->SetFont('TIMES','B',12);
	$pdf->Ln();
	$pdf->Cell(190,7,'ISSUE DATE	: '.$ResultQuerySelectRFQ['issue_date'],0,1,'L');
	$pdf->Ln();

	$pdf->Cell(37,6,'Customer Name',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['customer_name'],1,0);
	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'End User',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['end_user'],1,1); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Project Name',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['project_name'],1,0);
	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Car Name',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['car_name'],1,1); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Part No',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['part_no'],1,0);
	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Part Name',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['part_name'],1,1); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(272,7,'General Schedule',1,1,'C'); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'SOP',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['sop'],1,0);
	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Volume(Qty/moth)',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['volume'],1,1);

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Attached',1,0);
	$pdf->SetFont('TIMES','',12);
	$Loop = 0;
	$AllAttached = '';
	$Attached = explode(",",$ResultQuerySelectRFQ['attached']);
	foreach ($Attached as $values) {

		if($values != null){

		  $QueryGetAttached = $mysqli->query("SELECT * FROM `tbl_attached` WHERE id_attached = $values");
		  $ResultQueryGetAttached = mysqli_fetch_array($QueryGetAttached);

		  if($ResultQueryGetAttached['id_attached'] != null  && $Loop == 0){
		    $AllAttached = $AllAttached.$ResultQueryGetAttached['attached'];
		  }else if($ResultQueryGetAttached['id_attached'] != null){
		  	$AllAttached = $AllAttached.', '.$ResultQueryGetAttached['attached'];
		  }

		  $Loop++;

		}
	}
	$pdf->Cell(235,6,$AllAttached,1,1); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Category',1,0);
	$pdf->SetFont('TIMES','',12);
	$Loop = 0;
	$AllCategory = '';
	$Category = explode(",",$ResultQuerySelectRFQ['id_category']);
	foreach ($Category as $values) {

		if($values != null){

		  $QueryGetCategory = $mysqli->query("SELECT * FROM `tbl_category` WHERE id_category = $values");
		  $ResultQueryGetCategory = mysqli_fetch_array($QueryGetCategory);

		  if($ResultQueryGetCategory['id_category'] != null && $Loop == 0){
		    $AllCategory = $AllCategory.$ResultQueryGetCategory['category'];
		  }else if($ResultQueryGetCategory['id_category'] != null){
		  	$AllCategory = $AllCategory.', '.$ResultQueryGetCategory['category'];
		  }

		  $Loop++;

		}
	}
	$pdf->Cell(235,6,$AllCategory,1,1); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Material',1,0);
	$pdf->SetFont('TIMES','',12);
	$Loop = 0;
	$AllMaterial = '';
	$Material = explode(",",$ResultQuerySelectRFQ['id_material']);
	foreach ($Material as $values) {

		if($values != null){

		  $QueryGetMaterial = $mysqli->query("SELECT * FROM `tbl_material` WHERE id_material = $values");
		  $ResultQueryGetMaterial = mysqli_fetch_array($QueryGetMaterial);

		  if($ResultQueryGetMaterial['id_material'] != null && $Loop == 0){
		    $AllMaterial = $AllMaterial.$ResultQueryGetMaterial['material'];
		  }else if($ResultQueryGetMaterial['id_material'] != null){
		  	$AllMaterial = $AllMaterial.' + '.$ResultQueryGetMaterial['material'];
		  }

		  $Loop++;

		}
	}
	$pdf->Cell(235,6,$AllMaterial,1,1); 

	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Products',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['production_process'],1,0);
	$pdf->SetFont('TIMES','B',12);
	$pdf->Cell(37,6,'Submit Limit',1,0);
	$pdf->SetFont('TIMES','',12);
	$pdf->Cell(99,6,$ResultQuerySelectRFQ['deadline_mkt'],1,1); 	

	$pdf->Ln();

	$pdf->SetFont('TIMES','B',12);

	$pdf->Cell(190,7,'Delivery Place	: '.$ResultQuerySelectRFQ['delivery_destination'],0,1,'L');

	$pdf->Cell(190,7,'Remark	: '.$ResultQuerySelectRFQ['note_rfq'],0,1,'L');

	$pdf->SetFont('TIMES','B',10);

	$pdf->Cell(272,7,'RECIEVE',0,1,'C');

	$pdf->SetFont('TIMES','',10);
	
	$pdf->Cell(45,6,'MKT MANAGER',1,0);
	$pdf->Cell(45,6,'DEP. GM NPD',1,0);
	$pdf->Cell(45,6,'GM. MAN',1,0);
	$pdf->Cell(45,6,'GM. QC',1,0); 
	$pdf->Cell(45,6,'DIRECTOR',1,0); 
	$pdf->Cell(45,6,'PRESIDENT',1,1); 

	$pdf->Cell(45,31,'',1,0);
	$pdf->Cell(45,31,'',1,0);
	$pdf->Cell(45,31,'',1,0);
	$pdf->Cell(45,31,'',1,0); 
	$pdf->Cell(45,31,'',1,0); 
	$pdf->Cell(45,31,'',1,1); 

	$pdf->Cell(45,6,'Ibrahim. M',1,0);
	$pdf->Cell(45,6,'Agung. M',1,0);
	$pdf->Cell(45,6,'Dedi. R',1,0);
	$pdf->Cell(45,6,'Hamakawa',1,0); 
	$pdf->Cell(45,6,'Edi Yusuf',1,0); 
	$pdf->Cell(45,6,'H. Fukushima',1,1); 

	$pdf->Cell(45,6,'DATE :',1,0);
	$pdf->Cell(45,6,'DATE :',1,0);
	$pdf->Cell(45,6,'DATE :',1,0);
	$pdf->Cell(45,6,'DATE :',1,0); 
	$pdf->Cell(45,6,'DATE :',1,0); 
	$pdf->Cell(45,6,'DATE :',1,1); 

	$FileName = date('dmYHis').'_'.'RFQFORM'.'_'.$ResultQuerySelectRFQ['project_name'].'.pdf';
	$pdf->Output($FileName, 'D');
}

?>
