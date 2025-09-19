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

  $IdCustomer = $_GET['ID'];
?>

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-users fa-fw""></i> Customer</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectCustomer=mysqli_query($mysqli, "SELECT * FROM tbl_customer WHERE id_customer = $IdCustomer");
        $ResultQuerySelectCustomer=mysqli_fetch_array($QuerySelectCustomer);
      ?>

      <div class="modal-content" style="width:400px;">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Data User</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/Customer_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectCustomer['id_customer']; ?>" />
            <div class="form-group">
              <label>Customer Name</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input name="customername" type="text" class="form-control" style="width:330px;" placeholder="Customer Name" value="<?php echo $ResultQuerySelectCustomer['customer_name'] ?>" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Address</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                  </div>
                  <input name="address" type="text" class="form-control" style="width:330px;" placeholder="Address" value="<?php echo $ResultQuerySelectCustomer['address'] ?>" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Contact</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input name="contact" type="text" class="form-control" style="width:330px;" placeholder="Contact" value="<?php echo $ResultQuerySelectCustomer['contact'] ?>" required="" />
                </div>
            </div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="Customer.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
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