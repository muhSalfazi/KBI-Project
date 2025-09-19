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
  $IdRFQForm = $_GET['ID'];
?>

	<!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Performance Of Test</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT tbl_bill_of_material.id_bill as id_bill, tbl_rfq.id_rfq as id_rfq, tbl_rfq.project_name as project_name, tbl_rfq.pic as pic, tbl_rfq.issue_date as issue_date, tbl_rfq.part_no as part_no, tbl_rfq.part_name as part_name, tbl_rfq.car_name as car_name, tbl_rfq.end_user as end_user, tbl_rfq.volume as volume, tbl_rfq.depreciation_qty as depreciation_qty, tbl_rfq.id_material as id_material, tbl_rfq.production_process as production_process, tbl_rfq.sop as sop, tbl_rfq.deadline_npd as deadline_npd, tbl_customer.customer_name as customer_name, tbl_bill_of_material.name_file_image as name_file_image, tbl_bill_of_material.name_file_image_open as name_file_image_open, tbl_rfq.name_doc as name_doc, tbl_bill_of_material.part_name_bill as part_name_bill, tbl_bill_of_material.part_no_bill as part_no_bill, tbl_bill_of_material.size as size, tbl_bill_of_material.mass as mass, tbl_bill_of_material.qty as qty, tbl_bill_of_material.name_doc as name_doc_bill FROM tbl_rfq LEFT JOIN tbl_bill_of_material ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Performance Of Test</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/PerformanceOfTest_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
            <input type="hidden" name="projectname" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" />
            <table>
              <div>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:69px;">Project Name</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:98px;">Issue Date</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['issue_date']; ?>" disabled/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:108px;">Part No</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['part_no']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:100px;">Part Name</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['part_name']; ?>" disabled/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:93px;">Car Name</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['car_name']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:107px;">End User</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['end_user']; ?>" disabled/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:24px;">Volume (Qty/month)</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['volume']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:55px;">Depreciation Qty</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['depreciation_qty']; ?>" disabled/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:103px;">Material</label>
                    <?php 
                      $value = explode(',', $ResultQuerySelectRFQForm['id_material']); 
                      $QuerySelectMaterial=mysqli_query($mysqli, "SELECT * FROM tbl_material WHERE tbl_material.id_material = ".$value[0]."");
                      $ResultQuerySelectMaterial=mysqli_fetch_array($QuerySelectMaterial); 
                    ?>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectMaterial['material']; ?>" disabled/>
                  <td class="text-left">
                    <label style="padding-right:35px;">Production Process</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['production_process']; ?>" disabled/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:91px;">Customer</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['customer_name']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:138px;">SOP</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['sop']; ?>" disabled/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:95px;">Due Date</label>
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_npd']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:143px;">PIC</label>
                    <input name="pic" id="pic" type="text" class="form-group" style="width:280px;" required/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:10px;">Document</label>
                    <textarea class="form-control" name="notes" rows="2" cols="40" style="width:510px;" required="" disabled><?php echo $ResultQuerySelectRFQForm['name_doc']; ?></textarea>
                  </td>
                </tr>
              </div>
            </table>
            <hr/>
            <div class="control-group after-add-more">
              <table width="100%" border="1">
                <div>
                  <thead>
                    <th class="text-center" style="width:150px;">Test Item</th>
                    <th class="text-center" style="width:150px;">Method</th>
                    <th class="text-center" style="width:150px;">Qty</th>
                    <th class="text-center" style="width:150px;">Unit Price(IDR)</th>
                    <th class="text-center" style="width:150px;">Total</th>
                    <th class="text-center" style="width:1px;">Add</th>
                  </thead>
                  <tr>
                    <td class="text-center">
                      <input name="testitem[]" id="testitem[]" type="text" style="width:180px;" required="" />
                    </td>
                    <td class="text-center">
                      <input name="method[]" id="method[]" type="text" style="width:180px;" equired="" />
                    </td>
                    <td class="text-center">
                      <input name="qty[]" id="qty[]" type="text" style="width:180px;" required="" />
                    </td>
                    <td class="text-center">
                      <input name="unit[]" id="unit[]" type="text" style="width:180px;" required="" />
                    </td>
                    <td class="text-center">
                      <input name="total[]" id="total[]" type="text" style="width:180px;" required="" />
                    </td>
                    <!-- <td class="text-center">
                      <input name="document[]" type="file" accept="application/pdf" style="width:150px;" required="" />
                    </td> -->
                    <td class="text-center">
                      <div class="input-group-btn"> 
                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                      </div>  
                    </td>
                  </tr>
                </div>
              </table>
            </div>
            <br>
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

            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="PerformanceOfTest.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- End Content -->

    <!-- Copy Fields -->
    <div class="copy hide">
      <div class="control-group" style="margin-top:10px">
        <table width="100%" border="1">
          <tr>
	        <td class="text-center">
	          <input name="testitem[]" id="testitem[]" type="text" style="width:180px;" required="" />
	        </td>
	        <td class="text-center">
	          <input name="method[]" id="method[]" type="text" style="width:180px;" equired="" />
	        </td>
	        <td class="text-center">
	          <input name="qty[]" id="qty[]" type="text" style="width:180px;" required="" />
	        </td>
	        <td class="text-center">
	          <input name="unit[]" id="unit[]" type="text" style="width:180px;" required="" />
	        </td>
	        <td class="text-center">
	          <input name="total[]" id="total[]" type="text" style="width:180px;" required="" />
	        </td>
            <td class="text-center">
              <div class="input-group-btn"> 
                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
              </div>  
            </td>
          </tr>
        </table>
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

    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-more").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>

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