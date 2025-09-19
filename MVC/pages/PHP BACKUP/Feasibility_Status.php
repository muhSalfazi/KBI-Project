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

<?php
if ($_GET['ID']) {
//validasi ID

  $IdFeasibility = $_GET['ID'];
?>

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-gear fa-fw""></i> Feasibility</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectFeasibility=mysqli_query($mysqli, "SELECT * FROM doc_feasibility WHERE iddoc_feasibility = $IdFeasibility");
        $ResultQuerySelectFeasibility=mysqli_fetch_array($QuerySelectFeasibility);
      ?>

      <div class="modal-content" style="width:300px;">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Status Approval</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/FeasibilityStudy_Add_Status.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectFeasibility['iddoc_feasibility']; ?>" />
            <div class="form-group">
                <div class="input-group">
                  <select style="width:260px;" name="status" class="form-control" required="">
                    <option value="" disabled selected>Select Status</option>
                    <option value="1">GOOD</option>
                    <option value="2">NG</option>
                  </select>
                </div>
            </div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="Feasibility.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- End Content -->

<?php
}
//End Validasi ID
?>   

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   