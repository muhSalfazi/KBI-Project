<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("../connection.php");
session_start();
//require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");
$IdUser = $_SESSION["id_user"];
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="100px" href="gambar/kbi.png">
  <title>Scan Barcode Delivery</title>
  <!-- Custom CSS -->
  <link href="../frame/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
  <link href="../frame/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
  <link href="../frame/assets/libs/morris.js/morris.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="../frame/dist/css/style.min.css" rel="stylesheet">
  <!-- SweetAlert -->
  <script src="../js/jquery.js"></script>
  <script src="../sweetalert/js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
</head>

<body>
  <?php
    if (isset($_GET["val"]) == 'no') {
        echo "<script type='text/javascript'>
       $(document).ready(function() {
           var audio = new Audio('audio/2-asli.mp3');
                        audio.play();
                swal({ 
                   title: 'PO tidak ditemukan',
                      type: 'error',
                      timer: 1500,
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
    } else if (isset($_GET["val"]) == 'dn') {
        echo "<script type='text/javascript'>
       $(document).ready(function() {
           var audio = new Audio('audio/2.mp3');
                        audio.play();
                swal({ 
                   title: 'Data Tidak Ada di Master',
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
    } else if (isset($_GET["val"]) == 'scan') {
        echo "<script type='text/javascript'>
       $(document).ready(function() {
           var audio = new Audio('audio/2.mp3');
                        audio.play();
                swal({ 
                   title: 'Silahkan Scan DN',
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
    } else if (isset($_GET["val"]) == 'complete') {
        echo "<script type='text/javascript'>
       $(document).ready(function() {
           var audio = new Audio('audio/2-asli.mp3');
                        audio.play();
                swal({ 
                   title: 'Delivery Close',
                      type: 'error',
                      timer: 1500,
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

  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
          <!-- This is for the sidebar toggle which is visible on mobile only -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
            <!-- <i class="ti-menu ti-close"></i> -->
            <i>
              <img src="../pages/gambar/kbi.png" size="10%" alt="">
            </i>
          </a>
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <a class="navbar-brand" href="delivery_smart.php">
            <!-- Logo icon -->
            <b class="logo-icon">

            </b>
            <!--End Logo icon -->
            <!-- Logo text -->

            <!-- <span  class="logo-text">             -->
            SCAN PO/DN
            <!-- </span> -->

          </a>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Toggle which is visible on mobile only -->
          <!-- ============================================================== -->
          <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
            data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-power-off" aria-hidden="true"></i>
          </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav float-left mr-auto">

            <!-- ============================================================== -->
            <!-- mega menu -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown mega-dropdown">
              <a class="nav-link dropdown-toggle waves-effect waves-dark label-warning" href="../index.php">
                <label class="label label-warning">Logout</label>
              </a>

        </div>
        </li>
        <!-- ============================================================== -->
        <!-- End mega menu -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Comment -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Messages -->
        <!-- ============================================================== -->


        </ul>
        <!-- ============================================================== -->
        <!-- Right side toggle and nav items -->
        <!-- ============================================================== -->

  </div>
  </nav>
  </header>

  <div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <br><br><br><br>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->




  </div>
  <!-- ============================================================== -->
  <!-- Info box Scan QR Code Kanban-->
  <!-- ============================================================== -->

  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <form method="POST" action="delivery_selectdn.php">
          <div class="card-body border-top">
            <div class="row">
              <div class="col-9">
                <div class="input-field mt-0 mb-0">
                  <input type="text" id="textarea1" name="dnno" placeholder="Scan Barcode/QR MANIFEST" class="form-control
                                    border-0" autocomplete="off" autofocus="autofocus" required>
                </div>
              </div>
              <div class="col-3">
                <button name="submit" style="border:none; background:none;">
                  <a class="btn-circle btn-lg btn-success float-right text-white">
                    <i class="fas fa-paper-plane"></i>
                  </a>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Info box Scan QR Code Kanban-->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Table DATA DN  2 HARI-->
  <!-- ============================================================== -->
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <?php
                    $ayeuna = date('Y-m-d h:m:s');
                    $nows = strtotime(date('Y-m-d h:m:s'));
                    $kamari = date('Y-m-d h:m:s', strtotime('-1 day', $nows));
                    $QueryListMaterials = mysqli_query($mysqli, "SELECT
                            *,
                            (SELECT COUNT(tbl_deliverynote.id)
                            FROM tbl_deliverynote
                            WHERE (STATUS = 'Open' OR STATUS = 'Process')
                                AND (tbl_deliverynote.datetime_input BETWEEN '$kamari' and '$ayeuna')) AS cnt,
                            
                            -- Menghitung qty_boxdn dari masterpart_mmki
                            CAST(tbl_deliverynote.qty_pcs / masterpart_mmki.qtyperkbn AS UNSIGNED) AS qty_boxdn_mmki,
                            
                            -- Menghitung qty_boxdn dari masterpart_adm
                            CAST(tbl_deliverynote.qty_pcs / masterpart_adm.qtyperkbn AS UNSIGNED) AS qty_boxdn_adm
                            
                            FROM tbl_deliverynote
                            -- Inner join dengan masterpart_mmki
                            INNER JOIN masterpart_mmki
                                ON masterpart_mmki.JobNo = tbl_deliverynote.job_no
                                
                            -- Inner join dengan masterpart_adm
                            INNER JOIN masterpart_adm
                                ON masterpart_adm.JobNo = tbl_deliverynote.job_no
                                
                            WHERE (STATUS = 'Open' OR STATUS = 'Process')
                            AND (tbl_deliverynote.datetime_input BETWEEN '$kamari' and '$ayeuna')
                            ORDER BY tbl_deliverynote.id DESC");
                    $R = mysqli_fetch_array($QueryListMaterials);
                    ?>
          <!-- title  Count : <?php echo $R['cnt']; ?>-->
          <div class="d-md-flex align-items-center">

          </div>
          <!-- title -->
        </div>
        <div class="table-responsive">
          <table class="table v-middle">
            <thead>
              <tr class="bg-light">
                <!-- <th class="border-top-0">Status</th> -->
                <th style="display: none;"><?php echo '$ayeuna $kamari'; ?> </th>
                <th class="border-top-0 text-center">Delivery Date</th>
                <th class="border-top-0 text-center">Manifest No.</th>
                <th class="border-top-0 text-center">Qty Pcs.</th>
                <th class="border-top-0 text-center">Qty Box.</th>
                <th class="border-top-0 text-center">job No.</th>
                <th class="border-top-0 text-center">Customer Part No.</th>
              </tr>
            </thead>
            <tbody>
              <?php
                            $No = 0;
                            $IdRole = 0;

                            while ($ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)) {
                                $No++;
                            ?>
              <tr>
                <!--  <td class="text-center"><?php echo $ResultQueryListMaterials['status']; ?></td> -->
                <td class="text-center"><?php echo $ResultQueryListMaterials['tanggal_order']; ?></td>
                <td class="text-center"><?php echo $ResultQueryListMaterials['dn_no']; ?></td>
                <td class="text-center"><?php echo $ResultQueryListMaterials['qty_pcs']; ?></td>
                <td class="text-center">
                  <?php
                                        // Memeriksa apakah qty_boxdn_mmki ada dan lebih besar dari 0
                                        if (!empty($ResultQueryListMaterials['qty_boxdn_mmki']) && $ResultQueryListMaterials['qty_boxdn_mmki'] > 0) {
                                            echo $ResultQueryListMaterials['qty_boxdn_mmki'];
                                        } else if (!empty($ResultQueryListMaterials['qty_boxdn_adm']) && $ResultQueryListMaterials['qty_boxdn_adm'] > 0) {
                                            // Jika qty_boxdn_mmki tidak ada, menampilkan qty_boxdn_adm
                                            echo $ResultQueryListMaterials['qty_boxdn_adm'];
                                        } else {
                                            // Jika tidak ada data dari kedua kolom
                                            echo 'N/A';
                                        }
                                        ?>
                </td>
                <td class="text-center"><?php echo $ResultQueryListMaterials['job_no']; ?></td>
                <td class="text-center"><?php echo $ResultQueryListMaterials['customerpart_no']; ?></td>
              </tr>

              <?php
                            }
                            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- TABLE DATA DN 2 HARI -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Table -->
  <!-- ============================================================== -->
  <div class="row">
    <!-- Column -->

    <!-- Column -->

    <!-- ============================================================== -->
    <!-- Table -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Container fluid  -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- footer -->
  <!-- ============================================================== -->
  <footer class="footer text-center">
    <!-- Developed by -->
    <a href="https://kyoraku.id">KBI Teknologi - 2024</a>.
  </footer>
  <!-- ============================================================== -->
  <!-- End footer -->
  <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Page wrapper  -->
  <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- customizer Panel -->
  <!-- ============================================================== -->

  <div class="chat-windows"></div>
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="../frame/assets/libs/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="../frame/assets/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="../frame/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- apps -->
  <script src="../frame/dist/js/app.min.js"></script>
  <script src="../frame/dist/js/app.init.dark.js"></script>
  <script src="../frame/dist/js/app-style-switcher.js"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="../frame/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
  <script src="../frame/assets/extra-libs/sparkline/sparkline.js"></script>
  <!--Wave Effects -->
  <script src="../frame/dist/js/waves.js"></script>
  <!--Menu sidebar -->
  <script src="../frame/dist/js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="../frame/dist/js/custom.min.js"></script>
  <!--This page JavaScript -->
  <!--chartis chart-->
  <script src="../frame/assets/libs/chartist/dist/chartist.min.js"></script>
  <script src="../frame/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

  <!--chartjs -->
  <script src="../frame/assets/libs/raphael/raphael.min.js"></script>
  <script src="../frame/assets/libs/morris.js/morris.min.js"></script>

  <script src="../frame/dist/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>