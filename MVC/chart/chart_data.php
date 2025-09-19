<?php
include_once("../../connection.php");

header('Content-Type: application/json');

// Ambil parameter dari POST
$delivery_date = isset($_POST['delivery_date']) ? $_POST['delivery_date'] : date('Y-m-d');

// Format untuk mencocokkan dengan `tanggal_order` yang bertipe VARCHAR dan format DD-MM-YYYY
$delivery_date_formatted = date('d-m-Y', strtotime($delivery_date));

// PIE CHART — Hitung status Open vs Close berdasarkan tanggal_order
$queryOpenClose = "
    SELECT status, COUNT(*) as total 
    FROM tbl_deliveryhpm 
    WHERE STR_TO_DATE(tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$delivery_date_formatted', '%d-%m-%Y')
    GROUP BY status
";
$result_today = mysqli_query($mysqli, $queryOpenClose);
$chart_pie = ['Open' => 0, 'Close' => 0];
while ($row = mysqli_fetch_assoc($result_today)) {
    $status = $row['status'];
    if (isset($chart_pie[$status])) {
        $chart_pie[$status] = (int)$row['total'];
    }
}

// BAR CHART — Open & Close per cycle (1–4) berdasarkan tanggal_order
$queryCycleCount = "
    SELECT cycle, status, COUNT(*) as jumlah
    FROM tbl_deliveryhpm
    WHERE STR_TO_DATE(tanggal_order, '%d-%m-%Y') = STR_TO_DATE('$delivery_date_formatted', '%d-%m-%Y')
      AND status IN ('Open', 'Close')
    GROUP BY cycle, status
";

$result_cycle = mysqli_query($mysqli, $queryCycleCount);
$chart_bar = [
    'Open' => [0, 0, 0, 0],
    'Close' => [0, 0, 0, 0]
];
while ($row = mysqli_fetch_assoc($result_cycle)) {
    $cycle = (int)$row['cycle'];
    $status = $row['status'];
    $jumlah = (int)$row['jumlah'];
    $index = $cycle - 1;
    if ($cycle >= 1 && $cycle <= 4 && isset($chart_bar[$status][$index])) {
        $chart_bar[$status][$index] = $jumlah;
    }
}

// Output JSON response
echo json_encode([
    'pie' => $chart_pie,
    'bar' => $chart_bar
]);
