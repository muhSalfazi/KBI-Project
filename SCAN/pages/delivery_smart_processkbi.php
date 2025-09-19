<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("../connection.php");
session_start();
//require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

$IdUser = $_SESSION["id_user"];
// $kbndn = $_GET["kbndn"];
// $dndrkbndn = substr($_GET['kbndn'], 0, 10);
// $job_no = substr($_GET['kbndn'], 10, 4);
// $seq_no = substr($_GET['kbndn'], 14, 3);

// Pastikan `kbndn` ada di URL
if (isset($_GET["kbndn"])) {
    $kbndn = $_GET["kbndn"];
    $kbndn_length = strlen($kbndn);

    if ($kbndn_length == 17) {
        // Jika panjang kbndn adalah 17 (MMKI)
        $dndrkbndn = substr($kbndn, 0, 10);
        $job_no = substr($kbndn, 10, 4);
        $seq_no = substr($kbndn, 14, 3);
    } elseif ($kbndn_length == 26) {
        // Jika panjang kbndn adalah 26 (ADM KAP)
        $dndrkbndn = substr($kbndn, 0, 16);
        $job_no = substr($kbndn, 16, 7);
        $seq_no = substr($kbndn, 23, 3);
    } elseif ($kbndn_length == 29) {
        // Jika panjang kbndn adalah 29 (ADM SAP dan HPM)
        $dndrkbndn = substr($kbndn, 0, 16);
        $job_no = substr($kbndn, 16, 7);
        $seq_no = substr($kbndn, 23, 6);    
    } elseif ($kbndn_length == 21) {
        // SUZUKI
        $dndrkbndn = substr($kbndn, 0, 15);   
        $job_no = substr($kbndn, 15, 3);      
        $seq_no = substr($kbndn, 18, 3);      
    } else {
        // Tangani kasus jika panjang kbndn tidak sesuai
        $dndrkbndn = '';
        $job_no = '';
        $seq_no = '';
    }
} else {
    // Tangani kasus ketika `kbndn` tidak ada di URL
    $kbndn = '';
    $dndrkbndn = '';
    $job_no = '';
    $seq_no = '';
}


// echo "user = ".$IdUser." <br/>";
// echo "kbndn = ".$kbndn." <br/>";
// echo "job_no = ".$job_no." <br/>";
// echo "seq_no = ".$seq_no." <br/>";
// echo "dndrkbndn = ".$dndrkbndn." <br/>";
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
  <title>MANIFEST Process</title>
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
    if ($_GET["val"] == 'ok') {
        echo "<script type='text/javascript'>
	   $(document).ready(function() {
		   var audio = new Audio('audio/1.wav');
						audio.play();
				swal({ 
				   title: 'OK',
					  type: 'success',
					  timer: 1000,
					  showCancelButton: false,
					  showConfirmButton: true 
				  },
				  function(){
					 swal.close(); 
					//window.location.href = 'masterkanban.php';
				});
				});
</script>";
        //header("Location: delivery_smart_process.php?dn_no=$dnno");
        //exit();
    } else if ($_GET["val"] == 'no') {
        echo "<script type='text/javascript'>
	   $(document).ready(function() {
		   var audio = new Audio('audio/2.mp3');
						audio.play();
				swal({ 
				   title: '',
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
            <i class="ti-menu ti-close"></i>
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
            <span class="logo-text">

              Label KBI Validation
            </span>
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
            <i class="ti-more"></i>
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
              <a class="nav-link dropdown-toggle waves-effect waves-dark label-danger" href="../index.php">
                <label class="label label-danger">Logout</label>
              </a>

        </div>
        </li>
        <!-- ============================================================== -->
        <!-- End mega menu -->
        <!-- ============================================================== -->
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
  <!-- Info box -->
  <!-- ============================================================== -->
  <div class="card-group">



  </div>
  <!-- ============================================================== -->
  <!-- Info box -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Email campaign chart -->
  <!-- ============================================================== -->

  <div class="row">

    <!-- column -->

    <!-- column -->
    <div class="col-lg-6">
      <div class="card">
        <form method="POST" action="../pages/crud/delivery_processkbi_Add.php">
          <div class="card-body border-top">
            <div class="row">
              <div class="col-9">
                <div class="input-field m-t-0 m-b-0">
                  <input type="text" id="textarea1" name="kbndnkbi" placeholder="Scan Label-KBI" class="form-control
                                    border-0" autocomplete="off" autofocus required>
                  <input type="hidden" name="job_no" value="<?php echo $job_no ?>">
                  <input type="hidden" name="kbndn" value="<?php echo $kbndn ?>">
                  <input type="hidden" name="dn" value="<?php echo $dndrkbndn ?>">
                </div>
              </div>
              <div class="col-3">
                <button name="submit" style="border:none; background:none;"><a
                    class="btn-circle btn-lg btn-cyan float-right text-white">
                    <i class="fas fa-paper-plane"></i>
                  </a></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>

  <!-- ============================================================== -->
  <!-- Email campaign chart -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Top Selliing Products -->
  <!-- ============================================================== -->

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <!-- title --><?php echo 'List Data Scan ' . $job_no; ?>
          <div class="d-md-flex align-items-center">

          </div>
          <!-- title -->
        </div>
        <div class="table-responsive">
          <table class="table v-middle">
            <thead>
              <tr class="bg-light">
                <th class="border-top-0">No</th>
                <th class="border-top-0">Uniq No.</th>
                <th class="border-top-0">Qty Scan</th>

              </tr>
            </thead>
            <tbody>
              <?php
                            $No = 0;
                            $IdRole = 0;
                            $QueryListMaterials1 = mysqli_query($mysqli, "SELECT *, COUNT( * ) AS total FROM tbl_kbndelivery WHERE kbndn_no LIKE '$dndrkbndn%' AND job_no = '$job_no' GROUP BY job_no");

                            while ($ResultQueryListMaterials1 = mysqli_fetch_array($QueryListMaterials1)) {
                                $No++;
                            ?>

              <tr>
                <td class="text-center"><?php echo $No; ?></td>
                <td class="text-center"><?php echo $ResultQueryListMaterials1['job_no']; ?></td>
                <td class="text-center"><?php echo $ResultQueryListMaterials1['total']; ?></td>

                <?php
                            }
                                ?>
            </tbody>
          </table>
        </div </div>
      </div>
      </br>
      <div class="card-body">
        <!-- title --><?php echo 'List Data Scan ' . $dndrkbndn; ?>

        <!-- title -->
      </div>
      <div class="table-responsive">
        <table class="table v-middle">
          <thead>
            <tr class="bg-light">
              <th class="border-top-0">No</th>
              <th class="border-top-0">Uniq No.</th>
              <th class="border-top-0">Seq No.</th>
              <th class="border-top-0">Date & Time Input</th>
            </tr>
          </thead>
          <tbody>

            <?php
                        $No = 0;
                        $IdRole = 0;
                        $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbndn_no LIKE '$dndrkbndn%' AND job_no = '$job_no' ORDER BY datetime_input ASC");

                        while ($ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)) {
                            $No++;
                        ?>

            <tr>
              <td class="text-center"><?php echo $No; ?></td>
              <td class="text-center"><?php echo $ResultQueryListMaterials['job_no']; ?></td>
              <td class="text-center"><?php echo $ResultQueryListMaterials['seq_no']; ?></td>
              <td class="text-center"><?php echo $ResultQueryListMaterials['datetime_input']; ?></td>

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
  <!-- Top Selliing Products -->
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
    <a href="https://kyoraku.id">KBI Teknologi-2024</a>.
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