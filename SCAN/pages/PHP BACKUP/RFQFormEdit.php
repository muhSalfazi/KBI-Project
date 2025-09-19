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
        // Get Revision
        $QuerySelectRevisiRFQForm=mysqli_query($mysqli, "SELECT MAX(`revision`) AS revision FROM `tbl_rfq` WHERE id_rfq = $IdRFQForm");
        $ResultQuerySelectRevisiRFQForm=mysqli_fetch_array($QuerySelectRevisiRFQForm);
        $Revision = 0;
        if($ResultQuerySelectRevisiRFQForm['revision'] != 0){
          $Revision = $ResultQuerySelectRevisiRFQForm['revision'];
        }
        // End Get Revision

        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm AND tbl_rfq.revision = $Revision");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Data RFQ</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/RFQForm_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
            <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
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
            <h4><strong>Documents</strong></h4>
            <table width="50%" border="1" id="dataTables-example">
              <div>
                <tr>
                  <td class="text-center" style="width:10px;"><b>No.</b></td>
                  <td class="text-center" style="width:30px;"><b>Name File</b></td>
                  <td class="text-center" style="width:20px;"><b>Size</b></td>
                  <td class="text-center" style="width:20px;"><b>Menu</b></td>
                </tr>
                <?php
                  $NameFile = explode(",",$ResultQuerySelectRFQForm['name_doc']);
                  $SizeFile = explode(",",$ResultQuerySelectRFQForm['size_doc']);
                  $Loop = 0;
                  foreach ($NameFile as $values) {
                      if($values != null){
                        $Loop++;
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $Loop; ?></td>
                        <td class="text-center"><?php echo $values; ?></td>
                        <td class="text-center"><?php echo $SizeFile[$Loop-1]; ?></td>
                        <td class="text-center">
                          <?php 
                            echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='file/RFQForm/".$NameFile[$Loop-1]."'><i class='fa fa-folder-open'> View</i></a>"; 
                          ?>
                        </td>
                      </tr>
                      <?php
                      }
                  }
                ?>
              </div>
            </table>
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
              <label>File Feasibility</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-file-pdf-o"></i>
                </div>
                <?php
                  $QueryGetFeasibility = $mysqli->query("SELECT * FROM doc_feasibility WHERE iddoc_feasibility = ".$ResultQuerySelectRFQForm['iddoc_feasibility']."");
                  $ResulQueryGetFeasibility = mysqli_fetch_array($QueryGetFeasibility);
                ?>
                <select style="width:420px;" name="feasibility" class="form-control" required="">
                  <option value="<?php echo $ResulQueryGetFeasibility['iddoc_feasibility']; ?>"><?php echo $ResulQueryGetFeasibility['name_doc']; ?></option>
                  <?php
                    $QueryListFeasibility = $mysqli->query("SELECT * FROM doc_feasibility WHERE status = 1 AND doc_use = 0 AND iddoc_feasibility != ".$ResultQuerySelectRFQForm['iddoc_feasibility']." ORDER BY iddoc_feasibility DESC");
                    while($ResulQueryListFeasibility = mysqli_fetch_array($QueryListFeasibility)) {
                  ?>
                  <option value="<?php echo $ResulQueryListFeasibility['iddoc_feasibility'] ?>"><?php echo $ResulQueryListFeasibility['name_doc'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <hr/>
            <h4><strong>Attached</strong></h4>
            <table width="20%" border="1" id="dataTables-example">
              <div>
                <tr>
                  <td class="text-center" style="width:10px;"><b>No.</b></td>
                  <td class="text-center" style="width:30px;"><b>Name Attached</b></td>
                </tr>
                <?php
                  $SingleAttached = explode(",",$ResultQuerySelectRFQForm['attached']);
                  $Loop = 0;
                  foreach ($SingleAttached as $values) {
                    if($values != null){
                      $QueryGetAttached = $mysqli->query("SELECT * FROM tbl_attached WHERE id_attached = ".$values."");
                      $ResulQueryGetAttached = mysqli_fetch_array($QueryGetAttached);
                      $Loop++;
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $Loop; ?></td>
                      <td class="text-center"><?php echo $ResulQueryGetAttached['attached']; ?></td>
                    </tr>
                    <?php
                    }
                  }
                ?>
              </div>
            </table>
            <div class="form-group">
              <br>
              <label>Add Attached</label>
              <div class="input-group" style="margin-top:10px">
                <select name="attached[]" class="form-control" style="width:330px;">
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
            <hr/>
            <h4><strong>Category</strong></h4>
            <table width="20%" border="1" id="dataTables-example">
              <div>
                <tr>
                  <td class="text-center" style="width:10px;"><b>No.</b></td>
                  <td class="text-center" style="width:30px;"><b>Name Category</b></td>
                </tr>
                <?php
                  $SingleCategory = explode(",",$ResultQuerySelectRFQForm['id_category']);
                  $Loop = 0;
                  foreach ($SingleCategory as $values) {
                    if($values != null){
                      $QueryGetCategory = $mysqli->query("SELECT * FROM tbl_category WHERE id_category = ".$values."");
                      $ResulQueryGetCategory = mysqli_fetch_array($QueryGetCategory);
                      $Loop++;
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $Loop; ?></td>
                      <td class="text-center"><?php echo $ResulQueryGetCategory['category']; ?></td>
                    </tr>
                    <?php
                    }
                  }
                ?>
              </div>
            </table>
            <div class="form-group">
              <br>
              <label>Add Category</label>
              <div class="input-group" style="margin-top:10px">
                <select name="category[]" class="form-control" style="width:330px;">
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
            <hr/>
            <div class="form-group">
              <label>Volume (Qty/month)</label>
                <div class="input-group">
                  <input name="volume" type="text" class="form-control" style="width:300px;" value="<?php echo $ResultQuerySelectRFQForm['volume']; ?>" required="" />
                </div>
            </div>
            <hr/>
            <div class="form-group">
              <label>Depreciation Qty</label>
                <div class="input-group">
                  <input name="depreciationqty" type="text" class="form-control" style="width:300px;" value="<?php echo $ResultQuerySelectRFQForm['depreciation_qty']; ?>" required="" />
                </div>
            </div>
            <hr/>
            <h4><strong>Material Color</strong></h4>
            <table width="20%" border="1" id="dataTables-example">
              <div>
                <tr>
                  <td class="text-center" style="width:10px;"><b>No.</b></td>
                  <td class="text-center" style="width:30px;"><b>Name Material Color</b></td>
                </tr>
                <?php
                  $SingleMaterialColor = explode(",",$ResultQuerySelectRFQForm['id_color']);
                  $Loop = 0;
                  foreach ($SingleMaterialColor as $values) {
                    if($values != null){
                      $QueryGetSingleMaterialColor = $mysqli->query("SELECT * FROM tbl_color WHERE id_color = ".$values."");
                      $ResulQueryGetSingleMaterialColor = mysqli_fetch_array($QueryGetSingleMaterialColor);
                      $Loop++;
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $Loop; ?></td>
                      <td class="text-center"><?php echo $ResulQueryGetSingleMaterialColor['color_name']; ?></td>
                    </tr>
                    <?php
                    }
                  }
                ?>
              </div>
            </table>
            <div class="form-group">
              <br>
              <label>Add Material Color</label>
              <div class="input-group" style="margin-top:10px">
                <select name="materialcolor[]" class="form-control" style="width:330px;">
                  <option value="" disabled selected>-- Choose Color --</option>
                  <?php
                    $QuerySelectAllMaterialColor = $mysqli->query("SELECT * FROM tbl_color ORDER BY id_color ASC");
                    while($ResultQuerySelectAllMaterialColor = mysqli_fetch_array($QuerySelectAllMaterialColor)) {
                  ?>
                  <option value="<?php echo $ResultQuerySelectAllMaterialColor['id_color'] ?>"><?php echo $ResultQuerySelectAllMaterialColor['color_name'] ?></option>
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
            <hr/>
            <h4><strong>Material</strong></h4>
            <table width="20%" border="1" id="dataTables-example">
              <div>
                <tr>
                  <td class="text-center" style="width:10px;"><b>No.</b></td>
                  <td class="text-center" style="width:30px;"><b>Name Material</b></td>
                </tr>
                <?php
                  $SingleMaterial = explode(",",$ResultQuerySelectRFQForm['id_material']);
                  $Loop = 0;
                  foreach ($SingleMaterial as $values) {
                    if($values != null){
                      $QueryGetSingleSingleMaterial = $mysqli->query("SELECT * FROM tbl_material WHERE id_material = ".$values."");
                      $ResultQueryGetSingleSingleMaterial = mysqli_fetch_array($QueryGetSingleSingleMaterial);
                      $Loop++;
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $Loop; ?></td>
                      <td class="text-center"><?php echo $ResultQueryGetSingleSingleMaterial['material']; ?></td>
                    </tr>
                    <?php
                    }
                  }
                ?>
              </div>
            </table>
            <div class="form-group">
              <br>
              <label>Material</label>
              <div class="input-group" style="margin-top:10px">
                <select name="material[]" class="form-control" style="width:330px;">
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
            <hr/>
            <div class="form-group">
              <label>Production Process</label>
                <div class="input-group">
                  <input name="productionprocess" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['production_process']; ?>" required="" />
                </div>
            </div>
            <hr/>
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
                      <input name="deadline_mkt" type="text" class="datepicker" style="width:200px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_mkt']; ?>" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_de" type="text" class="datepicker" style="width:200px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_de']; ?>" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_pe" type="text" class="datepicker" style="width:200px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_pe']; ?>" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_qe" type="text" class="datepicker" style="width:200px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_qe']; ?>" required="" readonly/>
                    </td>
                    <td class="text-center">
                      <input name="deadline_npd" type="text" class="datepicker" style="width:200px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_npd']; ?>" required="" readonly/>
                    </td>
                  </tr>
                </div>
              </table>
            </div>
            <hr/>
            <div class="form-group">
              <label>Delivery Destination</label>
                <div class="input-group">
                  <input name="deliverydestinatione" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['delivery_destination']; ?>" required="" />
                </div>
            </div>
            <hr/>
            <div class="form-group">
              <label>Delivery Scheme</label>
                <div class="input-group">
                  <input name="deliveryscheme" type="text" class="form-control" style="width:530px;" value="<?php echo $ResultQuerySelectRFQForm['delivery_shceme']; ?>" required="" />
                </div>
            </div>
            <hr/>
            <div class="form-group">
              <label>SOP</label>
                <div class="input-group">
                  <input name="sop" type="text" class="datepicker" style="width:330px;" value="<?php echo $ResultQuerySelectRFQForm['sop']; ?>" required="" readonly/>
                </div>
            </div>
            <hr/>
            <table width="100%">
              <div>
                <tr>
                   <td class="text-center">
                    <label>Notes</label>
                   </td>
                 </tr>
                 <tr>
                   <td class="text-center">
                      <textarea class="form-control" name="notes" rows="2" cols="40" required=""><?php echo $ResultQuerySelectRFQForm['note_rfq']; ?></textarea>
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
}
?>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   