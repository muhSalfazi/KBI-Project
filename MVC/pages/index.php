<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__) . $ds . '..') . $ds;
include_once("../connection.php");
session_start();

require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");
?>

<div class="container-fluid">
    <h2 class="page-header">OVERVIEW DELIVERY DASHBOARD HPM</h2>
    <div class="btn-group" role="group" aria-label="Pilih Sumber Data">
        <button class="btn btn-info source-btn" data-source="adm">ADM</button>
        <button class="btn btn-primary source-btn" data-source="hino">HINO</button>
        <button class="btn btn-success source-btn" data-source="hpm">HPM</button>
        <button class="btn btn-warning source-btn" data-source="suzuki">SUZUKI</button>
        <button class="btn btn-danger source-btn" data-source="tmmin">TMMIN</button>
    </div>

    <div class="form-group">
        <label for="dateFilter">Pilih Tanggal:</label>
        <input type="date" id="dateFilter" class="form-control" value="<?= date('Y-m-d') ?>">
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="statistic-box blue">
                <div class="statistic-label">Total Delivery Closed Hari Ini</div>
                <div class="statistic-number" id="totalDelivery">0</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="statistic-box purple">
                <div class="statistic-label">Jumlah Qty Terkirim</div>
                <div class="statistic-number" id="qtyTerkirim">0</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Manifest Open vs Close Per Tanggal / Vendor</h3></div>
                <div class="panel-body"><canvas id="myBarChart" width="400" height="400"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Tiket Open vs Close Hari Ini</h3></div>
                <div class="panel-body"><canvas id="myPieChart" width="400" height="400"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading"><h1 class="panel-title">List Data Open Delivery </h1></div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Delivery Date</th>
                            <th>Delivery Manifest No.</th>
                            <th>Job No.</th>
                            <th>Customer Part No.</th>
                            <th>Qty Box</th>
                            <th>Acuan Scan</th>
                            <th>Total Qty Pcs</th>
                            <th>Proses Scan</th>
                            <th>Plant</th>
                            <th>ETA</th>
                            <th>Cycle</th>
                            <th>Status</th>
                            <th>Date Input</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let pieChart, barChart;
    let currentSource = 'hpm';

    $(document).ready(function () {
        function getTodayDate() {
            const today = new Date();
            return today.toISOString().split('T')[0];
        }

        function reloadAll() {
            const status = $('#statusFilter').val() || 'Open';
            const selectedDate = $('#dateFilter').val() || getTodayDate();

            table.ajax.reload(); 
            updateChartsAndStats(status, selectedDate);
        }

        

        const ctxPie = document.getElementById('myPieChart').getContext('2d');
        pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Open', 'Close'],
                datasets: [{
                    label: 'Status',
                    data: [0, 0],
                    backgroundColor: ['#f0ad4e', '#43eb34'],
                    borderWidth: 1
                }]
            }
        });

        const ctxBar = document.getElementById('myBarChart').getContext('2d');
        barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Cycle 1', 'Cycle 2', 'Cycle 3', 'Cycle 4'],
                datasets: [
                    {
                        label: 'Open',
                        backgroundColor: '#f0ad4e' ,
                        data: [0, 0, 0, 0]
                    },
                    {
                        label: 'Close',
                        backgroundColor: '#43eb34',
                        data: [0, 0, 0, 0]
                    }
                ]
            }
        });

        const table = $('#example1').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: 'ajx/api_dashboard_hpm.php',
                type: 'POST',
                data: function (d) {
                    d.status = 'Open';
                    d.delivery_date = $('#dateFilter').val() || getTodayDate();
                    d.source = currentSource;
                }
            },
            order: [[0, 'asc']]
        });

        function updateChartsAndStats(status, date) {
            $.ajax({
                url: 'ajx/api_dashboard_hpm.php',
                type: 'POST',
                data: { status: status, delivery_date: date, chart_data: true, source: currentSource },
                dataType: 'json',
                source: currentSource,
                success: function (res) {
                console.log("Chart data response:", res);

                $('#totalDelivery').text(res.totalDelivery);
                $('#qtyTerkirim').text(res.qtyTerkirim);

                console.log('Updating pie data:', [res.pie.Open, res.pie.Close]);
                pieChart.data.datasets[0].data = [res.pie.Open, res.pie.Close];
                pieChart.update();

                console.log('Updating bar data:', res.bar);
                barChart.data.datasets[0].data = res.bar.Open;
                barChart.data.datasets[1].data = res.bar.Close;
                barChart.update();
            }

            });
        }

        $('#dateFilter').on('change', function () {
            const selectedDate = $('#dateFilter').val() || getTodayDate();
            updateChartsAndStats('Open', selectedDate);
            table.ajax.reload();
        });

        $('.source-btn').on('click', function () {
            currentSource = $(this).data('source');
            reloadAll();
        });

        const initDate = getTodayDate();
        updateChartsAndStats('Open', initDate);

        $('#totalDelivery').text(res.totalDelivery == 0 ? '0 (tidak ada Close)' : res.totalDelivery);
        $('#qtyTerkirim').text(res.qtyTerkirim == 0 ? '0 (belum ada Qty terkirim)' : res.qtyTerkirim);

    });
</script>

<?php
require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>
