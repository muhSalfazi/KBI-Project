<?php
session_start();
include_once("../connection.php");
require '../vendor/autoload.php'; // Path ke PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['export'])) {
    $date1 = $_GET['date1'] ?? '';
    $date2 = $_GET['date2'] ?? '';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Manifest No');
    $sheet->setCellValue('C1', 'Job No Customer');
    $sheet->setCellValue('D1', 'Inventory ID KBI');
    $sheet->setCellValue('E1', 'ScanDate');
    $sheet->setCellValue('F1', 'User');

    // Query untuk mengambil data sesuai rentang tanggal
    $query = "SELECT *, b.full_name FROM tbl_kbndelivery 
              LEFT JOIN tbl_user b ON USER=b.id_user 
              WHERE SUBSTR(datetime_input,1,10) BETWEEN '$date1' AND '$date2'";
    $result = mysqli_query($mysqli, $query);
    $no = 1;
    $row = 2; // Mulai dari baris kedua

    // Mengisi data ke dalam Excel
    // while ($data = mysqli_fetch_array($result)) {
    //     $sheet->setCellValue('A' . $row, $no);
    //     $sheet->setCellValue('B' . $row, $data['dn_no']);
    //     $sheet->setCellValue('C' . $row, $data['job_no']);
    //     $sheet->setCellValue('D' . $row, $data['kbicode']);
    //     $sheet->setCellValue('E' . $row, $data['datetime_input']);
    //     $sheet->setCellValue('F' . $row, $data['full_name']);
    //     $row++;
    //     $no++;
    // }

    while ($data = mysqli_fetch_array($result)) {
        $sheet->setCellValueExplicit('A' . $row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $data['dn_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $data['job_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row, $data['kbicode'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $row, $data['datetime_input'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // Atau TYPE_STRING jika ingin merawat format tanggal
        $sheet->setCellValueExplicit('F' . $row, $data['full_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $row++;
        $no++;
    }
    

    $filename = 'history-scan_' . $date1 . '_to_' . $date2 . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}
