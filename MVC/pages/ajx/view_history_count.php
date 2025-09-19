<?php
include_once("../../connection.php");
session_start();

$date1 = $_POST['date1'] ?? '';
$date2 = $_POST['date2'] ?? '';
$cari = $_POST['cari'] ?? '';

$limit = intval($_POST['length']);
$start = intval($_POST['start']);
$search = $_POST['search']['value'];

$where = "1=1";
if ($date1 && $date2) {
    $where .= " AND DATE(datetime_input) BETWEEN '$date1' AND '$date2'";
}
if ($cari) {
    $where .= " AND dn_no LIKE '%$cari%'";
}
if ($search) {
    $where .= " AND (dn_no LIKE '%$search%' OR part_no LIKE '%$search%' OR module_no LIKE '%$search%')";
}

$totalQuery = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM tbl_countadm WHERE $where");
$totalData = mysqli_fetch_assoc($totalQuery)['total'];

$dataQuery = mysqli_query($mysqli, "
    SELECT * 
    FROM tbl_countadm 
    WHERE $where 
    ORDER BY datetime_input DESC 
    LIMIT $start, $limit
");

$data = [];
$no = $start + 1;
while ($row = mysqli_fetch_assoc($dataQuery)) {
    $data[] = [
        "no" => $no++,
        "dn_no" => $row['dn_no'],
        "part_no" => $row['part_no'],
        "seq_no" => $row['seq_no'],
        "module_no" => $row['module_no'],
        "datetime_input" => $row['datetime_input']
    ];
}

$response = [
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalData,
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);
