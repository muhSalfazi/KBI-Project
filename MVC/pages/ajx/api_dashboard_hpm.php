<?php
include_once("../../connection.php");

$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = $_POST['search']['value'] ?? '';
$status = $_POST['status'] ?? 'Open';
$deliveryDate = $_POST['delivery_date'] ?? date('Y-m-d');

// Konversi ke format tanggal_order (d-m-Y)
$dateFilter = date('d-m-Y', strtotime($deliveryDate));

$source = isset($_POST['source']) ? $_POST['source'] : 'hpm';

$source_table_map = [
    'adm' => 'tbl_deliveryadm',
    'hino'  => 'tbl_deliveryhino',
    'hpm'   => 'tbl_deliveryhpm',
    'suzuki' => 'tbl_deliverysuzuki',
    'tmmin' => 'tbl_deliverytmmin',
];

$table_name = isset($source_table_map[$source]) ? $source_table_map[$source] : 'tbl_deliveryhpm';

$whereClauses = ["STR_TO_DATE(a.tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$dateFilter', '%d-%m-%Y')"];
if ($status) {
    $whereClauses[] = "a.status = '" . mysqli_real_escape_string($mysqli, $status) . "'";
}
if ($searchValue !== '') {
    $escaped = mysqli_real_escape_string($mysqli, $searchValue);
    $whereClauses[] = "(
        a.dn_no LIKE '%$escaped%' OR a.job_no LIKE '%$escaped%' OR
        a.customerpart_no LIKE '%$escaped%' OR b.PartName LIKE '%$escaped%'
    )";
}
$whereSql = (!empty($whereClauses)) ? "WHERE " . implode(' AND ', $whereClauses) : '';

// ======== Jika hanya butuh chart/statistik =======
if (isset($_POST['chart_data']) && $_POST['chart_data'] == true) {
    header('Content-Type: application/json');

    // Ambil nilai sumber (vendor)
    $sourcechart = $_POST['source'] ?? 'hpm';
    $source_chart_map = [
        'adm' => 'tbl_deliveryadm',
        'hino'  => 'tbl_deliveryhino',
        'hpm'   => 'tbl_deliveryhpm',
        'suzuki' => 'tbl_deliverysuzuki',
        'tmmin' => 'tbl_deliverytmmin',
    ];
    $table_namechart = $source_table_map[$source] ?? 'tbl_deliveryhpm';

    $deliveryDate = $_POST['delivery_date'] ?? date('Y-m-d');
    $dateFilter = date('d-m-Y', strtotime($deliveryDate));

    // Total Delivery Closed
    $q1 = "SELECT COUNT(*) as total_delivery 
           FROM $table_namechart 
           WHERE status = 'Close' 
           AND STR_TO_DATE(tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$dateFilter', '%d-%m-%Y')";
    $r1 = mysqli_query($mysqli, $q1);
    $totalDelivery = mysqli_fetch_assoc($r1)['total_delivery'] ?? 0;

    // Qty Terkirim
    $q2 = "SELECT SUM(qty_pcs) as total_qty_terkirim 
           FROM $table_namechart 
           WHERE status = 'Close' 
           AND STR_TO_DATE(tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$dateFilter', '%d-%m-%Y')";
    $r2 = mysqli_query($mysqli, $q2);
    $totalQtyTerkirim = mysqli_fetch_assoc($r2)['total_qty_terkirim'] ?? 0;

    // Chart Pie (Open vs Close)
    $q3 = "SELECT status, COUNT(*) as total 
           FROM $table_namechart 
           WHERE STR_TO_DATE(tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$dateFilter', '%d-%m-%Y') 
           GROUP BY status";
    $r3 = mysqli_query($mysqli, $q3);
    $chart_pie = ['Open' => 0, 'Close' => 0];
    while ($row = mysqli_fetch_assoc($r3)) {
        $chart_pie[$row['status']] = (int)$row['total'];
    }

    // Chart Bar (Cycle 1-4)
    $q4 = "SELECT cycle, status, COUNT(*) as jumlah 
           FROM $table_namechart 
           WHERE STR_TO_DATE(tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$dateFilter', '%d-%m-%Y') 
           AND status IN ('Open', 'Close') 
           GROUP BY cycle, status";
    $r4 = mysqli_query($mysqli, $q4);
    $chart_bar = [
        'Open' => [0, 0, 0, 0],
        'Close' => [0, 0, 0, 0]
    ];
    while ($row = mysqli_fetch_assoc($r4)) {
        $idx = (int)$row['cycle'] - 1;
        if (isset($chart_bar[$row['status']][$idx])) {
            $chart_bar[$row['status']][$idx] = (int)$row['jumlah'];
        }
    }

    echo json_encode([
        'totalDelivery' => $totalDelivery,
        'qtyTerkirim' => $totalQtyTerkirim,
        'pie' => $chart_pie,
        'bar' => $chart_bar
    ]);
    exit;
}


// ======== Jika untuk DataTable ========
$totalQuery = "SELECT COUNT(*) as total FROM $table_name a LEFT JOIN masterpart_hpm b ON a.job_no = b.JobNo $whereSql";
$totalResult = mysqli_query($mysqli, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult)['total'] ?? 0;

$mainQuery = "
    SELECT a.id, a.dn_no, a.job_no, a.customerpart_no, a.qty_pcs,
        ROUND(a.qty_pcs / b.QtyPerKbn) AS sequence_hpm,
        b.QtyPerKbn AS qty_hpm,
        (SELECT COUNT(*) FROM $table_name c WHERE c.dn_no = a.dn_no AND c.job_no = a.job_no) AS countp,
        a.status, a.plan, a.cycle, a.tanggal_order, a.datetime_input, a.ETA
    FROM $table_name a
    LEFT JOIN masterpart_hpm b ON a.job_no = b.JobNo
    $whereSql
    ORDER BY a.id DESC
    LIMIT {$start}, {$length}
";

$result = mysqli_query($mysqli, $mainQuery);
$data = [];
$no = $start + 1;

while ($d = mysqli_fetch_assoc($result)) {
    $statusLabel = ($d['sequence_hpm'] == $d['countp']) ? '<label style="color:red;">Close</label>' : '<label>' . $d['status'] . '</label>';
    $deliveryDate = '-';
    if ($d['tanggal_order']) {
        $dt = DateTime::createFromFormat('d-m-Y', $d['tanggal_order']);
        if ($dt) $deliveryDate = $dt->format('d-M-Y');
    }

    $data[] = [
        $no++,
        $deliveryDate,
        $d['dn_no'],
        $d['job_no'],
        $d['customerpart_no'],
        $d['qty_hpm'],
        $d['sequence_hpm'],
        $d['qty_pcs'],
        $d['countp'],
        $d['plan'],
        $d['ETA'],
        $d['cycle'],
        $statusLabel,
        $d['datetime_input']
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
