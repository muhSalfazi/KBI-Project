<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("../connection.php"); // Pastikan koneksi database sudah ada
session_start();


require_once("{$base_dir}pages{$ds}core{$ds}header.php"); 
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

// $IdUser = $_SESSION["id_user"];
$current_date_mysql = date('Y-m-d'); 
$current_date_ddmmyyyy = date('d-m-Y');


$queryTotalDeliveryHariIni = "SELECT COUNT(*) as total_delivery
                              FROM tbl_deliveryhpm
                              WHERE status = 'Close' AND STR_TO_DATE(tanggal_order, '%d-%m-%Y') = CURDATE();";
$resultTotalDeliveryHariIni = mysqli_query($mysqli, $queryTotalDeliveryHariIni);
$totalDeliveryHariIni = 0;
if ($resultTotalDeliveryHariIni && mysqli_num_rows($resultTotalDeliveryHariIni) > 0) {
    $row = mysqli_fetch_assoc($resultTotalDeliveryHariIni);
    $totalDeliveryHariIni = $row['total_delivery'];
}


$queryQtyTerkirim = "SELECT SUM(qty_pcs) as total_qty_terkirim, SUM(qty_pcs) as total_box_terkirim
                     FROM tbl_deliveryhpm
                     WHERE status = 'Close' AND STR_TO_DATE(tanggal_order, '%d-%m-%Y') = CURDATE();";
$resultQtyTerkirim = mysqli_query($mysqli, $queryQtyTerkirim);
$totalQtyTerkirim = 0;
$totalBoxTerkirim = 0;
if ($resultQtyTerkirim && mysqli_num_rows($resultQtyTerkirim) > 0) {
    $row = mysqli_fetch_assoc($resultQtyTerkirim);
    $totalQtyTerkirim = $row['total_qty_terkirim'] ?? 0;
    $totalBoxTerkirim = $row['total_box_terkirim'] ?? 0;
}
$jumlahBoxQtyTerkirim = $totalQtyTerkirim ; 

// Ambil data Open vs Close untuk hari ini

$queryOpenClose = "SELECT status, COUNT(*) as total 
              FROM tbl_deliveryhpm 
              WHERE STR_TO_DATE(tanggal_order, '%d-%m-%Y')  = CURDATE()
              GROUP BY status";
$result_today = mysqli_query($mysqli, $queryOpenClose);
$chart_pie = ['Open' => 0, 'Close' => 0];
while ($row = mysqli_fetch_assoc($result_today)) {
    $chart_pie[$row['status']] = (int)$row['total'];
}

// Ambil data Open & Close berdasarkan cycle 1-4
$queryCycleCount = "SELECT cycle, status, COUNT(*) as jumlah
              FROM tbl_deliveryhpm
              WHERE STR_TO_DATE(tanggal_order, '%d-%m-%Y')  = CURDATE() AND status IN ('Open', 'Close')
              GROUP BY cycle, status";

$result_cycle = mysqli_query($mysqli, $queryCycleCount);

$chart_bar = [
    'Open' => [0, 0, 0, 0],
    'Close' => [0, 0, 0, 0]
];

while ($row = mysqli_fetch_assoc($result_cycle)) {
    $index = (int)$row['cycle'] - 1;
    if (isset($chart_bar[$row['status']][$index])) {
        $chart_bar[$row['status']][$index] = $row['jumlah'];
    }
}

// Ambil data Top Concerns

?>

<div class="container-fluid"> <h2 class="page-header">OVERVIEW DELIVERY DASHBOARD HPM</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="statistic-box blue">
                <div class="statistic-label">Total Delivery Closed Hari Ini</div>
                <div class="statistic-number"><?= $totalDeliveryHariIni ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="statistic-box purple">
                <div class="statistic-label">Jumlah Qty Terkirim</div>
                <div class="statistic-number"><?= $jumlahBoxQtyTerkirim ?> </div>
            </div>
        </div>

        
    </div> <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Manifest Open vs Close Per Tanggal / Vendor</h3>
                </div>
                <div class="panel-body">
                    <canvas id="myBarChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" width="600" height="600">Tiket Open vs Close Hari ini</h3>
                </div>
                <div class="panel-body">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
    </div> 
    <div class="row table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">List Data Open Delivery HPM</h1>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Delivery Date</th>
                            <th class="text-center">Delivery Manifest No.</th>
                            <th class="text-center">Job No.</th>
                            <th class="text-center">Customer Part No.</th>
                            <th class="text-center">Qty Box</th>
                            <th class="text-center">Acuan Scan</th>
                            <th class="text-center">Total Qty Pcs</th>
                            <th class="text-center">Proses Scan</th>
                            <th class="text-center">Plant</th>
                            <th class="text-center">Dlv.Time (ETA)</th>
                            <th class="text-center">Cycle</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Date Input</th>
                        </tr>
                    </thead>
                 </table> 
            <tbody>
            </tbody>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function () {
    function getTodayDate() {
        const today = new Date();
        const year = today.getFullYear();
        // getMonth() mengembalikan 0-11, jadi tambahkan 1
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    $('#statusFilter').val('Open');

    const todayDate = getTodayDate();

    const table = $('#example1').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: 'ajx/api_delivery_hpm.php',
            type: 'POST',
            data: function (d) {
                d.status = $('#statusFilter').val() || 'Open';
                d.delivery_date = $('#dateFilter').val() || getTodayDate();
                d.tanggal_order = todayDate;
            }
        },
        order: [[0, 'asc']]
    });

    function loadData(status = 'Open', deliveryDate = getTodayDate()) {
        $.ajax({
            url: 'ajx/view_delivery_hpm.php',
            type: 'POST',
            data: {
                status: status,
                delivery_date: deliveryDate
            },
            success: function (data) {
                $('.tampildata').html(data);
            }
        });
    }

    function updateCharts(status, deliveryDate) {
        $.ajax({
            url: '/chart_data.php',
            type: 'POST',
            data: {
                status: status,
                delivery_date: deliveryDate
            },
            dataType: 'json',
            success: function (response) {
                pieChart.data.datasets[0].data = [response.pie.Open, response.pie.Close];
                pieChart.update();

                barChart.data.datasets[0].data = response.bar.Open;
                barChart.data.datasets[1].data = response.bar.Close;
                barChart.update();
            }
        });
    }

    $('#statusFilter, #dateFilter').on('change', function () {
        const status = $('#statusFilter').val();
        const selectedDate = $('#dateFilter').val() || getTodayDate();

        table.ajax.reload();
        loadData(status, selectedDate);
        updateCharts(status, selectedDate);
    });

    const initDate = getTodayDate();
    loadData('Open', initDate);
    updateCharts('Open', initDate);
});

  const pieData = <?= json_encode($chart_pie); ?>;
  const barData = <?= json_encode($chart_bar); ?>;
</script>
<?php
require_once("{$base_dir}pages{$ds}core{$ds}footer.php"); 
?>