<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("../connection.php");
session_start();
//require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

$IdUser = $_SESSION["id_user"];
$dnno = $_GET["dn_no"];
//   $cekJobNos= mysqli_query ($mysqli, "SELECT * FROM masterpart_mmki WHERE PartNo='$dnno'");
//   $resultcekJobNos=mysqli_fetch_array($cekJobNos);
//   $job_nos = $resultcekJobNos['JobNo'];
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
				});
				});
</script>";
        //header("Location: delivery_smart_process.php?dn_no=$dnno");
        //exit();
    } else if ($_GET["val"] == 'complete') {
        echo "<script type='text/javascript'>
	   $(document).ready(function() {
		   var audio = new Audio('audio/1A.wav');
						audio.play();
				swal({ 
				   title: 'Selesai',
					  type: 'success',
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
    } else if ($_GET["val"] == 'no') {
        echo "<script type='text/javascript'>
	   $(document).ready(function() {
		   var audio = new Audio('audio/2.mp3');
						audio.play();
				swal({ 
				   title: 'Data Barcode Salah',
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
    } else if ($_GET["val"] == 'noscan') {
        echo "<script type='text/javascript'>
	   $(document).ready(function() {
		   var audio = new Audio('audio/2-asli.mp3');
						audio.play();
				swal({ 
				   title: 'Selesai',
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

  <div id="main-wrapper">

    <header class="topbar">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
          <!-- This is for the sidebar toggle which is visible on mobile only -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
            <i class="ti-menu ti-close"></i>
          </a>

          <a class="navbar-brand" href="delivery_smart.php">
            <!-- Logo icon -->
            <b class="logo-icon">

            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span style="color:white;" onclick="home()" class="logo-text">

              SCAN KANBAN
            </span>
          </a>

          <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
            data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-more"></i>
          </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">

          <ul class="navbar-nav float-left mr-auto">

            <li class="nav-item dropdown mega-dropdown">
              <a class="nav-link dropdown-toggle waves-effect waves-dark label-danger" href="../index.php">
                <label class="label label-danger">Logout</label>
              </a>

        </div>
        </li></a>

        </ul>

  </div>
  </nav>
  </header>

  <div class="page-wrapper">
    <br><br><br><br>
  </div>

  <div class="card-body">
    <div class="row">


      <?php echo 'List Data Manifest ' . $dnno; ?>
    </div>
  </div>
  <div class="row">
    <!-- column -->
    <div class="col-lg-6">
      <div class="card">
        <form method="POST" action="../pages/crud/delivery_process_Add.php">
          <div class="card-body border-top">
            <div class="row">
              <div class="col-9">
                <div class="input-field m-t-0 m-b-0">
                  <input type="text" id="textarea1" name="kbndn" placeholder="Scan Barcode Kanban" class="form-control
                                    border-0" autocomplete="off" autofocus required>
                  <input type="hidden" name="dn_no" value="<?php echo $dnno ?>">

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

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <!-- title -->
          <div class="d-md-flex align-items-center">

          </div>
          <!-- title -->
        </div>
        <div class="table-responsive">
          <table class="table v-middle">
            <thead>
              <tr class="bg-light">
                <th class="border-top-0">Part No.</th>
                <th class="border-top-0">Qty Scan Label</th>
                <th class="border-top-0">Qty Scan pcs</th>
                <th class="border-top-0">Qty Manifest pcs</th>
                <th class="border-top-0">Qty Outstanding pcs</th>
              </tr>
            </thead>
            <tbody>
              <?php
                    $No = 0;

                    $QueryListMaterials1 = mysqli_query($mysqli, "
                        SELECT 
                        COALESCE(masterpart_mmki.PartNo, masterpart_adm.PartNo, masterpart_hpm.PartNo, masterpart_hino.PartNo, masterpart_tmmin.PartNo, masterpart_suzuki.PartNo) AS PartNo,
                        COALESCE(masterpart_mmki.QtyPerKbn, 0) AS QtyPerKbn_mmki,
                        COALESCE(masterpart_adm.QtyPerKbn, 0) AS QtyPerKbn_adm,
                        COALESCE(masterpart_hpm.QtyPerKbn, 0) AS QtyPerKbn_hpm,
                        COALESCE(masterpart_hino.QtyPerKbn, 0) AS QtyPerKbn_hino,
                        COALESCE(masterpart_tmmin.QtyPerKbn, 0) AS QtyPerKbn_tmmin,  
                        COALESCE(masterpart_suzuki.QtyPerKbn, 0) AS QtyPerKbn_suzuki,  
                        COUNT(*) AS total
                        FROM tbl_kbndelivery
                        LEFT JOIN masterpart_mmki ON masterpart_mmki.JobNo = tbl_kbndelivery.job_no
                        LEFT JOIN masterpart_adm ON masterpart_adm.JobNo = tbl_kbndelivery.job_no
                        LEFT JOIN masterpart_hpm ON masterpart_hpm.JobNo = tbl_kbndelivery.job_no
                        LEFT JOIN masterpart_hino ON masterpart_hino.JobNo = tbl_kbndelivery.job_no
                        LEFT JOIN masterpart_tmmin ON masterpart_tmmin.JobNo = tbl_kbndelivery.job_no
                        LEFT JOIN masterpart_suzuki ON masterpart_suzuki.JobNo = tbl_kbndelivery.job_no
                        WHERE tbl_kbndelivery.dn_no = '$dnno'
                        GROUP BY PartNo
                        ORDER BY PartNo DESC
                    ");

                    while ($row = mysqli_fetch_assoc($QueryListMaterials1)) {
                        $No++;

                        $part_no = $row['PartNo'];
                        $qty_pcs = 0; // Default jika tidak ketemu

                        // List tabel untuk cek qty_pcs
                        $delivery_tables = [
                        'tbl_deliverynote',
                        'tbl_deliveryadm',
                        'tbl_deliveryhpm',
                        'tbl_deliveryhino',
                        'tbl_deliverytmmin',
                        'tbl_deliverysuzuki'
                        ];

                        foreach ($delivery_tables as $table) {
                        $cek_qty = mysqli_query($mysqli, "SELECT qty_pcs FROM $table WHERE dn_no = '$dnno' AND customerpart_no = '$part_no' LIMIT 1");
                        if ($result = mysqli_fetch_assoc($cek_qty)) {
                            $qty_pcs = $result['qty_pcs'];
                            break;
                        }
                        }

                        // Pilih QtyPerKbn aktif
                        $qtyPerKbn = $row['QtyPerKbn_mmki'] > 0 ? $row['QtyPerKbn_mmki']
                                : ($row['QtyPerKbn_adm'] > 0 ? $row['QtyPerKbn_adm']
                                : ($row['QtyPerKbn_hpm'] > 0 ? $row['QtyPerKbn_hpm']
                                : ($row['QtyPerKbn_hino'] > 0 ? $row['QtyPerKbn_hino']
                                : ($row['QtyPerKbn_suzuki'] > 0 ? $row['QtyPerKbn_suzuki']
                                : $row['QtyPerKbn_tmmin']))));

                        // Hitung
                        $totalpcs = $row['total'] * $qtyPerKbn;
                        $outstanding = $qty_pcs - $totalpcs;
                    ?>
              <tr>
                <td class="text-center"><?php echo htmlspecialchars($part_no); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($row['total']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($totalpcs); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($qty_pcs); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($outstanding); ?></td>
              </tr>
              <?php
                    }
                ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    </br>
    <div class="table-responsive">
      <table class="table v-middle">
        <thead>
          <tr class="bg-light">
            <!-- <th class="border-top-0">No</th> -->
            <!-- <th class="border-top-0">Job No.</th> -->
            <!-- <th class="border-top-0">Seq No.</th> -->
            <th class="border-top-0">Cust. Kanban No.</th>
            <th class="border-top-0">KBI Label No.</th>
            <th class="border-top-0">Date & Time Input</th>
          </tr>
        </thead>
        <tbody>

          <?php
                    $No = 0;
                    $IdRole = 0;
                    $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbndn_no LIKE '$dnno%' ORDER BY datetime_input ASC");


                    while ($ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)) {
                        $No++;
                    ?>

          <tr>
            <!-- <td class="text-center"><?php echo $No; ?></td> -->
            <!-- <td class="text-center"><?php echo $ResultQueryListMaterials['job_no']; ?></td> -->
            <!-- <td class="text-center"><?php echo $ResultQueryListMaterials['seq_no']; ?></td> -->
            <td class="text-center"><?php echo $ResultQueryListMaterials['kbndn_no']; ?></td>
            <td class="text-center"><?php echo $ResultQueryListMaterials['kbicode']; ?></td>
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

  <div class="row">

  </div>

  <footer class="footer text-center">
    <!-- Developed by -->
    <a href="https://kyoraku.id">KBI Teknologi 2024</a>.
  </footer>

  </div>

  </div>

  <div class="chat-windows"></div>
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script>
  function home() {
    window.location = ('delivery_smart.php');
  }
  </script>
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