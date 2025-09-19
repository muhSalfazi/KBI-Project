<?php
require '../connection.php'; // Pastikan koneksi database diatur dengan benar
require '../vendor/autoload.php'; // Memuat autoload dari Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menulis header kolom
$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Delivery Date');
$sheet->setCellValue('C1', 'Delivery Manifest No.');
$sheet->setCellValue('D1', 'Job No.');
$sheet->setCellValue('E1', 'Customer Part No.');
$sheet->setCellValue('F1', 'Qty Box.');
$sheet->setCellValue('G1', 'Acuan Scan');
$sheet->setCellValue('H1', 'Total Qty Pcs.');
$sheet->setCellValue('I1', 'Proses Scan');
$sheet->setCellValue('J1', 'Plant');
$sheet->setCellValue('K1', 'Dlv.Time(ETA)');
$sheet->setCellValue('L1', 'Cycle');
$sheet->setCellValue('M1', 'Status');
$sheet->setCellValue('N1', 'Date Input');

// Mengambil status dari URL atau set default menjadi kosong
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Menentukan kondisi query berdasarkan status
if ($status) {
    $query = "SELECT 
                a.ETA, 
                a.datetime_input, 
                a.tanggal_order, 
                a.id, 
                a.dn_no, 
                a.job_no AS JobNo, 
                a.customerpart_no, 
                a.qty_pcs, 
                ROUND(a.qty_pcs/b.QtyPerKbn) sequence, 
                b.QtyPerKbn, 
                a.status, 
                a.plan, 
                a.cycle,
                b.InvId, 
                b.PartName, 
                b.PartNo, 
                b.ModelNo, 
                b.QtyPerKbn, 
                COUNT(c.job_no) countp
            FROM tbl_deliverynote a
            LEFT JOIN masterpart_mmki b ON a.job_no = b.JobNo
            LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no)
            WHERE a.status = '$status'
            GROUP BY CONCAT(a.dn_no,a.job_no) 
            ORDER BY a.id desc";
    $filename = 'All-Manifest-Data-' . ucfirst($status) . '.xlsx';
} else {
    $query = "SELECT 
                a.ETA, 
                a.datetime_input, 
                a.tanggal_order, 
                a.id, 
                a.dn_no, 
                a.job_no AS JobNo, 
                a.customerpart_no, 
                a.qty_pcs, 
                ROUND(a.qty_pcs/b.QtyPerKbn) sequence, 
                b.QtyPerKbn, 
                a.status, 
                a.plan, 
                a.cycle,
                b.InvId, 
                b.PartName, 
                b.PartNo, 
                b.ModelNo, 
                b.QtyPerKbn, 
                COUNT(c.job_no) countp
            FROM tbl_deliverynote a
            LEFT JOIN masterpart_mmki b ON a.job_no = b.JobNo
            LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no)
            GROUP BY CONCAT(a.dn_no,a.job_no) 
            ORDER BY a.id desc";
    $filename = 'All-Manifest-Data-All.xlsx';
}

$result = mysqli_query($mysqli, $query);

if (mysqli_num_rows($result) > 0) {
    $rowNumber = 2; // Mulai dari baris kedua untuk data
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValueExplicit('A' . $rowNumber, $rowNumber - 1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $rowNumber, $row['tanggal_order'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // Gunakan TYPE_STRING jika Anda ingin merawat format tanggal
        $sheet->setCellValueExplicit('C' . $rowNumber, $row['dn_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $rowNumber, $row['JobNo'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $rowNumber, $row['customerpart_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('F' . $rowNumber, $row['QtyPerKbn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('G' . $rowNumber, $row['sequence'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('H' . $rowNumber, $row['qty_pcs'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('I' . $rowNumber, $row['countp'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('J' . $rowNumber, $row['plan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('K' . $rowNumber, $row['ETA'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // Atur sesuai kebutuhan Anda
        $sheet->setCellValueExplicit('L' . $rowNumber, $row['cycle'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('M' . $rowNumber, ($row['sequence'] == $row['countp']) ? 'Close' : $row['status'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('N' . $rowNumber, $row['datetime_input'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // Gunakan TYPE_STRING jika Anda ingin merawat format tanggal
        $rowNumber++;
    }
}

// Menyimpan file Excel ke dalam format .xlsx
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
