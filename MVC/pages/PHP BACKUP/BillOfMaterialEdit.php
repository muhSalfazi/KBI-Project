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
        <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Bill Of Material</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        // Get Revision RFQ
        $QuerySelectRevisiRFQForm=mysqli_query($mysqli, "SELECT MAX(`revision`) AS revision FROM `tbl_rfq` WHERE id_rfq = $IdRFQForm");
        $ResultQuerySelectRevisiRFQForm=mysqli_fetch_array($QuerySelectRevisiRFQForm);
        $Revision = 0;
        if($ResultQuerySelectRevisiRFQForm['revision'] != 0){
          $Revision = $ResultQuerySelectRevisiRFQForm['revision'];
        }
        // End Get Revision RFQ

        // Get Data RFQ
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm AND tbl_rfq.revision = $Revision");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);
        // End Get Data RFQ

        // Get Data PBOM
        $QuerySelectBOM=mysqli_query($mysqli, "SELECT * FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_bill = $IdPBOM");
        $ResultQuerySelectBOM=mysqli_fetch_array($QuerySelectBOM);
        // End Get Data PBOM
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Data Bill Of Material</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/BillOfMaterial_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
            <input type="hidden" name="idbill" value="<?php echo $ResultQuerySelectBOM['id_bill']; ?>" />
            <table width="100%">
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
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_de']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:143px;">PIC</label>
                    <input name="picbom" id="picbom" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectBOM['pic_bom']; ?>" required/>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:10px;">Document</label>
                    <textarea class="form-control" name="notes" rows="2" cols="40" required="" disabled><?php echo $ResultQuerySelectRFQForm['name_doc']; ?></textarea>
                  </td>
                </tr>
              </div>
            </table>
            <hr/>
            <table>
              <div>
                <tr>
                  <td class="text-left">
                    <table width="70%" border="1" id="dataTables-example">
                      <div>
                        <tr>
                          <td class="text-center" style="width:30px;"><b>Name File</b></td>
                          <td class="text-center" style="width:20px;"><b>Size</b></td>
                          <td class="text-center" style="width:20px;"><b>Menu</b></td>
                        </tr>
                        <tr>
                          <td class="text-center"><?php echo $ResultQuerySelectBOM['name_file_image']; ?></td>
                          <td class="text-center"><?php echo $ResultQuerySelectBOM['size_file_image']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='file/PreliminaryBillOfMaterial/".$ResultQuerySelectBOM['name_file_image']."'><i class='fa fa-folder-open'> View</i></a>"; 
                            ?>
                          </td>
                        </tr>
                      </div>
                    </table>
                  </td>
                  <td class="text-left">
                    <table width="70%" border="1" id="dataTables-example">
                      <div>
                        <tr>
                          <td class="text-center" style="width:30px;"><b>Name File</b></td>
                          <td class="text-center" style="width:20px;"><b>Size</b></td>
                          <td class="text-center" style="width:20px;"><b>Menu</b></td>
                        </tr>
                        <tr>
                          <td class="text-center"><?php echo $ResultQuerySelectBOM['name_file_image_open']; ?></td>
                          <td class="text-center"><?php echo $ResultQuerySelectBOM['size_file_image_open']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='file/PreliminaryBillOfMaterial/".$ResultQuerySelectBOM['name_file_image_open']."'><i class='fa fa-folder-open'> View</i></a>"; 
                            ?>
                          </td>
                        </tr>
                      </div>
                    </table>
                  </td>
                </tr>
              </div>
            </table>
            <br>
            <div class="control-group after-add-more">
              <table width="100%" border="1">
                <div>
                  <thead>
                    <th class="text-center" style="width:85px;">Level</th>
                    <th class="text-center" style="width:85px;">Part Name</th>
                    <th class="text-center" style="width:85px;">Part No</th>
                    <th class="text-center" style="width:85px;">Material</th>
                    <th class="text-center" style="width:85px;">Size(mm)</th>
                    <th class="text-center" style="width:85px;">Mass(gram)</th>
                    <th class="text-center" style="width:85px;">Qty(pcs)</th>
                    <th class="text-center" style="width:85px;">ID Intacs</th>
                    <th class="text-center" style="width:85px;">Price</th>
                    <th class="text-center" style="width:85px;">Supplier</th>
                    <th class="text-center" style="width:85px;">Doc Drawing</th>
                  </thead>

                  <?php
                    $Level = explode(",",$ResultQuerySelectBOM['level_bill']);
                    $Material = explode(",",$ResultQuerySelectBOM['id_material']);
                    $PartName = explode(",",$ResultQuerySelectBOM['part_name_bill']);
                    $PartNo = explode(",",$ResultQuerySelectBOM['part_no_bill']);
                    $Size = explode(",",$ResultQuerySelectBOM['size']);
                    $Mass = explode(",",$ResultQuerySelectBOM['mass']);
                    $Qty = explode(",",$ResultQuerySelectBOM['qty']);
                    $DocBill = explode(",",$ResultQuerySelectBOM['name_doc']);

                    $IdIntacs = explode(",",$ResultQuerySelectBOM['id_intacs']);
                    $Price = explode(",",$ResultQuerySelectBOM['price']);
                    $Supplier = explode(",",$ResultQuerySelectBOM['supplier']);

                    $loop = 0;
                    $looping = 0; 
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
                      <input name="id_intacs[]" type="text" style="width:80px;" value="<?php if($ResultQuerySelectBOM['id_intacs'] != null && $Level[$loop] > 1){ $looping++; echo $IdIntacs[$looping-1]; } ?>" required />
                    </td>
                    <td class="text-center">
                      <input name="price[]" type="text" style="width:80px;" value="<?php if($ResultQuerySelectBOM['id_intacs'] != null && $Level[$loop] > 1){ echo $Price[$looping-1]; } ?>" required />
                    </td>
                    <td class="text-center">
                      <input name="supplier[]" type="text" style="width:80px;" value="<?php if($ResultQuerySelectBOM['id_intacs'] != null && $Level[$loop] > 1){ echo $Supplier[$looping-1]; } ?>" required />
                    </td>
                    <td class="text-center">
                      <?php 
                        if(!$DocBill[$loop] == '' || !$DocBill[$loop] == null){
                         echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='file/PreliminaryBillOfMaterial/".$DocBill[$loop]."'><i class='fa fa-folder-open'> View</i></a>"; 
                        }else{
                         echo "NULL";
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