<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("connection.php"); // Pastikan koneksi database sudah ada
session_start();


// require_once("{$base_dir}pages{$ds}core{$ds}header.php");
// require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    
    <title>DELIVERY SYSTEM KBI</title>
    <link rel="icon" type="image/png" sizes="100px" href="../gambar/kbi.png">

    <!-- Bootstrap Core CSS -->
    <link href="MVC/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="MVC/vendor/metisMenu/metisMenu.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="MVC/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="MVC/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="MVC/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="MVC/vendor/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="MVC/vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="MVC/vendor/bootstrap/js/bootstrap.js"></script>

    <!-- Bootstrap Date Picker -->
    <link rel="stylesheet" href="MVC/vendor/datepicker/css/bootstrap-datepicker3.css" />
    <link  href="MVC/dist/css/custom-dashboard.css" rel="stylesheet"/>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand bg-success" href="MVC/">Login</a>
            </div>
            <?php
            ?>

        </nav>
    </div>

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
    
    $(document).ready(function() {
    // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
    function getTodayDate() {
        const today = new Date();
        const year = today.getFullYear();
        // getMonth() mengembalikan 0-11, jadi tambahkan 1
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Set nilai default 'Open' untuk filter status
    $('#statusFilter').val('Open');

    // Dapatkan tanggal hari ini
    const todayDate = getTodayDate();

    var table = $('#example1').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: 'MVC/pages/ajx/api_dashboard_hpm.php',
            type: 'POST',
            data: function(d) {
                // Selalu kirimkan status 'Open' secara default
                // d.status = $('#statusFilter').val() || 'Open';
                // Tambahkan filter tanggal hari ini
                d.tanggal_order = todayDate; // Mengirim tanggal hari ini
            }
        },
        order: [[0, 'asc']]
    });

    function loadData(status = 'Open', deliveryDate = todayDate) { // Tambahkan parameter deliveryDate
        $.ajax({
            url: 'MVC/pages/ajx/view_delivery_hpm.php',
            type: 'POST',
            data: { 
                status: status,
                delivery_date: deliveryDate // Kirim tanggal ke view_delivery_hpm.php
            },
            success: function(data) {
                $('.tampildata').html(data);
            }
        });
    }
    
    $('#statusFilter').change(function() {
        var status = $(this).val();
        loadData(status, todayDate); // Panggil loadData dengan status baru dan tanggal hari ini

        table.ajax.reload(); // Memuat ulang data untuk DataTables dengan filter baru

        var exportButton = document.getElementById('exportButton');
        var baseUrl = 'export_all_delivery_data.php';
        // Pastikan export button juga menyertakan filter tanggal
        exportButton.href = `${baseUrl}?status=${encodeURIComponent(status)}&delivery_date=${encodeURIComponent(todayDate)}`;
    });
    
    // Panggil loadData() pertama kali dengan status 'Open' dan tanggal hari ini
    loadData('Open', todayDate);
});
  const pieData = <?= json_encode($chart_pie); ?>;
  const barData = <?= json_encode($chart_bar); ?>;
</script>
</div>
        <!-- /#page-wrapper -->

        <br>
        <footer class="main-footer">
            <div class="text-center">
                <strong>Delivery SYSTEM <a href="http://kyoraku.id/" target="_blank">KBI-<span id="year"></span></a></strong>
            </div>
        </footer>


    </div>
        <script>
            document.getElementById("year").textContent = new Date().getFullYear();
        </script>
    <!-- /#wrapper -->

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <!-- Datepicker -->
    <script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Datetimepicker -->
    <script src="../vendor/datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

    <script>
        $(function() {
            $('#side-menu').metisMenu();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#side-menu').metisMenu({
                toggle: true,
                doubleTapToGo: true
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#side-menu li > a').on('click', function (e) {
                const $submenu = $(this).next('.nav-second-level');
                if ($submenu.length) {
                    e.preventDefault(); // cegah link default
                    $submenu.slideToggle(200); // animasi buka/tutup submenu
                    $(this).find('.fa.arrow').toggleClass('open'); // opsional: rotate arrow
                    $(this).parent().toggleClass('active');
                }
            });
        });
    </script>

    <script src="MVC/chart/chart-dashboard.js"></script>
    
    </script>        
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
