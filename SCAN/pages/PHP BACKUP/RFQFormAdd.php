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
	<!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> RFQ Form</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Add New Data RFQ</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/RFQForm_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
            <div class="form-group">
              <div class="input-group">
                <br>
                <label style="padding-right:66px;">Issue Date</label>
                <input name="issuedate" id="issuedate" type="text" class="datepicker" style="width:330px;" placeholder="Issue Date" required="" readonly/>
                
                <label style="padding-left:30px;padding-right:30px;">End User</label>
                <input name="enduser" id="enduser" type="text" class="form-group" style="width:330px;" placeholder="End User" required="" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:30px;">Customer Name</label>
                <select name="customername" class="form-group" style="width:330px;" required="">
                  <option value="" disabled selected>-- Choose Customer --</option>
                  <?php
                    $QuerySelectAllCustomer = $mysqli->query("SELECT * FROM tbl_customer ORDER BY id_customer ASC");
                    while($ResultQuerySelectAllCustomer = mysqli_fetch_array($QuerySelectAllCustomer)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllCustomer['id_customer'] ?>"><?php echo $ResultQuerySelectAllCustomer['customer_name'] ?></option>
                  <?php } ?>
                </select>
                
                <label style="padding-left:30px;padding-right:25px;">Car Name</label>
                <input name="carname" id="carname" type="text" class="form-group" style="width:330px;" placeholder="Car Name" required="" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:48px;">Project Name</label>
                <input name="projectname" id="projectname" type="text" class="form-group" style="width:330px;" placeholder="Project Name" required="" />
                
                <label style="padding-left:30px;padding-right:21px;">Part Name</label>
                <input name="partname" id="partname" type="text" class="form-group" style="width:330px;" placeholder="Part Name" required="" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label style="padding-right:86px;">Part No</label>
                <input name="partno" id="partno" type="text" class="form-group" style="width:330px;" placeholder="Part No" required="" />
                
                <label style="padding-left:30px;padding-right:68px;">PIC</label>
                <input name="pic" id="pic" type="text" class="form-group" style="width:330px;" placeholder="PIC" required=""/>
              </div>
            </div>
            <div class="input-group control-group after-add-document">
              <div class="input-group">
                <label>Upload File</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <input name="document[]" type="file" accept="application/pdf" class="form-control" style="width:330px;" required="" />
                    
                      <div class="input-group-btn"> 
                        <button class="btn btn-success add-document" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                      </div>  
                    
                  </div>
              </div>
            </div>
            <hr/>

            <div class="form-group">
              <label>File Feasibility</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-file-pdf-o"></i>
                  </div>
                  <select style="width:420px;" name="feasibility" class="form-control" required="">
                    <option value="" disabled selected>Select For Use Feasibility</option>
                    <?php
                      $QueryListFeasibility = $mysqli->query("SELECT * FROM doc_feasibility WHERE status = 1 AND doc_use = 0 ORDER BY iddoc_feasibility DESC");
                      while($ResulQueryListFeasibility = mysqli_fetch_array($QueryListFeasibility)) {
                    ?>
                    <option value="<?php echo $ResulQueryListFeasibility['iddoc_feasibility'] ?>"><?php echo $ResulQueryListFeasibility['name_doc'] ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
              <label>Attached</label>
              <div class="input-group" style="margin-top:10px">
                <select name="attached[]" class="form-control" style="width:330px;" required="">
                  <option value="" disabled selected>-- Choose Attached --</option>
                  <?php
                    $QuerySelectAllAttached = $mysqli->query("SELECT * FROM tbl_attached ORDER BY id_attached ASC");
                    while($ResultQuerySelectAllAttached = mysqli_fetch_array($QuerySelectAllAttached)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllAttached['id_attached'] ?>"><?php echo $ResultQuerySelectAllAttached['attached'] ?></option>
                  <?php } ?>
                </select>
                <div class="input-group control-group after-add-attached">
                  <div class="input-group-btn"> 
                    <button class="btn btn-success add-attached" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                  </div>  
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Category</label>
              <div class="input-group" style="margin-top:10px">
                <select name="category[]" class="form-control" style="width:330px;" required="">
                  <option value="" disabled selected>-- Choose Category --</option>
                  <?php
                    $QuerySelectAllCategory = $mysqli->query("SELECT * FROM tbl_category ORDER BY id_category ASC");
                    while($ResultQuerySelectAllCategory = mysqli_fetch_array($QuerySelectAllCategory)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllCategory['id_category'] ?>"><?php echo $ResultQuerySelectAllCategory['category'] ?></option>
                  <?php } ?>
                </select>
                <div class="input-group control-group after-add-category">
                  <div class="input-group-btn"> 
                    <button class="btn btn-success add-category" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                  </div>  
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Volume (Qty/month)</label>
                <div class="input-group">
                  <input name="volume" type="text" class="form-control" style="width:300px;" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Depreciation Qty</label>
                <div class="input-group">
                  <input name="depreciationqty" type="text" class="form-control" style="width:300px;" required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Material Color</label>
              <div class="input-group" style="margin-top:10px">
                <select name="materialcolor[]" class="form-control" style="width:330px;">
                  <option value="" disabled selected>-- Choose Color --</option>
                  <?php
                    $QuerySelectAllColor = $mysqli->query("SELECT * FROM tbl_color ORDER BY id_color ASC");
                    while($ResultQuerySelectAllColor = mysqli_fetch_array($QuerySelectAllColor)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllColor['id_color'] ?>"><?php echo $ResultQuerySelectAllColor['color_name'] ?></option>
                  <?php } ?>
                </select>
                <div class="input-group control-group after-add-materialcolor">
                  <div class="input-group-btn"> 
                    <button class="btn btn-success add-materialcolor" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                    <a href="Color.php" class="btn btn-warning add-color" type="button"><i class='fa fa-edit'></i></a>
                  </div>  
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Material</label>
              <div class="input-group" style="margin-top:10px">
                <select name="material[]" class="form-control" style="width:330px;" required="">
                  <option value="" disabled selected>-- Choose Material --</option>
                  <?php
                    $QuerySelectAllMaterial = $mysqli->query("SELECT * FROM tbl_material ORDER BY id_material ASC");
                    while($ResultQuerySelectAllMaterial = mysqli_fetch_array($QuerySelectAllMaterial)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllMaterial['id_material'] ?>"><?php echo $ResultQuerySelectAllMaterial['material'] ?></option>
                  <?php } ?>
                </select>
                <div class="input-group control-group after-add-material">
  		            <div class="input-group-btn"> 
  		              <button class="btn btn-success add-material" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                    <a href="Material.php" class="btn btn-warning add-color" type="button"><i class='fa fa-edit'></i></a>
  		            </div>  
    		        </div>
              </div>
            </div>
            <div class="form-group">
              <label>Production Process</label>
                <div class="input-group">
                  <input name="productionprocess" type="text" class="form-control" style="width:530px;" required="" />
                </div>
            </div>
            <div class="form-group">
              <table width="100%" >
                <div>
                  <thead>
                    <th class="text-left" style="width:80px;">Deadline MKT</th>
                    <th class="text-left" style="width:80px;">Deadline DE</th>
                    <th class="text-left" style="width:80px;">Deadline PE</th>
                    <th class="text-left" style="width:80px;">Deadline QE</th>
                    <th class="text-left" style="width:80px;">Deadline NPD</th>
                  </thead>
                  <tr>
                    <td class="text-center">
                      <input name="deadline_mkt" type="text" class="datepicker" style="width:200px;" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_de" type="text" class="datepicker" style="width:200px;" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_pe" type="text" class="datepicker" style="width:200px;" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_qe" type="text" class="datepicker" style="width:200px;" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_npd" type="text" class="datepicker" style="width:200px;" required="" readonly/>
                    </td>
                  </tr>
                </div>
              </table>
            </div>
            <div class="form-group">
              <label>Delivery Destination</label>
                <div class="input-group">
                  <input name="deliverydestinatione" type="text" class="form-control" style="width:530px;"  required="" />
                </div>
            </div>
            <div class="form-group">
              <label>Delivery Scheme</label>
                <div class="input-group">
                  <input name="deliveryscheme" type="text" class="form-control" style="width:530px;"  required="" />
                </div>
            </div>
            <div class="form-group">
              <label>SOP</label>
                <div class="input-group">
                  <input name="sop" type="text" class="datepicker" style="width:330px;" required="" readonly/>
                </div>
            </div>
            <table width="100%">
              <div>
                <tr>
                   <td class="text-center">
                    <label>Notes</label>
                   </td>
                 </tr>
                 <tr>
                   <td class="text-center">
                      <textarea class="form-control" name="notes" rows="2" cols="40" required=""></textarea>
                   </td>
                 </tr>
               </div>
             </table>

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

    <!-- Copy Attached Fields -->
    <div class="attached hide">
      <div class="control-group input-group" style="margin-top:10px">
          <select name="attached[]" class="form-control" style="width:330px;" required="">
            <option value="" disabled selected>-- Choose Attached --</option>
            <?php
              $QuerySelectAllAttached = $mysqli->query("SELECT * FROM tbl_attached ORDER BY id_attached ASC");
              while($ResultQuerySelectAllAttached = mysqli_fetch_array($QuerySelectAllAttached)) {
            ?>
            <option value="<?php echo $ResultQuerySelectAllAttached['id_attached'] ?>"><?php echo $ResultQuerySelectAllAttached['attached'] ?></option>
            <?php } ?>
          </select>
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
      </div>
    </div>
    <!-- End Copy Attached Fields -->

    <!-- Copy Category Fields -->
    <div class="category hide">
      <div class="control-group input-group" style="margin-top:10px">
          <select name="category[]" class="form-control" style="width:330px;" required="">
            <option value="" disabled selected>-- Choose Category --</option>
            <?php
              $QuerySelectAllCategory = $mysqli->query("SELECT * FROM tbl_category ORDER BY id_category ASC");
              while($ResultQuerySelectAllCategory = mysqli_fetch_array($QuerySelectAllCategory)) {
            ?>
            <option value="<?php echo $ResultQuerySelectAllCategory['id_category'] ?>"><?php echo $ResultQuerySelectAllCategory['category'] ?></option>
            <?php } ?>
          </select>
        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
      </div>
    </div>
    <!-- End Copy Category Fields -->

    <!-- Copy Material Color Fields -->
    <div class="materialcolor hide">
      <div class="control-group input-group" style="margin-top:10px">
          <select name="materialcolor[]" class="form-control" style="width:330px;">
            <option value="" disabled selected>-- Choose Color --</option>
            <?php
              $QuerySelectAllColor = $mysqli->query("SELECT * FROM tbl_color ORDER BY id_color ASC");
              while($ResultQuerySelectAllColor = mysqli_fetch_array($QuerySelectAllColor)) {
            ?>
            <option value="<?php echo $ResultQuerySelectAllColor['id_color'] ?>"><?php echo $ResultQuerySelectAllColor['color_name'] ?></option>
            <?php } ?>
          </select>
          <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
      </div>
    </div>
    <!-- End Copy Material Color Fields -->

    <!-- Copy Material Fields -->
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
    <!-- End Copy Material Fields -->

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

    <!-- Multiple attached -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-attached").click(function(){ 
            var html = $(".attached").html();
            $(".after-add-attached").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple attached -->

    <!-- Multiple category color -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-category").click(function(){ 
            var html = $(".category").html();
            $(".after-add-category").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple category color -->

    <!-- Multiple Material color -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-materialcolor").click(function(){ 
            var html = $(".materialcolor").html();
            $(".after-add-materialcolor").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple Material color -->

    <!-- Multiple Material -->
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
    <!-- End Multiple Material -->

    <script type="text/javascript">
      $(document).ready(function () {
          $('.datepicker').datepicker({
              format: "yyyy-mm-dd",
              autoclose:true
          });
      });
    </script>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   