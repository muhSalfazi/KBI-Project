<?php
session_start();
error_reporting(0);

// Ambil filter dari GET
$_SESSION['cari'] = $_GET['cari'] ?? '';
$_SESSION['date1'] = $_GET['date1'] ?? '';
$_SESSION['date2'] = $_GET['date2'] ?? '';

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__) . $ds . '..') . $ds;

// Load dependencies
include_once("../connection.php");
require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");
require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

$IdUser = $_SESSION["id_user"];
?>

<head>
    <script src="../js/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../sweetalert/js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-history fa-fw"></i> History Count Kanban</h1>
        </div>

        <div class="col-lg-12">
            <form method="get" class="form-inline">
                Scan Date:
                <input name="date1" type="date" class="form-control" value="<?= $_GET['date1'] ?? '' ?>">
                to:
                <input name="date2" type="date" class="form-control" value="<?= $_GET['date2'] ?? '' ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-lg-12 mt-3">
            <div class="panel panel-default">
                <div class="panel-heading">List Scan Data</div>
                <div class="panel-body">
                    <table id="dataTables-history" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>DN No</th>
                                <th>Part No</th>
                                <th>Sequence</th>
                                <th>Module No</th>
                                <th>Scan Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php 
        require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
    ?>

    <script>
        $(document).ready(function() {
            $('#dataTables-history').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "ajx/view_history_count.php",
                    "type": "POST",
                    "data": {
                        date1: '<?= $_SESSION['date1'] ?>',
                        date2: '<?= $_SESSION['date2'] ?>',
                        cari: '<?= $_SESSION['cari'] ?>'
                    }
                },
                "columns": [
                    { "data": "no" },
                    { "data": "dn_no" },
                    { "data": "part_no" },
                    { "data": "seq_no" },
                    { "data": "module_no" },
                    { "data": "datetime_input" }
                ]
            });
        });
    </script>
</body>
</html>
