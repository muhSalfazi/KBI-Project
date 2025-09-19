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

  $IdRFQForm  = $_GET['ID'];
  $IdPBOM     = $_GET['IDBILL'];
?>

	<!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Bill Of material</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_bill_of_material ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_user.id_user = tbl_rfq.id_user WHERE tbl_rfq.id_rfq = ".$IdRFQForm." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$IdRFQForm.") AND tbl_bill_of_material.revision_pbom = (SELECT MAX(tbl_bill_of_material.revision_pbom) as revision_pbom FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$IdRFQForm.")");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Bill Of material</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/BillOfMaterial_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
            <input type="hidden" name="id" value="<?php echo $IdPBOM; ?>" />
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
                    <input name="picbom" id="picbom" type="text" class="form-group" style="width:280px;" required/>
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
            <br>
            <div class="control-group after-add-more">
              <table width="100%" border="1">
                <div>
                  <thead>
                    <th class="text-center" style="width:50px;">Level</th>
                    <th class="text-center" style="width:50px;">Part Name</th>
                    <th class="text-center" style="width:50px;">Part No</th>
                    <th class="text-center" style="width:50px;">Material</th>
                    <th class="text-center" style="width:50px;">Size(mm)</th>
                    <th class="text-center" style="width:50px;">Mass(gram)</th>
                    <th class="text-center" style="width:50px;">Qty(pcs)</th>
                    <th class="text-center" style="width:50px;">ID Intacs</th>
                    <th class="text-center" style="width:50px;">Price</th>
                    <th class="text-center" style="width:50px;">Supplier</th>
                    <th class="text-center" style="width:50px;">Doc Drawing</th>
                  </thead>
                  <?php
                    $Level = explode(",",$ResultQuerySelectRFQForm['level_bill']);
                    $Material = explode(",",$ResultQuerySelectRFQForm['id_material']);
                    $PartName = explode(",",$ResultQuerySelectRFQForm['part_name_bill']);
                    $PartNo = explode(",",$ResultQuerySelectRFQForm['part_no_bill']);
                    $Size = explode(",",$ResultQuerySelectRFQForm['size']);
                    $Mass = explode(",",$ResultQuerySelectRFQForm['mass']);
                    $Qty = explode(",",$ResultQuerySelectRFQForm['qty']);
                    $DocBill = explode(",",$ResultQuerySelectRFQForm['name_doc']);

                    $loop = 0;
                    foreach ($Material as $values) {
                      
                      if($values != null && $Level[$loop] > 1){

                        $get_informations = $mysqli->query("SELECT * FROM `tbl_material` WHERE id_material = $values");
                        $result_informations = mysqli_fetch_array($get_informations);

                        if($result_informations['id_material'] != null){
                          ?>
                  <tr>
                    <td class="text-center">
                      <select name="level[]" style="width:85px;" disabled>
                        <option value="<?php echo $Level[$loop]; ?>"><?php echo $Level[$loop]; ?></option>
                      </select>
                    </td>
                    <td class="text-center">
                      <input name="partname[]" type="text" style="width:80px;" value="<?php echo $PartName[$loop]; ?>" disabled/>
                    </td>
                    <td class="text-center">
                      <input name="partno[]" type="text" style="width:80px;" value="<?php echo $PartNo[$loop]; ?>" disabled/>
                    </td>
                    <td class="text-center">
	                    <select name="material[]" style="width:80px;">
	                    	<option value="<?php echo $result_informations['id_material']; ?>"><?php echo $result_informations['material']; ?></option>
	                  	</select>
                    </td>
                    <td class="text-center">
                      <input name="size[]" type="text" style="width:80px;" value="<?php echo $Size[$loop]; ?>" disabled/>
                    </td>
                    <td class="text-center">
                      <input name="mass[]" type="text" style="width:80px;" value="<?php echo $Mass[$loop]; ?>" disabled/>
                    </td>
                    <td class="text-center">
                      <input name="qty[]" type="text" style="width:80px;" value="<?php echo $Qty[$loop]; ?>" disabled/>
                    </td>
                    <td class="text-center">
                      <input name="id_intacs[]" type="text" style="width:80px;" required="" />
                    </td>
                    <td class="text-center">
                      <input name="price[]" type="text" style="width:80px;" required="" />
                    </td>
                    <td class="text-center">
                      <input name="supplier[]" type="text" style="width:80px;" required="" />
                    </td>
                    <td class="text-center">
                      <?php 
                        if(!$DocBill[$loop] == '' || !$DocBill[$loop] == null){
                         echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='file/PreliminaryBillOfMaterial/".$DocBill[$loop]."'><i class='fa fa-folder-open'> View</i></a>"; 
                        }else{
                         echo"NULL";
                        }
                       ?> 
                    </td>
                  </tr>
	                  <?php
	                    }

	                  }
                    $loop++;
	                }

	              ?>
                </div>
              </table>
            </div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="BillOfMaterial.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- End Content -->

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