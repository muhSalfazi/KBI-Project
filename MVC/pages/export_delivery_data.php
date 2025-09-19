<?php
require '../connection.php'; // Pastikan koneksi database diatur dengan benar
require '../vendor/autoload.php'; // Memuat autoload dari Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if dn_no is specified
if (!isset($_GET['dn_no']) || empty($_GET['dn_no'])) {
    die('Error: No dn_no specified.');
}

$dn_no = $_GET['dn_no'];

// Create new Spreadsheet object
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

// Mendapatkan data dari database
$query = "SELECT a.ETA, a.datetime_input, a.tanggal_order, a.id, a.dn_no, a.job_no AS JobNo, 
a.customerpart_no, a.qty_pcs, ROUND(a.qty_pcs/b.QtyPerKbn) sequence, b.QtyPerKbn, a.status, a.plan, a.cycle,
b.InvId, b.PartName, b.PartNo, b.ModelNo, b.QtyPerKbn, COUNT(c.job_no) countp
FROM tbl_deliverynote a
LEFT JOIN masterpart_mmki b ON a.job_no = b.JobNo
LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no)
WHERE a.dn_no = ?
GROUP BY CONCAT(a.dn_no,a.job_no) 
ORDER BY a.id desc";

// Prepare and execute the query
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $dn_no);
$stmt->execute();
$result = $stmt->get_result();

// Set filename with dn_no
$filename = 'delivery-data-' . $dn_no . '.xlsx';

if ($result->num_rows > 0) {
    $rowNumber = 2; // Mulai dari baris kedua untuk data
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1);
        $sheet->setCellValue('B' . $rowNumber, $row['tanggal_order']);
        $sheet->setCellValue('C' . $rowNumber, $row['dn_no']);
        $sheet->setCellValue('D' . $rowNumber, $row['JobNo']);
        $sheet->setCellValue('E' . $rowNumber, $row['customerpart_no']);
        $sheet->setCellValue('F' . $rowNumber, $row['QtyPerKbn']);
        $sheet->setCellValue('G' . $rowNumber, $row['sequence']);
        $sheet->setCellValue('H' . $rowNumber, $row['qty_pcs']);
        $sheet->setCellValue('I' . $rowNumber, $row['countp']);
        $sheet->setCellValue('J' . $rowNumber, $row['plan']);
        $sheet->setCellValue('K' . $rowNumber, $row['ETA']);
        $sheet->setCellValue('L' . $rowNumber, $row['cycle']);
        $sheet->setCellValue('M' . $rowNumber, ($row['sequence'] == $row['countp']) ? 'Close' : $row['status']);
        $sheet->setCellValue('N' . $rowNumber, $row['datetime_input']);
        $rowNumber++;
    }
} else {
    die('No data found for the specified dn_no.');
}

// Menyimpan file Excel ke dalam format .xlsx
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
