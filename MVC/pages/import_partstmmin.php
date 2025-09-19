<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
session_start();
include_once("../connection.php");
// session_start();
require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

$IdUser = $_SESSION["id_user"];
?>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body><br></br>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 well">

                <div class="form-group">
                    <h4>Import Master Kanban</h4>
                </div>
                <form method="post" action="ajx/import_proses_tmmin.php" enctype="multipart/form-data">

                    <div class="form-group">
                        <input type="file" name="excelfile" id="excelfile">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Upload</button>
                        <a class="btn btn-danger" href="masterpart_tmmin.php">Kembali</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>