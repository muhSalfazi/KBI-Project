<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../sweetalert/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
<?php
session_start();
$IdUser = $_SESSION["id_user"];
//tambahan kode untuk kembali kehalaman index
$linkkembali = " <hr> <a class='btn btn-danger' href='delivery_hino.php'>Kembali</a>";

//kedua baris kode dibawah untuk membaca file excel jangan dihapus
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

//kedua baris dibawah untuk menghubungkan kedatabase dan melakukan autoload
require_once('../../connection.php');
require_once('../Spout/Autoloader/autoload.php');

if (!empty($_FILES['excelfile']['name'])) {
  $pathinfo = pathinfo($_FILES['excelfile']['name']);

  if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls') && $_FILES['excelfile']['size'] > 0) {
    $file = $_FILES['excelfile']['tmp_name'];

    $reader = ReaderFactory::create(Type::XLSX);
    $reader->open($file);
    $count = 0;

    // Initialize $query to prevent "undefined variable" warning
    $query = false;

    foreach ($reader->getSheetIterator() as $sheet) {
      foreach ($sheet->getRowIterator() as $row) {
        if ($count > 0) {
          if (empty(array_filter($row))) {
            continue;
          }

          // Pastikan kolom-kolom di Excel terdefinisi dengan benar
          $a  = isset($row[0]) ? $row[0] : ''; // dn_no
          $b  = isset($row[1]) ? $row[1] : ''; // job_no
          $c  = isset($row[2]) ? $row[2] : ''; // customerpart_no
          $d  = isset($row[3]) ? $row[3] : ''; // qty_pcs
          $e  = isset($row[4]) ? $row[4] : ''; // tanggal_order
          $f  = isset($row[5]) ? $row[5] : ''; // plan
          $g  = isset($row[6]) ? $row[6] : ''; // cycle
          $h  = isset($row[7]) ? $row[7] : ''; // ETA

          // Tangani nilai kosong pada kolom ETA
          if ($h == '') {
            $h = NULL; // Jika kosong, bisa diset ke NULL
          }

          $Q = mysqli_query($mysqli, "SELECT * FROM tbl_deliverynote WHERE dn_no='$a' AND job_no='$b'");
          $R = mysqli_fetch_array($Q);

          if ($R) {
            echo "<script>
                        $(document).ready(function() {
                            // var audio = new Audio('audio/3.mp3');
                            // audio.play();
                            swal({ 
                                title: 'Data Duplicate',
                                type: 'error',
                                showCancelButton: false,
                                showConfirmButton: true 
                            },
                            function(){
                                window.location.href = 'import_delivery_hino.php';
                            });
                        });
                        </script>";
          } else if ($a == '' || $b == '' || $c == '' || $d == '' || $e == '') {
            echo "<script>
                        $(document).ready(function() {
                            // var audio = new Audio('audio/3.mp3');
                            // audio.play();
                            swal({ 
                                title: 'Data Tidak Boleh Ada yang Kosong',
                                type: 'error',
                                showCancelButton: false,
                                showConfirmButton: true 
                            },
                            function(){
                                window.location.href = 'import_delivery_hino.php';
                            });
                        });
                        </script>";
          } else {
            // Insert data into the database
            $sql = "INSERT INTO tbl_deliveryhino (dn_no, job_no, customerpart_no, qty_pcs, tanggal_order, plan, cycle, ETA, user) 
                                VALUES ('$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h', $IdUser)";
            $query = mysqli_query($mysqli, $sql); // Assign result to $query
          }
        }
        $count++;
      }
    }

    // Check if any row was successfully inserted
    if ($query) {
      header("Location: ../delivery_hino.php?val=ok");
      exit();
    } else {
      header("Location: ../delivery_hino.php?val=no");
      exit();
    }

    $reader->close();
  } else {
    echo "Hanya file excel yang dapat diupload";
    echo $linkkembali;
  }
} else {
  echo "File kosong" . "<br>";
  echo "Silahkan masukan/upload file excel";
  echo $linkkembali;
}


?>