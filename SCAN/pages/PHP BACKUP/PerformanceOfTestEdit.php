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
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm AND tbl_rfq.revision = (SELECT max(tbl_rfq.revision) FROM tbl_rfq WHERE tbl_rfq.id_rfq = $IdRFQForm)");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);

        $QuerySelectPerformanceOfTest=mysqli_query($mysqli, "SELECT * FROM tbl_perf_of_test INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_perf_of_test.idrfq_perf INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_perf_of_test.id_user = tbl_user.id_user WHERE tbl_perf_of_test.idrfq_perf = ".$IdRFQForm." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$IdRFQForm.") AND tbl_perf_of_test.revision_perf = (SELECT MAX(tbl_perf_of_test.revision_perf) as revision_perf FROM tbl_perf_of_test WHERE tbl_perf_of_test.idrfq_perf = ".$IdRFQForm.")");
        $ResultQuerySelectPerformanceOfTest=mysqli_fetch_array($QuerySelectPerformanceOfTest);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Performance Of Test</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/PerformanceOfTest_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
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
                    <input name="pic" id="pic" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectPerformanceOfTest['pic_perf']; ?>" required/>
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
                    <th class="text-center" style="width:1px;">Delete</th>
                  </thead>

                  <?php
                    $TestItem   = explode(",",$ResultQuerySelectPerformanceOfTest['test_item']);
                    $Method     = explode(",",$ResultQuerySelectPerformanceOfTest['method']);
                    $Qty        = explode(",",$ResultQuerySelectPerformanceOfTest['qty']);
                    $Unit       = explode(",",$ResultQuerySelectPerformanceOfTest['unit']);
                    $Total      = explode(",",$ResultQuerySelectPerformanceOfTest['total']);

                    $loop = 0;
                    foreach ($TestItem as $values) {
                  
                      if($values != null){
                  ?>
                  <tr>
                    <td class="text-center">
                      <input name="testitem[]" id="testitem<?php echo $loop+1;?>" type="text" style="width:180px;" value="<?php echo $values; ?>" required/>
                    </td>
                    <td class="text-center">
                      <input name="method[]" id="method<?php echo $loop+1;?>" type="text" style="width:180px;" value="<?php echo $Method[$loop]; ?>" required/>
                    </td>
                    <td class="text-center">
                      <input name="qty[]" id="qty<?php echo $loop+1;?>" type="text" style="width:180px;" value="<?php echo $Qty[$loop]; ?>" required/>
                    </td>
                    <td class="text-center">
                      <input name="unit[]" id="unit<?php echo $loop+1;?>" type="text" style="width:180px;" value="<?php echo $Unit[$loop]; ?>" onkeyup="getValueTotal(<?php echo $loop+1;?>)" required/>
                    </td>
                    <td class="text-center">
                      <input name="total[]" id="total<?php echo $loop+1;?>" type="text" style="width:180px;" value="<?php echo $Total[$loop]; ?>" readonly required/>
                    </td>
                    <td class="text-center">
                      <div class="input-group-btn"> 
                        <a href="#" class="btn btn-danger" onclick="confirm_modal('../pages/crud/PerformanceOfTest_RemoveList.php?ID=<?php echo $ResultQuerySelectPerformanceOfTest['idrfq_perf']."&LOOP=".$loop."&IDUSER=".$IdUser; ?>');"><i class='glyphicon glyphicon-remove'></i></a>
                      </div>  
                    </td>
                  </tr>
                  <?php
                        $loop++;
                      }
                    }
                  ?>
                  
                  <?php
                    include "PerformanceOfTestEditExt.php";
                  ?>

                </div>
              </table>
            </div>
            <br>
            <h4><strong>File</strong></h4>
            <table width="50%" border="1" id="dataTables-example">
              <div>
                <tr>
                  <td class="text-center" style="width:10px;"><b>No.</b></td>
                  <td class="text-center" style="width:30px;"><b>Name File</b></td>
                  <td class="text-center" style="width:20px;"><b>Size</b></td>
                  <td class="text-center" style="width:20px;"><b>Menu</b></td>
                </tr>
                <?php
                  $NameFile = explode(",",$ResultQuerySelectPerformanceOfTest['name_doc_pref']);
                  $SizeFile = explode(",",$ResultQuerySelectPerformanceOfTest['size_doc_pref']);
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
                <label>Upload File</label>
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

    <!-- Modal Content Remove -->
      <!-- Modal Popup untuk Remove --> 
      <div class="modal fade" id="modal_remove">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" style="text-align:center;"> Are You Sure Remove This Data ?</h4>
            </div>
                      
            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
              <a href="#" style="width:100px;" class="btn btn-danger" id="delete_link"><i class="fa fa-trash"> Remove</i></a>
              <button type="button" style="width:100px;" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"> Cancel</i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal Popup untuk Remove --> 

      <!-- Javascript untuk popup modal Remove--> 
      <script type="text/javascript">
          function confirm_modal(delete_url)
          {
            $('#modal_remove').modal('show', {backdrop: 'static'});
            document.getElementById('delete_link').setAttribute('href' , delete_url);
          }
      </script>
      <!-- End Javascript untuk popup modal Remove--> 
    <!-- End Modal Content Remove -->

    <script type="text/javascript">
      $(document).ready(function () {
          $('.datepicker').datepicker({
              format: "yyyy-mm-dd",
              autoclose:true
          });
      });
    </script>

    <script type="text/javascript">
      function getValueTotal(loop){
        var getqty    = document.getElementById("qty".concat(loop)).value;
        var getunit  = document.getElementById("unit".concat(loop)).value;

        var values = getqty * getunit;

        document.getElementById("total".concat(loop)).value=values;
        
      }
    </script>

<?php
}
?>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   