<?php
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");
  session_start();
  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

  require_once("{$base_dir}pages{$ds}core{$ds}header.php");
  require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

  $IdUser = $_SESSION["id_user"];
?> 

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-dashboard fa-fw"></i> Dashboard</h1>
        </div>

    </div>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   