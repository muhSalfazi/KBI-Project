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

  $IdFinishingProcess = $_GET['ID'];
?>

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-bar-chart fa-fw"></i> Finishing Process</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectIdFinishingProcess=mysqli_query($mysqli, "SELECT * FROM tbl_finishing_process WHERE id_finishing = $IdFinishingProcess");
        $ResultQuerySelectIdFinishingProcess=mysqli_fetch_array($QuerySelectIdFinishingProcess);
      ?>

      <div class="modal-content" style="width:400px;">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Data Finishing Process</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/FinishingProcess_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectIdFinishingProcess['id_finishing']; ?>" />
            <div class="form-group">
                <label>Finishing Process</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-bar-chart"></i>
                    </div>
                    <input name="finishing" type="text" class="form-control" style="width:330px;" placeholder="Finishing Process" value="<?php echo $ResultQuerySelectIdFinishingProcess['finishing_process'] ?>" required="" />
                  </div>
            </div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="FinishingProcess.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
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