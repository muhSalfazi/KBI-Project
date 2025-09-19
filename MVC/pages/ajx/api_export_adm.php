<?php
// File: api_export_adm.php

include_once("../../connection.php");

// header('Content-Type: application/json');

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

$whereClauses = [];
if ($status) {
    $whereClauses[] = "a.status = '" . mysqli_real_escape_string($mysqli, $status) . "'";
}
if ($searchValue !== '') {
    $escaped = mysqli_real_escape_string($mysqli, $searchValue);
    $whereClauses[] = "(
        a.dn_no LIKE '%$escaped%' OR a.module_no LIKE '%$escaped%' OR
        a.customerpart_no LIKE '%$escaped%' OR b.PartName LIKE '%$escaped%'
    )";
}
$whereSql = (!empty($whereClauses)) ? "WHERE " . implode(' AND ', $whereClauses) : '';

$totalQuery = "SELECT COUNT(*) as total FROM tbl_eksporadm a LEFT JOIN masterpart_adm b ON a.job_no = b.JobNo $whereSql";
$totalResult = mysqli_query($mysqli, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult)['total'];

$mainQuery = "
    SELECT
        a.id, a.dn_no, a.job_no, a.customerpart_no, a.module_no, a.qty_pcs,
        ROUND(a.qty_pcs / b.QtyPerKbn) AS sequence_adm,
        b.QtyPerKbn AS qty_adm,
        IFNULL(c.countp, 0) AS countp,
        a.status, a.cycle, a.tanggal_order, a.datetime_input, a.ETA
    FROM tbl_eksporadm a
    LEFT JOIN masterpart_adm b ON a.job_no = b.JobNo
    LEFT JOIN (
        SELECT dn_no, part_no, module_no, COUNT(*) AS countp
        FROM tbl_countadm
        GROUP BY dn_no, part_no, module_no
    ) c ON c.dn_no = a.dn_no 
         AND c.part_no = a.customerpart_no 
         AND c.module_no LIKE CONCAT(a.module_no, '%')
    $whereSql
    ORDER BY a.id ASC
    LIMIT {$start}, {$length}
";

$result = mysqli_query($mysqli, $mainQuery);
if (!$result) {
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalData,
        "data" => [],
        "error" => "Error main query: " . mysqli_error($mysqli)
    ]);
    exit;
}

$data = [];
$no = $start + 1;
$bulanList = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nop','Des'];

while ($d = mysqli_fetch_assoc($result)) {
    $statusLabel = ($d['qty_pcs'] == $d['countp']) ? '<label style="color:red;">Close</label>' : '<label>' . $d['status'] . '</label>';

    $date = $d['tanggal_order'];
    $bln = substr($date, 3, 2);
    $tgl = substr($date, 0, 2);
    $thn = substr($date, 6, 4);
    $deliveryDate = (intval($bln) >= 1 && intval($bln) <= 12) ? "$tgl-{$bulanList[intval($bln)]}-$thn" : $date;

    $data[] = [
        $no++,
        $deliveryDate,
        $d['dn_no'],
        // $d['job_no'],
        $d['customerpart_no'],
        $d['module_no'],
        // $d['qty_adm'],
        // $d['sequence_adm'],
        $d['qty_pcs'],
        $d['countp'],
        $d['ETA'],
        $d['cycle'],
        $statusLabel,
        $d['datetime_input'],
        '<a class="edit_delivery btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="' . $d['id'] . '"><i class="fa fa-edit"> Edit</i></a>
         <a class="delete_delivery btn btn-danger" data-toggle="modal" data-target="#myModal" data-id="' . $d['id'] . '"><i class="fa fa-trash"> Delete</i></a>'
    ];
}

$response = [
    "draw" => $draw,
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalData,
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);