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
</head>

<link rel="icon" type="image/png" sizes="100px" href="gambar/kbi.png"> <!-- Menghubungkan favicon -->
<script src="../js/jquery.js"></script> <!-- Menghubungkan ke jQuery -->
<script src="../sweetalert/js/sweetalert.min.js"></script> <!-- Menghubungkan ke SweetAlert -->
<link rel="stylesheet" href="../sweetalert/css/sweetalert.css"> <!-- Menghubungkan ke CSS SweetAlert -->
<script type="text/javascript" src="../assets/DataTables/media/js/jquery.js"></script> <!-- Menghubungkan ke jQuery untuk DataTables -->
<script type="text/javascript" src="../assets/DataTables/media/js/jquery.dataTables.js"></script> <!-- Menghubungkan ke DataTables JS -->
<link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/jquery.dataTables.css"> <!-- Menghubungkan ke DataTables CSS -->
<link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/dataTables.bootstrap.css"> <!-- Menghubungkan ke DataTables Bootstrap CSS -->
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
          window.location.href = 'delivery_adm.php';
        });
      });
    </script>";
}
?>
<!-- Content -->
<div class="row">
  <!-- Title -->
  <div class="col-lg-12">
    <h1 class="page-header"><i class="fa fa-dashboard fa-fw"></i>Dashboard</h1>
  </div>
  <!-- End Title -->

  <br><br>

  <!-- ADM Table -->
  <div class="row">
    <div class="col-lg-12">
      <div>
          <h3>ADM</h3>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <?php
          // Query untuk mendapatkan jumlah total data dan data yang diupload hari ini
          $totalQuery = "SELECT COUNT(*) AS total_count FROM tbl_deliveryadm";
          $todayQuery = "SELECT COUNT(id) AS datasekarang FROM tbl_deliveryadm WHERE SUBSTR(datetime_input,1,10) = SUBSTR(NOW(),1,10)";

          $totalResult = mysqli_query($mysqli, $totalQuery);
          $todayResult = mysqli_query($mysqli, $todayQuery);

          $totalRow = mysqli_fetch_array($totalResult);
          $todayRow = mysqli_fetch_array($todayResult);
          ?>
          List All Manifest&nbsp;(Total: <?php echo $totalRow['total_count']; ?>)&nbsp;
          Upload Today: <?php echo $todayRow['datasekarang']; ?>
        </div>

        <div class="panel-body">
          <div class="tampiladm"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table -->
  
  <!-- MMKI Table -->
  <div class="row">
    <div class="col-lg-12">
      <div>
          <h3>MMKI</h3>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <?php
          // Query untuk mendapatkan jumlah total data dan data yang diupload hari ini
          $totalQuery = "SELECT COUNT(*) AS total_count FROM tbl_deliverynote";
          $todayQuery = "SELECT COUNT(id) AS datasekarang FROM tbl_deliverynote WHERE SUBSTR(datetime_input,1,10) = SUBSTR(NOW(),1,10)";

          $totalResult = mysqli_query($mysqli, $totalQuery);
          $todayResult = mysqli_query($mysqli, $todayQuery);

          $totalRow = mysqli_fetch_array($totalResult);
          $todayRow = mysqli_fetch_array($todayResult);
          ?>
          List All Manifest&nbsp;(Total: <?php echo $totalRow['total_count']; ?>)&nbsp;
          Upload Today: <?php echo $todayRow['datasekarang']; ?>
        </div>

        <div class="panel-body">
          <div class="tampilmmki"></div>
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
    // Memuat data saat halaman pertama kali dibuka
    $.ajax({
      success: function() {
        $('.tampiladm').load("ajx/view_dashboard_adm.php");
      }
    });

    $.ajax({
      success: function() {
        $('.tampilmmki').load("ajx/view_dashboard_mmki.php");
      }
    });
  });
</script>

<!-- <?php
      require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
      ?>    -->