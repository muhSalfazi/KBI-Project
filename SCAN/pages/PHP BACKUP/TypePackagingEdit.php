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

  $IdTypePackaging = $_GET['ID'];
?>

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-tags fa-fw""></i> Type Packaging</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectTypePackaging=mysqli_query($mysqli, "SELECT * FROM tbl_type_packaging WHERE id_type_packaging = $IdTypePackaging");
        $ResultQuerySelectTypePackaging=mysqli_fetch_array($QuerySelectTypePackaging);
      ?>

      <div class="modal-content" style="width:400px;">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Data Type Packaging</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/TypePackaging_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectTypePackaging['id_type_packaging']; ?>" />
            <div class="form-group">
              <label>Type Packaging</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-tags"></i>
                  </div>
                  <input name="type_packaging" type="text" class="form-control" style="width:330px;" value="<?php echo $ResultQuerySelectTypePackaging['type_packaging'] ?>" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Formula Price/PC</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-edit"></i>
                  </div>
                  <input name="for_price" type="text" class="form-control" style="width:330px;" value="<?php echo $ResultQuerySelectTypePackaging['formula_price_or_pc'] ?>"/>
                </div>
            </div>
            <div class="form-group">
              <label>Formula Dep.Qty</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-edit"></i>
                  </div>
                  <input name="for_dep_qty" type="text" class="form-control" style="width:330px;" value="<?php echo $ResultQuerySelectTypePackaging['formula_dep_qty'] ?>"/>
                </div>
            </div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="TypePackaging.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
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