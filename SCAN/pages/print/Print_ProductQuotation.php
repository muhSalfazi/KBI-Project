<?php
include '../../connection.php';
// memanggil library FPDF
require('library/fpdf.php');

if ($_GET['ID']) {
//validasi ID

	$IdRFQForm = $_GET['ID'];
	$QuerySelectRFQ=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_material ON tbl_rfq.id_material = tbl_material.id_material INNER JOIN tbl_color ON tbl_rfq.color = tbl_color.id_color INNER JOIN tbl_category ON tbl_rfq.category = tbl_category.id_category INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm");
    $ResultQuerySelectRFQ=mysqli_fetch_array($QuerySelectRFQ);

	// intance object dan memberikan pengaturan halaman PDF
	$pdf = new FPDF('P','mm','A4');
	// membuat halaman baru
	$pdf->AddPage();
	// setting jenis font yang akan digunakan
	$pdf->SetFont('TIMES','B',18);
	// mencetak string 
	$pdf->Cell(190,7,'RFQ',0,1,'C');
	$pdf->Cell(190,7,'( REQUEST FOR QUOTATION )',0,1,'C');
	$pdf->Ln();

	$pdf->Line(10, 33, 200, 33);

	$pdf->SetFont('TIMES','',13);
	$pdf->Ln();
	$pdf->Cell(190,7,'COMPANY				:  PT.Kyoraku Blowmolding Indonesia',0,1,'L');
	$pdf->Cell(190,7,'SECTION							:  Marketing',0,1,'L');
	$pdf->Cell(190,7,'NAME 											: '.$ResultQuerySelectRFQ['full_name'],0,1,'L');
	$pdf->Cell(190,7,'ISSUE DATE	:  '.$ResultQuerySelectRFQ['issue_date'],0,1,'L');

	$pdf->Line(10, 70, 200, 70);

	$pdf->Ln();
	//$pdf->MultiCell(100,5,'CUSTOMER		: PT.Kyoraku Blowmolding Indonesia'.'SS',0,1);
	// Memberikan space kebawah agar tidak terlalu rapat

	$pdf->Cell(50,7,'CUSTOMER									: '.$ResultQuerySelectRFQ['customer_name'],0,0);
	$pdf->Cell(50,7,'',0,0);
	$pdf->Cell(85,7,'END USER				: '.$ResultQuerySelectRFQ['end_user'],0,1);

	$pdf->Cell(50,7,'PROJECT NAME	: '.$ResultQuerySelectRFQ['project_name'],0,0);
	$pdf->Cell(50,7,'',0,0);
	$pdf->Cell(85,7,'CAR NAME			: '.$ResultQuerySelectRFQ['car_name'],0,1);

	$pdf->Cell(50,7,'PART NUMBER		: '.$ResultQuerySelectRFQ['part_no'],0,0);
	$pdf->Cell(50,7,'',0,0);
	$pdf->Cell(85,7,'PART NAME	:  '.$ResultQuerySelectRFQ['part_name'],0,1);

	$pdf->Line(10, 98, 200, 98);

	$pdf->Ln();

	$pdf->Cell(190,7,'ATTACHED				:  '.$ResultQuerySelectRFQ['attached'],0,1,'L');
	$pdf->Cell(190,7,'CATEGORY				:  '.$ResultQuerySelectRFQ['category'],0,1,'L');

	$pdf->Cell(50,7,'VOLUME									: '.$ResultQuerySelectRFQ['volume'],0,0);
	$pdf->Cell(50,7,'',0,0);
	$pdf->Cell(85,7,'COLOR															: '.$ResultQuerySelectRFQ['color_name'],0,1);

	$pdf->Cell(190,2,'(Qty/month)',0,1,'L');
	$pdf->Cell(50,2,'',0,1);

	$pdf->Cell(50,7,'MATERIAL					: '.$ResultQuerySelectRFQ['material'],0,0);
	$pdf->Cell(50,7,'',0,0);
	$pdf->Cell(85,7,'PRODUCTS							: '.$ResultQuerySelectRFQ['product'],0,1);

	$pdf->Cell(50,7,'PROVISION OF 3D		: '.$ResultQuerySelectRFQ['provision_of_3d'],0,0);
	$pdf->Cell(50,7,'',0,0);
	$pdf->Cell(85,7,'SUBMIT LIMIT	:  '.$ResultQuerySelectRFQ['submit_limit'],0,1);

	$pdf->Line(10, 143, 200, 143);

	$pdf->Ln();

	$pdf->Cell(190,7,'DELIVERY RUTE	: '.$ResultQuerySelectRFQ['delivery_rute'],0,1,'L');
	$pdf->Cell(190,7,'SOP																									: '.$ResultQuerySelectRFQ['sop'],0,1,'L');


	$pdf->Ln();
	$pdf->Ln();


	$pdf->SetFont('TIMES','',10);

	$pdf->Cell(190,7,'RECIEVE',0,1,'C');

	$pdf->Cell(31,6,'MKT MANAGER',1,0);
	$pdf->Cell(31,6,'DEP. GM NPD',1,0);
	$pdf->Cell(31,6,'GM. MAN',1,0);
	$pdf->Cell(31,6,'GM. QC',1,0); 
	$pdf->Cell(31,6,'DIRECTOR',1,0); 
	$pdf->Cell(35,6,'PRESIDENT',1,1); 

	$pdf->Cell(31,31,'',1,0);
	$pdf->Cell(31,31,'',1,0);
	$pdf->Cell(31,31,'',1,0);
	$pdf->Cell(31,31,'',1,0); 
	$pdf->Cell(31,31,'',1,0); 
	$pdf->Cell(35,31,'',1,1); 

	$pdf->Cell(31,6,'Ibrahim. M',1,0);
	$pdf->Cell(31,6,'Agung. M',1,0);
	$pdf->Cell(31,6,'Dedi. R',1,0);
	$pdf->Cell(31,6,'Hamakawa',1,0); 
	$pdf->Cell(31,6,'Edi Yusuf',1,0); 
	$pdf->Cell(35,6,'H. Fukushima',1,1); 

	$pdf->Cell(31,6,'DATE :',1,0);
	$pdf->Cell(31,6,'DATE :',1,0);
	$pdf->Cell(31,6,'DATE :',1,0);
	$pdf->Cell(31,6,'DATE :',1,0); 
	$pdf->Cell(31,6,'DATE :',1,0); 
	$pdf->Cell(35,6,'DATE :',1,1); 

	$FileName = date('dmYHis').'_'.'RFQFORM'.'_'.$ResultQuerySelectRFQ['project_name'].'.pdf';
	$pdf->Output($FileName, 'D');
}

?>
