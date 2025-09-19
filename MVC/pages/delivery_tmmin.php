<?php
session_start(); // Memulai sesi
$ds = DIRECTORY_SEPARATOR; // Menentukan pemisah direktori
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds; // Menentukan direktori dasar
include_once("../connection.php"); // Menghubungkan ke file connection.php

require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php"); // Validasi pengguna

// Memasukkan header dan sidebar
require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

$IdUser = $_SESSION['id_user']; // Mendapatkan id pengguna dari sesi
?>

<head>
  <script type="text/javascript" src="../js/jquery.js"></script> <!-- Menghubungkan ke jQuery -->
  <link rel="icon" type="image/png" sizes="100px" href="gambar/kbi.png"> <!-- Menghubungkan favicon -->
  <script src="../js/jquery.js"></script> <!-- Menghubungkan ke jQuery -->
  <script src="../sweetalert/js/sweetalert.min.js"></script> <!-- Menghubungkan ke SweetAlert -->
  <link rel="stylesheet" href="../sweetalert/css/sweetalert.css"> <!-- Menghubungkan ke CSS SweetAlert -->
  <script type="text/javascript" src="../assets/DataTables/media/js/jquery.js"></script> <!-- Menghubungkan ke jQuery untuk DataTables -->
  <script type="text/javascript" src="../assets/DataTables/media/js/jquery.dataTables.js"></script> <!-- Menghubungkan ke DataTables JS -->
  <link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/jquery.dataTables.css"> <!-- Menghubungkan ke DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/dataTables.bootstrap.css"> <!-- Menghubungkan ke DataTables Bootstrap CSS -->
</head>

<?php error_reporting(0); ?> <!-- Menonaktifkan laporan kesalahan -->

<?php
// Memeriksa jika sesi alert ada dan menampilkan SweetAlert jika ada
if (isset($_SESSION['alert']) == '1') {
  unset($_SESSION['alert']);
  echo "<script type='text/javascript'>
      $(document).ready(function() {
        var audio = new Audio('audio/3.mp3');
        audio.play();
        swal({ 
          title: 'Data Sudah Ada',
          type: 'error',
          showCancelButton: false,
          showConfirmButton: true 
        },
        function(){
          window.location.href = 'delivery_tmmin.php';
        });
      });
    </script>";
}
?>

<?php
if ($_GET["val"] == 'ok') {
  echo "<script type='text/javascript'>
        $(document).ready(function() {
          var audio = new Audio('audio/1.wav');
                audio.play();
            swal({ 
              title: 'Data berhasil diupload',
                type: 'success',
                timer: 1000,
                showCancelButton: false,
                showConfirmButton: true 
              },
              function(){
              swal.close();
            });
            });
    </script>";
} else if (isset($_GET["val"]) == 'no') {
  echo "<script type='text/javascript'>
 $(document).ready(function() {
     var audio = new Audio('audio/2-asli.mp3');
                  audio.play();
          swal({ 
             title: 'Data Sudah Ada',
                type: 'error',
                timer: 1000,
                showCancelButton: false,
                showConfirmButton: true 
            },
            function(){
                swal.close(); 
              //window.location.href = 'delivery_smart.php';
          });
          });
</script>
";
}
?>

<!-- Content -->
<div class="row">
  <!-- Title -->
  <div class="col-lg-12">
    <h1 class="page-header"><i class="fa fa-truck fa-fw"></i>Delivery TMMIN</h1>
  </div>
  <!-- End Title -->

  <br><br>

  <!-- Table -->
  <div class="row">
    <div class="col-lg-12">
      <!-- Tombol untuk tambah dan upload data manifest -->
      <a id="admin" class='tambah_delivery btn btn-primary btn-sm' data-toggle="modal" data-target="#myModal">
        <i class='fa fa-plus'></i>&ensp;Add Manifest
      </a>
      <a id="admin" href="import_delivery_tmmin.php" class='btn btn-primary btn-sm'>
        <i class='fa fa-download'></i>&ensp;Import Manifest
      </a>
      <!-- Tombol untuk export seluruh data manifest ke Excel -->
      <a id="exportButton" data-id="<?php echo $d['id']; ?>" href="export_all_delivery_tmmin.php" class="btn btn-success btn-sm">
        <i class='fa fa-upload'></i>&ensp;Export Manifest
      </a>
      <br></br>

      <div class="panel panel-default">
        <div class="panel-heading">
          <?php
          // Query untuk mendapatkan jumlah total data dan data yang diupload hari ini
          $totalQuery = "SELECT COUNT(*) AS total_count FROM tbl_deliverytmmin";
          $todayQuery = "SELECT COUNT(id) AS datasekarang FROM tbl_deliverytmmin WHERE SUBSTR(datetime_input,1,10) = SUBSTR(NOW(),1,10)";

          $totalResult = mysqli_query($mysqli, $totalQuery);
          $todayResult = mysqli_query($mysqli, $todayQuery);

          $totalRow = mysqli_fetch_array($totalResult);
          $todayRow = mysqli_fetch_array($todayResult);
          ?>
          List All Data Part&nbsp;(Total: <?php echo $totalRow['total_count']; ?>)&nbsp;
          Upload Today: <?php echo $todayRow['datasekarang']; ?>
        </div>

        <div class="panel-body">
          <!-- Dropdown filter by Status -->
          <div class="form-group">
            <label for="statusFilter">Filter by Status:</label>
            <select id="statusFilter" class="form-control" style="width: 100px;">
              <option value="">All</option>
              <option value="Open">Open</option>
              <option value="Close">Close</option>
            </select>
          </div>
          <div class="tampildata"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table -->
</div>
<!-- End Content -->

<br>

<!-- <footer class="main-footer text-center">
  <div class="pull-left">
    <strong> <a href="http://kyoraku.id/" target="_blank">KBI teknologi-2024</a></strong>
  </div>
</footer> -->

<script type="text/javascript">
  $(document).ready(function() {

  function loadData(status = '') {
      $.ajax({
          url: 'ajx/view_delivery_tmmin.php',
          type: 'POST',
          data: { status: status },
          success: function(data) {
              $('.tampildata').html(data);
          }
      });
  }

  $('#statusFilter').change(function() {
      var status = $(this).val();
      loadData(status);

      var exportButton = document.getElementById('exportButton');
      var baseUrl = 'export_all_delivery_data.php';
      exportButton.href = status ? baseUrl + '?status=' + encodeURIComponent(status) : baseUrl;
  });

  loadData();
  });
</script>

<!-- <?php
      require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
      ?>    -->