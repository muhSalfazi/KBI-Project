<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_unset();
session_start();
session_destroy();
include_once("../connection.php");

// Notif Error
$Err = "";
if (isset($_GET["Err"]) && !empty($_GET["Err"])) {
  switch ($_GET["Err"]) {
    case 1:
      $Err = "Username dan Password Kosong";
      break;
    case 2:
      $Err = "Username Kosong";
      break;
    case 3:
      $Err = "Password Kosong";
      break;
    case 4:
      $Err = "Password salah";
      break;
    case 5:
      $Err = "Username Salah";
      break;
    case 6:
      $Err = "Maaf, Terjadi Kesalahan";
      break;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SCAN</title>
  <link rel="icon" type="image/png" sizes="100px" href="gambar/kbi.png">
  <!-- Bootstrap Core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<!-- <body style="background-image: url('gambar/bg-grafik.jpg'); height: 70%;"> -->

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-primary">
          <div class="panel-heading">
            <!-- <h3 class="panel-title"><center><b>KBI WAREHOUSES SYSTEM</b></center></h3> -->

            <h3 class="panel-title">
              <center><b>SILAHKAN SCAN ID CARDMU</b></center>
            </h3>
          </div>
          <div class="panel-body">
            <form action="../pages/validate/LevelUser.php" method="post">
              <fieldset>
                <div class="form-group">
                  <input class="form-control" placeholder="Username" name="username" type="password" autofocus>
                </div>
                <!--<div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form 
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login <i class="fa fa-sign-in"></i></button>-->
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="../vendor/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="../vendor/metisMenu/metisMenu.min.js"></script>

  <!-- Custom Theme JavaScript -->
  <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>