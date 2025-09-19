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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Preliminary Production Data</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm AND tbl_rfq.revision = (SELECT max(tbl_rfq.revision) FROM tbl_rfq WHERE tbl_rfq.id_rfq = $IdRFQForm)");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);

        $QuerySelectProductionData=mysqli_query($mysqli, "SELECT * FROM tbl_product_q INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_product_q.idrfq_p INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_product_q.id_user = tbl_user.id_user WHERE tbl_product_q.idrfq_p = ".$IdRFQForm." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$IdRFQForm.") AND tbl_product_q.revision_q = (SELECT MAX(tbl_product_q.revision_q) as revision_q FROM tbl_product_q WHERE tbl_product_q.idrfq_p = ".$IdRFQForm.")");
        $ResultQuerySelectProductionData=mysqli_fetch_array($QuerySelectProductionData);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Edit Preliminary Production Data</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/PreliminaryProductQuotation_Edit.php" name="modal_popup" enctype="multipart/form-data" method="post">
          	<input type="hidden" name="iduser" value="<?php echo $IdUser; ?>" />
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
            <input type="hidden" name="projectname" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" />
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
                    <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_pe']; ?>" disabled/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:143px;">PIC</label>
                    <input name="pic" id="pic" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectProductionData['pic_q']; ?>" required/>
                  </td>
                </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Document</label>
                      <textarea class="form-control" name="notes" rows="2" cols="40" style="width:472px;" required="" disabled><?php echo $ResultQuerySelectRFQForm['name_doc']; ?></textarea>
	                </td>
	              </tr>
	            </div>
	          </table>
            <hr/>
            <div class="control-group after-add-materialbatch">
              <table width="100%">
	            <div>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:29px;">Part Number</label>
                	  <input name="txtpartname" id="txtpartname" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['part_no']; ?>" disabled/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:53px;">Part Name</label>
            		  <input name="txtpartno" id="txtpartno" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['part_name']; ?>" disabled/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:36px;">Qty / Month</label>
                	  <input name="qtymonth" id="qtymonth" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['volume']; ?>" disabled/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Depreciation Qty</label>
            		  <input name="depreciationqty" id="depreciationqty" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['depreciation_qty']; ?>" disabled/>
	                </td>
	              </tr>
                <?php
                  $MaterialName = explode(",",$ResultQuerySelectProductionData['mat_name']);
                  $MaterialPercen = explode(",",$ResultQuerySelectProductionData['mat_percent']);
                  $MasterBatch = explode(",",$ResultQuerySelectProductionData['mas_batch']);
                  $MasterBatchPercen = explode(",",$ResultQuerySelectProductionData['mas_percent']);
                  $loop = 0;
                  foreach ($MaterialName as $values) {
                    if($values != null){
                ?>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:18px;">Material Name</label>
                	  <input name="materialname[]" type="text" class="form-group" style="width:270px;" value="<?php echo $values; ?>" required=""/>
                	  <input name="materialpercen[]" type="text" class="form-group" style="width:50px;" placeholder="%" value="<?php echo $MaterialPercen[$loop]; ?>" required=""/>
                    <?php if($loop != 0 && $loop != null) { ?>
                	   <a href="#" class="btn btn-danger btn-xs" onclick="confirm_modal('../pages/crud/PreliminaryProductQuotation_RemoveListMaterialAndBatch.php?ID=<?php echo $ResultQuerySelectProductionData['id_rfq']."&LOOP=".$loop."&IDUSER=".$IdUser; ?>');"><i class='glyphicon glyphicon-remove'></i></a>
                    <?php } ?>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:35px;">Master Batch</label>
                	  <input name="masterbatch[]" type="text" class="form-group" style="width:200px;" value="<?php echo $MasterBatch[$loop]; ?>" />
                	  <input name="masterbatchpercen[]" type="text" class="form-group" style="width:50px;" placeholder="%" value="<?php echo $MasterBatchPercen[$loop]; ?>"/>
                	  <?php if($loop != 0 && $loop != null) { ?>
                      <a href="#" class="btn btn-danger btn-xs" onclick="confirm_modal('../pages/crud/PreliminaryProductQuotation_RemoveListMaterialAndBatch.php?ID=<?php echo $ResultQuerySelectProductionData['id_rfq']."&LOOP=".$loop."&IDUSER=".$IdUser; ?>');"><i class='glyphicon glyphicon-remove'></i></a>
                    <?php } ?>
	                </td>
	              </tr>
                <?php
                      $loop++;
                    }
                  }
                ?>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:18px;">Material Name</label>
                    <input name="materialname[]" type="text" class="form-group" style="width:270px;"/>
                    <input name="materialpercen[]" type="text" class="form-group" style="width:50px;" placeholder="%"/>
                    <button class="btn btn-success add-materialbatch btn-xs" type="button"><i class="glyphicon glyphicon-plus "></i></button>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:35px;">Master Batch</label>
                    <input name="masterbatch[]" type="text" class="form-group" style="width:200px;"/>
                    <input name="masterbatchpercen[]" type="text" class="form-group" style="width:50px;" placeholder="%"/>
                    <button class="btn btn-success add-materialbatch btn-xs" type="button"><i class="glyphicon glyphicon-plus "></i></button>
                  </td>
                </tr>
	            </div>
	          </table>
	          </div>
	          <table width="100%">
               	<tr>
               		<td class="text-left">
                		<label style="padding-right:62px;">Remark</label>
            			<input name="remark" id="remark" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectProductionData['remark']; ?>" required/>
                	</td>
              	</tr>
	          </table>
	          <hr/>
	          <h3><strong>MOLDING PROCESS</strong></h3>
	          <br>
	          <div class="control-group after-add-product">
		          <table width="100%">
		            <div>
                  <?php
                    $ProductWeight = explode(",",$ResultQuerySelectProductionData['product_weight']);
                    $ToleransiWeight = explode(",",$ResultQuerySelectProductionData['toleransi_weight']);
                    $loop = 0;
                    foreach ($ProductWeight as $values) {
                      if($values != null){
                  ?>
		              <tr>
		                <td class="text-left">
		                  <label style="padding-right:9px;">Product Weight(gram)</label>
	                	  <input name="productweight[]" id="productweight" type="text" class="form-group" style="width:50px;" value="<?php echo $values; ?>" required=""/>
	                	  <label style="padding-right:5px;">Tolerance Weight(gram)</label>
  	            		  <input name="toleransiweight[]" id="toleransiweight" type="text" class="form-group" style="width:50px;" value="<?php echo $ToleransiWeight[$loop]; ?>" required=""/>
                      <?php if($loop != 0 && $loop != null) { ?>
  	            		   <a href="#" class="btn btn-danger btn-xs" onclick="confirm_modal('../pages/crud/PreliminaryProductQuotation_RemoveListProductAndTolerance.php?ID=<?php echo $ResultQuerySelectProductionData['id_rfq']."&LOOP=".$loop."&IDUSER=".$IdUser; ?>');"><i class='glyphicon glyphicon-remove'></i></a>
                      <?php }?>
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
                  <?php
                        $loop++;
                      }
                    }
                  ?>
                  <tr>
                    <td class="text-left">
                      <label style="padding-right:9px;">Product Weight(gram)</label>
                      <input name="productweight[]" id="productweight" type="text" class="form-group" style="width:50px;" />
                      <label style="padding-right:5px;">Tolerance Weight(gram)</label>
                    <input name="toleransiweight[]" id="toleransiweight" type="text" class="form-group" style="width:50px;" />
                    <button class="btn btn-success add-product btn-xs" type="button"><i class="glyphicon glyphicon-plus "></i></button>
                    </td>
                    <td class="text-left">
                    </td>
                  </tr>
		            </div>
		          </table>
		      </div>
              <table width="100%">
	            <div>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:23px;">Extrude Material/Total Weight(gram)</label>
                	  <input name="extrudematerial" id="extrudematerial" type="text" class="form-group" style="width:163px;" value="<?php echo $ResultQuerySelectProductionData['ext_material']; ?>" required/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:76px;">Cycle Time(Sec)</label>
            		  <input name="cycletime" id="cycletime" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['cycle_time']; ?>" required/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:83px;">M/C Size(mm)</label>
                	  <input name="morcsize" id="morcsize" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['mc_size']; ?>" required/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:96px;">Die Size(mm)</label>
                	  <input name="diesize" id="diesize" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['die_size']; ?>" required/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:30px;">Material Change Loss</label>
                	  <input name="materialchangeloss" id="materialchangeloss" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['material_change_loss']; ?>" required/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:120px;">Core Size</label>
                	  <input name="coresize" id="coresize" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['core_size']; ?>" required/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:99px;">Cavity(pcs)</label>
                	  <input name="cavity" id="cavity" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['cavity']; ?>" required/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:15px;">Preparation Time (Die/Core, Mold, Material)(minutes)</label>
                	  <input name="preparation" id="preparation" type="text" class="form-group" style="width:69px;" value="<?php echo $ResultQuerySelectProductionData['preparation_time']; ?>" required/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:91px;">Defect Ratio</label>
                	  <input name="defectratio" id="defectratio" type="text" class="form-group" style="width:250px;" placeholder="%" value="<?php echo $ResultQuerySelectProductionData['defect_ratio']; ?>" required/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:69px;">Production Qty/h</label>
                	  <input name="productionqty" id="productionqty" type="text" class="form-group" style="width:250px;" value="<?php echo $ResultQuerySelectProductionData['product_qty']; ?>" required/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <hr/>
	          <h3><strong>FINISHING PROCESS</strong></h3>
	          <br>
	        <div class="control-group after-add-processtime">
              <table width="100%">
	            <div>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:55px;">Part Name</label>
                	  <input name="partname" type="text" class="form-group" style="width:340px;" value="<?php echo $ResultQuerySelectProductionData['part_name']; ?>" required/>
	                </td>
	                <td class="text-left">
	                </td>
	              </tr>
                <?php
                  $ProcessName = explode(",",$ResultQuerySelectProductionData['process_name']);
                  $TimeSec = explode(",",$ResultQuerySelectProductionData['time_sec']);
                  $loop = 0;
                  foreach ($ProcessName as $values) {
                    if($values != null){
                ?>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:29px;">Process Name</label>
                    <input name="processname[]" type="text" class="form-group" style="width:340px;" value="<?php echo $values; ?>" required=""/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:23px;">Time (Sec)</label>
                    <input name="time[]" type="text" class="form-group" style="width:300px;" value="<?php echo $TimeSec[$loop]; ?>" required=""/>
                    <?php if($loop != 0 && $loop != null) { ?>
                      <a href="#" class="btn btn-danger btn-xs" onclick="confirm_modal('../pages/crud/PreliminaryBillOfMaterial_RemoveListProcessAndTime.php?ID=<?php echo $ResultQuerySelectProductionData['id_rfq']."&LOOP=".$loop."&IDUSER=".$IdUser; ?>');"><i class='glyphicon glyphicon-remove'></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php
                      $loop++;
                    }
                  }
                ?>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:29px;">Process Name</label>
                	  <input name="processname[]" type="text" class="form-group" style="width:340px;"/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:23px;">Time (Sec)</label>
            		  <input name="time[]" type="text" class="form-group" style="width:300px;"/>
            		  <button class="btn btn-success add-processtime btn-xs" type="button"><i class="glyphicon glyphicon-plus "></i></button>
	                </td>
	              </tr>
	            </div>
	          </table>
	      	</div>
	          <hr/>
	        <div class="control-group after-add-toolingprice">
	          <table width="100%">
	            <div>
                <?php
                  $ToolingName = explode(",",$ResultQuerySelectProductionData['tooling_name']);
                  $Price = explode(",",$ResultQuerySelectProductionData['price']);
                  $loop = 0;
                  foreach ($ToolingName as $values) {
                    if($values != null){
                ?>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:33px;">Tooling Name</label>
                    <input name="toolingname[]" type="text" class="form-group" style="width:340px;" value="<?php echo $values; ?>" required=""/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:25px;">Price (Rp)</label>
                    <input name="price[]" type="text" class="form-group" style="width:300px;" value="<?php echo $Price[$loop]; ?>" required=""/>
                    <?php if($loop != 0 && $loop != null) { ?>
                      <a href="#" class="btn btn-danger btn-xs" onclick="confirm_modal('../pages/crud/PreliminaryBillOfMaterial_RemoveListToolingAndPrice.php?ID=<?php echo $ResultQuerySelectProductionData['id_rfq']."&LOOP=".$loop."&IDUSER=".$IdUser; ?>');"><i class='glyphicon glyphicon-remove'></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php
                      $loop++;
                    }
                  }
                ?>
                <tr>
                  <td class="text-left">
                    <label style="padding-right:33px;">Tooling Name</label>
                    <input name="toolingname[]" type="text" class="form-group" style="width:340px;"/>
                  </td>
                  <td class="text-left">
                    <label style="padding-right:25px;">Price (Rp)</label>
                    <input name="price[]" type="text" class="form-group" style="width:300px;"/>
                    <button class="btn btn-success add-toolingprice btn-xs" type="button"><i class="glyphicon glyphicon-plus "></i></button>
                  </td>
                </tr>
	            </div>
	          </table>
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
            	  <textarea class="form-control" name="notes" rows="2" cols="40" required=""><?php echo $ResultQuerySelectProductionData['notes']; ?></textarea>
                 </td>
               </tr>
             </div>
            </table>
            <hr/>
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
                  $NameFile = explode(",",$ResultQuerySelectProductionData['name_doc_q']);
                  $SizeFile = explode(",",$ResultQuerySelectProductionData['size_doc_q']);
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
                            echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='file/PreliminaryProductQuotation/".$NameFile[$Loop-1]."'><i class='fa fa-folder-open'> View</i></a>"; 
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
                    <input name="document[]" type="file" accept="application/pdf" class="form-control" style="width:330px;"/>
                    
                      <div class="input-group-btn"> 
                        <button class="btn btn-success add-document" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                      </div>  
                    
                  </div>
              </div>
          	</div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="PreliminaryProductQuotation.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- End Content -->

    <!-- Material Batch Fields -->
    <div class="materialbatch hide">
      <div class="control-group" style="margin-top:10px">
        <table width="100%">
          <tr>
	        <td class="text-left">
	          <label style="padding-right:18px;">Material Name</label>
	    	  <input name="materialname[]" type="text" class="form-group" style="width:270px;"/>
	    	  <input name="materialpercen[]" type="text" class="form-group" style="width:50px;" placeholder="%"/>
	    	  <button class="btn btn-danger remove btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i></button>
	        </td>
	        <td class="text-left">
	          <label style="padding-right:35px;">Master Batch</label>
	    	  <input name="masterbatch[]" type="text" class="form-group" style="width:200px;"/>
	    	  <input name="masterbatchpercen[]" type="text" class="form-group" style="width:50px;" placeholder="%"/>
	    	  <button class="btn btn-danger remove btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i></button>
	        </td>
	      </tr>
        </table>
      </div>
    </div>
    <!-- End Material Batch Fields -->
    <!-- Product Fields -->
    <div class="product hide">
      <div class="control-group" style="margin-top:10px">
        <table width="100%">
          <tr>
	        <td class="text-left">
              <label style="padding-right:9px;">Product Weight(gram)</label>
        	  <input name="productweight[]" id="productweight" type="text" class="form-group" style="width:50px;" required=""/>
        	  <label style="padding-right:5px;">Tolerance Weight(gram)</label>
    		  <input name="toleransiweight[]" id="toleransiweight" type="text" class="form-group" style="width:50px;" required=""/>
    		  <button class="btn btn-danger remove btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i></button>
            </td>
            <td class="text-left">
            </td>
	      </tr>
        </table>
      </div>
    </div>
    <!-- End Product Fields -->
    <!-- Process Time Fields -->
    <div class="processtime hide">
      <div class="control-group" style="margin-top:10px">
        <table width="100%">
          <tr>
	        <td class="text-left">
	          <label style="padding-right:29px;">Process Name</label>
	    	  <input name="processname[]" type="text" class="form-group" style="width:340px;" required=""/>
	        </td>
	        <td class="text-left">
	          <label style="padding-right:23px;">Time (Sec)</label>
			  <input name="time[]" type="text" class="form-group" style="width:300px;" required=""/>
			  <button class="btn btn-danger remove btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i></button>
	        </td>
	      </tr>
        </table>
      </div>
    </div>
    <!-- End Process Time Batch Fields -->
    <!-- Process Time Fields -->
    <div class="toolingprice hide">
      <div class="control-group" style="margin-top:10px">
        <table width="100%">
          <tr>
            <td class="text-left">
              <label style="padding-right:33px;">Tooling Name</label>
        	  <input name="toolingname[]" type="text" class="form-group" style="width:340px;" required=""/>
            </td>
            <td class="text-left">
              <label style="padding-right:25px;">Price (Rp)</label>
    		  <input name="price[]" type="text" class="form-group" style="width:300px;" required=""/>
    		  <button class="btn btn-danger remove btn-xs" type="button"><i class="glyphicon glyphicon-remove"></i></button>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <!-- End Process Time Batch Fields -->
    <!-- Copy Document Fields -->
    <div class="document hide">
      <div class="control-group input-group" style="margin-top:10px">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-file-pdf-o"></i>
            </div>
            <input name="document[]" type="file" class="form-control" style="width:330px;" required="" />
            <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
          </div>
        </div>
    </div>
    <!-- End Copy Document Fields -->	

    <!-- Multiple Product -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-product").click(function(){ 
            var html = $(".product").html();
            $(".after-add-product").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple Product -->
    <!-- Multiple Material Batch -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-materialbatch").click(function(){ 
            var html = $(".materialbatch").html();
            $(".after-add-materialbatch").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple Material Batch -->
    <!-- Multiple Process Time Batch -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-processtime").click(function(){ 
            var html = $(".processtime").html();
            $(".after-add-processtime").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Multiple Process Time Batch -->
    <!-- Multiple Tooling Price Batch -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-toolingprice").click(function(){ 
            var html = $(".toolingprice").html();
            $(".after-add-toolingprice").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Tooling Price Time Batch -->
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

<?php
}
?>

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   