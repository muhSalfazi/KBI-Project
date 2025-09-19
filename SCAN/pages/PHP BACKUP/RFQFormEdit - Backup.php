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

  $IdRFQForm = $_GET['ID'];
?>

    <!-- Content -->
    <div class="row">

      <!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> RFQ Form</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_color ON tbl_rfq.color = tbl_color.id_color INNER JOIN tbl_category ON tbl_rfq.category = tbl_category.id_category INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Data RFQ</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/RFQForm_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
            <input type="hidden" name="olddocument" value="<?php echo $ResultQuerySelectRFQForm['name_doc']; ?>" />
            <input type="hidden" name="oldsizedocument" value="<?php echo $ResultQuerySelectRFQForm['size_doc']; ?>" />
            <input type="hidden" name="oldpathdocument" value="<?php echo $ResultQuerySelectRFQForm['path_file']; ?>" />
            <div class="form-group">
              <div class="input-group">
                <br>
                <label style="padding-right:66px;">Issue Date</label>
                <input name="issuedate" id="issuedate" type="text" class="datepicker" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['issue_date']; ?>" placeholder="Issue Date" required="" />
                
                <label style="padding-left:30px;padding-right:30px;">End User</label>
                <input name="enduser" id="enduser" type="text" class="form-group" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['end_user']; ?>" placeholder="End User" required="" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:30px;">Customer Name</label>
                <select name="customername" class="form-group" style="width:330px;" required="">
                  <option value="<?php echo $ResultQuerySelectRFQForm['id_customer']; ?>"><?php echo $ResultQuerySelectRFQForm['customer_name']; ?></option>
                  <?php
                    $QuerySelectAllCustomer = $mysqli->query("SELECT * FROM tbl_customer WHERE id_customer != ".$ResultQuerySelectRFQForm['id_customer']." ORDER BY id_customer ASC");
                    while($ResultQuerySelectAllCustomer = mysqli_fetch_array($QuerySelectAllCustomer)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllCustomer['id_customer'] ?>"><?php echo $ResultQuerySelectAllCustomer['customer_name'] ?></option>
                  <?php } ?>
                </select>
                
                <label style="padding-left:30px;padding-right:25px;">Car Name</label>
                <input name="carname" id="carname" type="text" class="form-group" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['car_name']; ?>"  placeholder="Car Name" required="" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:48px;">Project Name</label>
                <input name="projectname" id="projectname" type="text" class="form-group" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" placeholder="Project Name" required="" />
                
                <label style="padding-left:30px;padding-right:21px;">Part Name</label>
                <input name="partname" id="partname" type="text" class="form-group" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['part_name']; ?>" placeholder="Part Name" required="" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:86px;">Part No</label>
                <input name="partno" id="partno" type="text" class="form-group" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['part_no']; ?>" placeholder="Part No" required="" />
                
                <label style="padding-left:30px;padding-right:68px;">PIC</label>
                <input name="pic" id="pic" type="text" class="form-group" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['pic']; ?>" placeholder="PIC" required=""/>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:60px;">Document :</label>
                <label><?php echo $ResultQuerySelectRFQForm['name_doc']; ?></label>
              </div>
            </div>
            <div class="input-group control-group after-add-document">
              <div class="input-group">
                <label>Add Upload File</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <input name="document[]" type="file" accept="application/pdf" class="form-control" style="width:330px;" />
                    
                      <div class="input-group-btn"> 
                        <button class="btn btn-success add-document" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                      </div>  
                    
                  </div>
              </div>
            </div>
            
            
            <hr/>

            <div class="form-group">
              <label>Attached</label>
                <div class="input-group">
                  <input name="attached" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['attached']; ?>" placeholder="Attached" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Category</label>
                <select name="category" class="form-control" style="width:330px;" required="">
                  <option value="<?php echo $ResultQuerySelectRFQForm['id_category']; ?>"><?php echo $ResultQuerySelectRFQForm['category']; ?></option>
                  <?php
                    $QuerySelectAllCategory = $mysqli->query("SELECT * FROM tbl_category WHERE id_category != ".$ResultQuerySelectRFQForm['id_category']." ORDER BY id_category ASC");
                    while($ResultQuerySelectAllCategory = mysqli_fetch_array($QuerySelectAllCategory)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllCategory['id_category'] ?>"><?php echo $ResultQuerySelectAllCategory['category'] ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
              <label>Volume (Qty/month)</label>
                <div class="input-group">
                  <input name="volume" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['volume']; ?>" placeholder="Volume (Qty/month)" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Color</label>
              <div class="input-group" style="margin-top:10px">
                <select name="color" class="form-control" style="width:330px;" required="">
                  <option value="<?php echo $ResultQuerySelectRFQForm['id_color']; ?>"><?php echo $ResultQuerySelectRFQForm['color_name']; ?></option>
                  <?php
                    $QuerySelectAllColor = $mysqli->query("SELECT * FROM tbl_color WHERE id_color != ".$ResultQuerySelectRFQForm['color']." ORDER BY id_color ASC");
                    while($ResultQuerySelectAllColor = mysqli_fetch_array($QuerySelectAllColor)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllColor['id_color'] ?>"><?php echo $ResultQuerySelectAllColor['color_name'] ?></option>
                  <?php } ?>
                </select>
                <div class="input-group">
                  <div class="input-group-btn"> 
                    <a href="Color.php" class="btn btn-warning add-color" type="button"><i class='fa fa-edit'></i></a>
                  </div>  
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Material</label>
              <div class="input-group" style="margin-top:10px">
                <?php
                  $Material = explode(",",$ResultQuerySelectRFQForm['id_material']);
                  $index = 0;
                  foreach ($Material as $values) {
                    
                    if($values != null){

                      $get_informations = $mysqli->query("SELECT * FROM `tbl_material` WHERE id_material = $values");
                      $result_informations = mysqli_fetch_array($get_informations);

                      if($result_informations['id_material'] != null){
                        ?>

                        <select name="material[]" class="form-control" style="width:330px;" required="">
                          <option value="<?php echo $result_informations['id_material']; ?>"><?php echo $result_informations['material']; ?></option>
                          <?php
                            $QuerySelectAllMaterial = $mysqli->query("SELECT * FROM tbl_material WHERE id_material != ".$result_informations['id_material']." ORDER BY id_material ASC");
                            while($ResultQuerySelectAllMaterial = mysqli_fetch_array($QuerySelectAllMaterial)) {
                          ?>
                          <option value="<?php echo $ResultQuerySelectAllMaterial['id_material'] ?>"><?php echo $ResultQuerySelectAllMaterial['material'] ?></option>
                          <?php } ?>
                        </select>
                        <?php if($index == 0){ ?>
	                        <div class="input-group control-group after-add-material">
					            <div class="input-group-btn"> 
					              <button class="btn btn-success add-material" type="button"><i class="glyphicon glyphicon-plus"></i></button>
			                	  <a href="Material.php" class="btn btn-warning add-color" type="button"><i class='fa fa-edit'></i></a>
					            </div>  
					        </div>
				    	<?php } ?>
                        <br>

                        <?php
                        $index++;
                      }

                    }
                  }
                ?>
              </div>
            </div>
            <div class="form-group">
              <label>Product</label>
                <div class="input-group">
                  <input name="product" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['product']; ?>" placeholder="Product" required="" />
                </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:16px;">Provision of 3D</label><br>
                <?php 
                  if($ResultQuerySelectRFQForm['provision_of_3d'] == "yes" || $ResultQuerySelectRFQForm['provision_of_3d'] == "Yes"){
                    ?>
                    <input type="radio" name="provision" class="form-group" style="width:30px;" value="Yes" checked>
                    <label>Yes</label>
                    <input type="radio" name="provision" class="form-group" style="width:30px;" value="No" >
                    <label>No</label>
                    <?php
                  } else if($ResultQuerySelectRFQForm['provision_of_3d'] == "no" || $ResultQuerySelectRFQForm['provision_of_3d'] == "No"){
                    ?>
                    <input type="radio" name="provision" class="form-group" style="width:30px;" value="Yes" >
                    <label>Yes</label>
                    <input type="radio" name="provision" class="form-group" style="width:30px;" value="No" checked>
                    <label>No</label>
                    <?php
                  }
                ?>
              </div>
            </div>
            <div class="form-group">
              <label>Submit Limit</label>
                <div class="input-group">
                  <input name="submitlimit" type="text" class="datepicker" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['submit_limit']; ?>" placeholder="Submit Limit" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Delivery Rute</label>
                <div class="input-group">
                  <input name="deliveryrute" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['delivery_rute']; ?>" placeholder="Delivery Rute" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>SOP</label>
                <div class="input-group">
                  <input name="sop" type="text" class="datepicker" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['sop']; ?>" placeholder="SOP" required="" />
                </div>
            </div>

            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="RFQForm.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- End Content -->

    <!-- Copy Fields -->
    <div class="material hide">
      <div class="control-group input-group" style="margin-top:10px">
          <select name="material[]" class="form-control" style="width:330px;" required="">
            <option value="" disabled selected>-- Choose Material --</option>
            <?php
              $QuerySelectAllMaterial = $mysqli->query("SELECT * FROM tbl_material ORDER BY id_material ASC");
              while($ResultQuerySelectAllMaterial = mysqli_fetch_array($QuerySelectAllMaterial)) {
            ?>
            <option value="<?php echo $ResultQuerySelectAllMaterial['id_material'] ?>"><?php echo $ResultQuerySelectAllMaterial['material'] ?></option>
            <?php } ?>
          </select>
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
      </div>
    </div>
    <!-- End Copy Fields -->
    <!-- Copy Document Fields -->
    <div class="document hide">
      <div class="control-group input-group" style="margin-top:10px">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-file-pdf-o"></i>
            </div>
            <input name="document[]" type="file" accept="application/pdf" class="form-control" style="width:330px;" required="" />
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
          </div>
        </div>
    </div>
    <!-- End Copy Document Fields -->

    <!-- Multiple Document -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-document").click(function(){ 
            var html = $(".document").html();
            $(".after-add-document").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple Document -->

    <script type="text/javascript">
    $(document).ready(function() {
      $(".add-material").click(function(){ 
          var html = $(".material").html();
          $(".after-add-material").after(html);
      });
      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        });
    });
  </script>

<?php
}
?>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   