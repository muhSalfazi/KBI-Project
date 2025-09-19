<?php
// view_history_delivery.php
include_once("../../connection.php");
session_start();

$date1 = $_POST['date1'] ?? '';
$date2 = $_POST['date2'] ?? '';
$cari = $_POST['cari'] ?? '';

// Paging
$limit = $_POST['length'];
$start = $_POST['start'];
$search = $_POST['search']['value'];

$where = "1=1";

if ($date1 && $date2) {
    $where .= " AND DATE(datetime_input) BETWEEN '$date1' AND '$date2'";
}

if ($cari) {
    $where .= " AND dn_no LIKE '%$cari%'";
}

if ($search) {
    $where .= " AND (dn_no LIKE '%$search%' OR job_no LIKE '%$search%' OR kbicode LIKE '%$search%' OR full_name LIKE '%$search%')";
}

$totalQuery = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM tbl_kbndelivery LEFT JOIN tbl_user ON user=id_user WHERE $where");
$totalData = mysqli_fetch_assoc($totalQuery)['total'];

$dataQuery = mysqli_query($mysqli, "
    SELECT *, b.full_name 
    FROM tbl_kbndelivery 
    LEFT JOIN tbl_user b ON user = b.id_user 
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
        "job_seq" => "<b style='color:blue'>{$row['job_no']}</b>{$row['seq_no']}",
        "kbi_code" => "<b style='color:blue'>" . substr($row['kbicode'], 0, 6) . "</b>" . substr($row['kbicode'], 6),
        "datetime_input" => $row['datetime_input'],
        "full_name" => $row['full_name']
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
