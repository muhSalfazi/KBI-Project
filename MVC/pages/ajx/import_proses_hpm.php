<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../sweetalert/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
<?php
session_start();
$IdUser = $_SESSION["id_user"];
//tambahan kode untuk kembali kehalaman index
$linkkembali = " <hr> <a class='btn btn-danger' href='masterpart_hpm.php'>Kembali</a>";

//kedua baris kode dibawah untuk membaca file excel jangan dihapus
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

//kedua baris dibawah untuk menghubungkan kedatabase dan melakukan autoload
require_once('../../connection.php');
require_once('../Spout/Autoloader/autoload.php');

if (!empty($_FILES['excelfile']['name'])) {
  // Get File extension eg. 'xlsx' to check file is excel sheet
  $pathinfo = pathinfo($_FILES['excelfile']['name']);

  // check file has extension xlsx, xls and also check
  // file is not empty
  if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
    && $_FILES['excelfile']['size'] > 0
  ) {
    $file = $_FILES['excelfile']['tmp_name'];

    // Read excel file by using ReadFactory object.
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

          $a  = $row[0];
          $b  = $row[1];
          $c  = $row[2];
          $d  = $row[3];
          $e  = $row[4];
          // $f  = $row[5];
          // $g  = $row[6];
          // $h  = $row[7];
          // $i  = $row[8];

          //insert data setiap baris kedalam database
          $sql = "INSERT INTO masterpart_hpm (InvId,PartName,PartNo,JobNo,QtyPerKbn, user) 
                                VALUES ('$a','$c', '$b', '$d', '$e', '$IdUser' )";
          $query = mysqli_query($mysqli, $sql);
        }
        $count++;
      }
    }

    // Check if any row was successfully inserted
    if ($query) {
      header("Location: ../masterpart_hpm.php");
      exit();
    } else {
      echo "File gagal diupload";
      echo $linkkembali;
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