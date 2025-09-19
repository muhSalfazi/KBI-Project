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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Product Quotation</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_rfq.id_user = tbl_user.id_user INNER JOIN tbl_role ON tbl_user.id_role = tbl_role.id_role WHERE tbl_rfq.id_rfq = $IdRFQForm");
        $ResultQuerySelectRFQForm=mysqli_fetch_array($QuerySelectRFQForm);

        $QuerySelectBillOfMaterial = $mysqli->query("SELECT * FROM tbl_bill_of_material INNER JOIN tbl_rfq ON tbl_bill_of_material.id_rfq_bill = tbl_rfq.id_rfq WHERE tbl_bill_of_material.id_rfq_bill = $IdRFQForm");
	    $ResultQuerySelectBillOfMaterial = mysqli_fetch_array($QuerySelectBillOfMaterial);

	    $QuerySelectPackagingAndTransport = $mysqli->query("SELECT * FROM tbl_packaging INNER JOIN tbl_transport ON tbl_packaging.id_packaging = tbl_transport.id_pack WHERE tbl_packaging.idrfq_pack = $IdRFQForm");
	    $ResultQuerySelectPackagingAndTransport = mysqli_fetch_array($QuerySelectPackagingAndTransport);

        $QuerySelectAllProductionData = $mysqli->query("SELECT * FROM tbl_product_q INNER JOIN tbl_rfq ON tbl_product_q.idrfq_p = tbl_rfq.id_rfq WHERE tbl_product_q.idrfq_p = $IdRFQForm");
	    $ResultQuerySelectAllProductionData = mysqli_fetch_array($QuerySelectAllProductionData);
      ?>

      <div class="modal-content">
        <div class="modal-header" style="padding:35px;">
          <center><h4 class="modal-title"><b>Product Quotation Form</b></h4></center>
        </div>
        <div class="modal-body">
          <form action="../pages/crud/ProductQuotation_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?php echo $ResultQuerySelectRFQForm['id_rfq']; ?>" />
            <input type="hidden" name="projectname" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" />
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		        <div>
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
		              <label style="padding-right:95px;">Due Date</label>
		              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectRFQForm['deadline_de']; ?>" disabled/>
		            </td>
		            <td class="text-left">
		              <label style="padding-right:98px;">Issue Date</label>
		              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['issue_date']; ?>" disabled/>
		            </td>
		          </tr>
		          <tr>
		            <td class="text-left">
		              <label style="padding-right:80px;">Cavity(pcs)</label>
		              <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:350px;" value="<?php echo $ResultQuerySelectAllProductionData['cavity']; ?>" disabled/>
		            </td>
		            <td class="text-left">
		              <label style="padding-right:143px;">PIC</label>
		              <input name="pic" id="pic" type="text" class="form-group" style="width:280px;" required/>
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
	          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:85px;">Project Name</label>
                	  <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['project_name']; ?>" disabled/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:55px;">Part Number</label>
                	  <input name="txtpartname" id="txtpartname" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['part_no']; ?>" disabled/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:55px;">Date</label>
	                  <input type="textdate" value="<?php echo date('j-F-Y');?>" class="form-group" style="width:280px;" disabled/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:53px;">Customer</label>
                	  <input name="issuedate" id="issuedate" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['customer_name']; ?>" disabled/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:70px;">Part Name</label>
            		  <input name="txtpartno" id="txtpartno" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['part_name']; ?>" disabled/>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:55px;">No</label>
                	  <input name="txtno" id="txtno" type="text" class="form-group" style="width:280px;"/>
	                </td>
	              </tr>
	              <tr>
	              	<td></td>
	              	<td class="text-left">
	                  <label style="padding-right:55px;">Mass Pro (SOP)</label>
                	  <input name="txtrev" id="txtrev" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['sop']; ?>" disabled/>
	                </td>
	              	<td class="text-left">
	                  <label style="padding-right:55px;">Rev</label>
                	  <input name="txtrev" id="txtrev" type="text" class="form-group" style="width:280px;"/>
	                </td>
	              </tr>
	              <tr>
	              	<td></td>
	              	<td class="text-left">
	                  <label style="padding-right:55px;">Forecast per month</label>
                	  <input name="txtforecastpermonth" id="txtrev" type="text" class="form-group" style="width:280px;" value="<?php echo $ResultQuerySelectRFQForm['volume']; ?>" disabled/>
	                </td>
	                <td></td>
	              </tr>
	              <tr>
	              	<td></td>
	              	<td class="text-left">
	                  <label style="padding-right:55px;">Depreciation Qty</label>
                	  <input name="txtdepreciationqty" id="txtrev" type="text" class="form-group" style="width:280px;"/>
	                </td>
	                <td></td>
	              </tr>
	              <tr>
	              	<td></td>
	              	<td class="text-left">
	                  <label style="padding-right:55px;">Exchange Rate(Rp)</label>
                	  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:280px;"/>
	                </td>
	                <td></td>
	              </tr>
	            </div>
	          </table>
              <hr/>
	          <h3><strong>RAW MATERIAL</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
	                <?php
	                  $ValueMaterial = '';
	                  $Material = explode(",",$ResultQuerySelectAllProductionData['mat_name']);
	                  $loop = 0;
	                  foreach ($Material as $values) {
	                  	if($values != null){
	                  		$loop++;
	                  		if($loop >= 2){
	                  			$ValueMaterial = $ValueMaterial.' + '.$values;
	                  		}else{
	                  			$ValueMaterial = $ValueMaterial.$values;
	                  		}
	                  	}
	                  }
	                ?>
	                  <label style="padding-right:10px;"><?php echo $ValueMaterial; ?></label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Weight (kg)</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Price/kg</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Mixed</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Loss</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cost</label>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">Extrude Material/Total Weight</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtextrudeweight" id="txtextrudeweight" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtextrude" id="txtextrude" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtextrude" id="txtextrude" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtextrude" id="txtextrude" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtextrude" id="txtextrude" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Product Material </label>
	                </td>
	                <td class="text-center">
	                  <input name="txtproductweight" id="txtproductweight" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtproduct" id="txtproduct" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtproduct" id="txtproduct" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtproduct" id="txtproduct" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtproduct" id="txtproduct" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	              </tr>
	              <?php
	              	$ValueMaterial = '';
	                $MaterialName = explode(",",$ResultQuerySelectAllProductionData['mat_name']);
	                $MaterialPersen = explode(",",$ResultQuerySelectAllProductionData['mat_percent']);
	                $loop = 0;
	                foreach ($MaterialName as $values) {
	                  	if($values != null){
	                  	?>
	                  	<tr>
			              	<td class="text-left">
			                  <label style="padding-right:10px;"><?php echo 'Material '.$values; ?></label>
			                </td>
			                <td class="text-center">
			                  <input name="txtmaterialweight[]" id="txtmaterialweight<?php echo $loop+1; ?>" type="text" class="form-group" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtmaterialprice[]" id="txtmaterialprice<?php echo $loop+1; ?>" type="text" class="form-group" style="width:120px;"/>
			                </td>
			                <td class="text-center">
			                  <input name="txtmaterialmixed[]" id="txtmaterialmixed<?php echo $loop+1; ?>" type="text" class="form-group" value="<?php echo $MaterialPersen[$loop]; ?>" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtmaterial" id="txtmaterial" type="text" class="form-group" style="width:120px;" disabled/>
			                </td>
			                <td class="text-center">
			                  <input name="txtmaterialcost[]" id="txtmaterialcost<?php echo $loop+1; ?>" type="text" class="form-group" style="width:120px;"/>
			                </td>
			            </tr>
	                  	<?php
	                  	$loop++;
	                  	}
	                }
	              ?>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Returnable material cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtreturnweight" id="txtreturnweight" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtreturnprice" id="txtreturnprice" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtreturn" id="txtreturn" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtreturnloss" id="txtreturnloss" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtreturncost" id="txtreturncost" type="text" class="form-group" style="width:120px;" />
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Material change loss</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtchangelossweight" id="txtchangelossweight" type="text" class="form-group" value="<?php echo $ResultQuerySelectAllProductionData['material_change_loss']; ?>" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtchangelossprice" id="txtchangelossprice" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtchangeloss" id="txtchangeloss" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtchangelossloss" id="txtchangelossloss" type="text" class="form-group" style="width:120px;" value="<?php echo $ResultQuerySelectAllProductionData['defect_ratio']; ?>" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtchangelosscost" id="txtchangelosscost" type="text" class="form-group" style="width:120px;" />
	                </td>
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total Cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="rawmaterialtotalcost" id="rawmaterialtotalcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <div class="modal-footer">
	          	<a class="btn btn-warning" style="width:120px;" onclick="getGenerate()"><i class="fa fa-refresh"></i> GENERATE</a>
              </div>
	          <hr/>
	          <h3><strong>Blow Molding</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Machine Size : <?php echo $ResultQuerySelectAllProductionData['mc_size']; ?></label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cycle time (min)</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cavities</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Machine/minute</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">NG Ratio</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cost</label>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">Blow Molding Preparation</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtpreparationtimeblowmoldpreparation" id="txtpreparationtimeblowmoldpreparation" type="text" class="form-group" value="<?php echo $ResultQuerySelectAllProductionData['preparation_time']; ?>" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtcavityblowmoldpreparation" id="txtcavityblowmoldpreparation" type="text" class="form-group" value="<?php echo $ResultQuerySelectAllProductionData['cavity']; ?>" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtmachineblowmoldpreparation" id="txtmachineblowmoldpreparation" type="text" class="form-group" style="width:97px;" required/>
	                  <a class="btn btn-warning btn-xs" style="width:23px;" onclick="getValueMachineBlowMoldPreparation()"><i class="fa fa-refresh"></i></a>
	                </td>
	                <td class="text-center">
	                  <input type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtcostblowmoldpreparation" id="txtcostblowmoldpreparation" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Blow Molding</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtpreparationtimeblowmold" id="txtpreparationtimeblowmold" type="text" class="form-group" value="<?php $value = $ResultQuerySelectAllProductionData['cycle_time'] / 60; echo number_format($value); ?>" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtcavityblowmold" id="txtcavityblowmold" type="text" class="form-group" value="<?php echo $ResultQuerySelectAllProductionData['cavity']; ?>" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtmachineblowmold" id="txtmachineblowmold" type="text" class="form-group" style="width:97px;" required/>
	                  <a class="btn btn-warning btn-xs" style="width:23px;" onclick="getValueMachineBlowMold()"><i class="fa fa-refresh"></i></a>
	                </td>
	                <td class="text-center">
	                  <input name="txtngratioblowmold" id="txtngratiomachineblowmold" type="text" class="form-group" value="<?php echo $ResultQuerySelectAllProductionData['defect_ratio'].'%'; ?>" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtcostblowmold" id="txtcostblowmold" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total Cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtcostblowmolding" id="txtcostblowmolding" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <div class="modal-footer">
	          	<a class="btn btn-warning" style="width:120px;" onclick="getValueCostBlowMolding();"><i class="fa fa-refresh"></i> GENERATE</a>
              </div>
	          <hr/>
	          <h3><strong>Finishing Process</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-center">
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cycle time (sec)</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Man hour /minute</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">NG Ratio</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cost</label>
	                </td>
	              </tr>
	              <?php
	                $ProcessName = explode(",",$ResultQuerySelectAllProductionData['process_name']);
	                $TimeSec = explode(",",$ResultQuerySelectAllProductionData['time_sec']);
	                $loop = 0;
	                foreach ($ProcessName as $values) {
	                  	if($values != null){
	                  		$loop++;
	                  	?>
	                  	<tr>
			              	<td class="text-left">
			                  <label style="padding-right:10px;"><?php echo $loop.'. '.$values; ?></label>
			                </td>
			                <td class="text-center">
			                  <input name="txtcycletimefinishingprocess[]" id="txtcycletimefinishingprocess<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $TimeSec[$loop-1]; ?>" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtmanhourfinishingprocess[]" id="txtmanhourfinishingprocess<?php echo $loop; ?>" type="text" class="form-group" style="width:120px;"/>
			                </td>
			                <td class="text-center">
			                  <input name="txtngratiofinishingprocess[]" id="txtngratiofinishingprocess<?php echo $loop; ?>" type="text" class="form-group" style="width:120px;"/>
			                </td>
			                <td class="text-center">
			                  <input name="txtcostfinishingprocess[]" id="txtcostfinishingprocess<?php echo $loop; ?>" type="text" class="form-group" style="width:120px;" readonly/>
			                </td>
			            </tr>
	                  	<?php
	                  	}
	                }
	              ?>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total Cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="txttotalcostfinishingprocess" id="txttotalcostfinishingprocess" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <div class="modal-footer">
	          	<a class="btn btn-warning" style="width:120px;" onclick="getValueCostFinishingProcess();"><i class="fa fa-refresh"></i> GENERATE</a>
              </div>
	          <hr/>
	          <h3><strong>Purchase Parts</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Size(mm)</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Qty (pcs)</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Price</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Total</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Supplier Name</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Remark</label>
	                </td>
	              </tr>
	              <?php
	                $PartNameBill = explode(",",$ResultQuerySelectBillOfMaterial['part_name_bill']);
	                $LevelBill = explode(",",$ResultQuerySelectBillOfMaterial['level_bill']);
	                $SizeBill = explode(",",$ResultQuerySelectBillOfMaterial['size']);
	                $QtyBill = explode(",",$ResultQuerySelectBillOfMaterial['qty']);
	                $Price = explode(",",$ResultQuerySelectBillOfMaterial['price']);
	                $Supplier = explode(",",$ResultQuerySelectBillOfMaterial['supplier']);
	                $loopPBOM = 0;
	                $loopBOM = 0;
	                foreach ($PartNameBill as $values) {
	                	$loopPBOM++;
	                  	if($values != null && $LevelBill[$loopPBOM-1] > 1){
	                  		$loopBOM++;
	                  	?>
	                  	<tr>
			              	<td class="text-left">
			                  <label style="padding-right:10px;"><?php echo $loopBOM.'. '.$values; ?></label>
			                </td>
			                <td class="text-center">
			                  <input name="txtsizepurchaseparts[]" id="txtsizepurchaseparts<?php echo $loopBOM; ?>" type="text" class="form-group" value="<?php echo $SizeBill[$loopPBOM-1]; ?>" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtqtypurchaseparts[]" id="txtqtypurchaseparts<?php echo $loopBOM; ?>" type="text" class="form-group" value="<?php echo $QtyBill[$loopPBOM-1]; ?>" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtpricepurchaseparts[]" id="txtpricepurchaseparts<?php echo $loopBOM; ?>" type="text" class="form-group" value="<?php echo $Price[$loopBOM-1]; ?>" style="width:120px;"/>
			                </td>
			                <td class="text-center">
			                  <input name="txttotalpurchaseparts[]" id="txttotalpurchaseparts<?php echo $loopBOM; ?>" type="text" class="form-group" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtsupplierpurchaseparts[]" id="txtsupplierpurchaseparts<?php echo $loopBOM; ?>" type="text" class="form-group" value="<?php echo $Supplier[$loopBOM-1]; ?>" style="width:120px;" readonly/>
			                </td>
			                <td class="text-center">
			                  <input name="txtremarkpurchaseparts[]" id="txtremarkpurchaseparts<?php echo $loopBOM; ?>" type="text" class="form-group" style="width:120px;"/>
			                </td>
			            </tr>
	                  	<?php
	                  	}
	                }
	              ?>
	              <tr>
	              	<td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtsubtotalpurchaseparts" id="txtsubtotalpurchaseparts" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <div class="modal-footer">
	          	<a class="btn btn-warning" style="width:120px;" onclick="getValueTotalPurchaseParts();"><i class="fa fa-refresh"></i> GENERATE</a>
              </div>
	          <hr/>
	          <h3><strong>Packaging & Transportation</strong></h3>
	          <br>
	          	<div class="control-group after-add-paintingcost">
	              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Packging Type</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Spec(mm)</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Price</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Est Qty</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Qty/Box</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Price/Pc</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:1px;">Dep Qty</label>
		                </td>
		              </tr>
		              <?php
		                $Packging = explode(",",$ResultQuerySelectPackagingAndTransport['packaging']);
		                $Spec = explode(",",$ResultQuerySelectPackagingAndTransport['spec']);
		                $Price = explode(",",$ResultQuerySelectPackagingAndTransport['price']);
		                $EstQty = explode(",",$ResultQuerySelectPackagingAndTransport['est_qty']);
		                $QtyBox = explode(",",$ResultQuerySelectPackagingAndTransport['qty_box']);
		                $PricePc = explode(",",$ResultQuerySelectPackagingAndTransport['price_pc']);
		                $DepQty = explode(",",$ResultQuerySelectPackagingAndTransport['dep_qty']);
		                $TotalPackagingTransport = 0;
		                $AllPricePc = 0;
		                $loop = 0;
		                foreach ($Packging as $values) {
		                  	if($values != null){
		                  		$loop++;
		                  		$QuerySelectTypePackaging=mysqli_query($mysqli, "SELECT * FROM tbl_type_packaging WHERE tbl_type_packaging.id_type_packaging = ".$values."");
		                		$ResultQuerySelectTypePackaging=mysqli_fetch_array($QuerySelectTypePackaging); 
		                  	?>
		                  	<tr>
				                <td class="text-center">
				                  <input name="txtpackagingpacktrans[]" id="txtpackagingpacktrans<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $ResultQuerySelectTypePackaging['type_packaging']; ?>" style="width:120px;" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txtqtypurchaseparts[]" id="txtqtypurchaseparts<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $Spec[$loop-1]; ?>" style="width:120px;" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txtpricepurchaseparts[]" id="txtpricepurchaseparts<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $Price[$loop-1]; ?>" style="width:120px;" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txttotalpurchaseparts[]" id="txttotalpurchaseparts<?php echo $loop; ?>" type="text" class="form-group" style="width:120px;" value="<?php echo $EstQty[$loop-1]; ?>" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txtsupplierpurchaseparts[]" id="txtsupplierpurchaseparts<?php echo $loop; ?>" type="text" class="form-group" style="width:120px;" value="<?php echo $QtyBox[$loop-1]; ?>" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txtremarkpurchaseparts[]" id="txtremarkpurchaseparts<?php echo $loop; ?>" type="text" class="form-group" style="width:120px;" value="<?php echo $PricePc[$loop-1]; ?>" readonly/>
				                  <?php $AllPricePc = $AllPricePc + $PricePc[$loop-1]; ?>
				                </td>
				                <td class="text-center">
				                  <input name="txtpackagingpacktrans[]" id="txtpackagingpacktrans<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $DepQty[$loop-1]; ?>" style="width:120px;" readonly/>
				                </td>
				            </tr>
		                  	<?php
		                  	}
		                }
		              ?>
		              <tr>
		              	<td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		              </tr>
		              <tr>
		              	<td class="text-left">
		              		<label>TOTAL</label>
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                </td>
		                <td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;" value="<?php echo $AllPricePc; ?>" readonly/>
		                  <?php $TotalPackagingTransport = $TotalPackagingTransport + $AllPricePc; ?>
		                </td>
		                <td class="text-center">
		                </td>
		              </tr>
		            </div>
		          </table>
		          <table width="100%" class="table table-striped table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td class="text-left">
		                  <label>Transportation</label>
		                </td>
		                <td class="text-left">
		                  <?php echo $ResultQuerySelectPackagingAndTransport['trans']; ?>
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
		              <tr>
		                <td class="text-left">
		                  <label>1 time delivery</label>
		                </td>
		                <td class="text-left">
		                  <?php echo $ResultQuerySelectPackagingAndTransport['time_deliv']; ?>
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
		              <tr>
		                <td class="text-left">
		                  <label>Tracking Capa Ratio</label>
		                </td>
		                <td class="text-left">
		                  <?php echo $ResultQuerySelectPackagingAndTransport['track_capa']; ?>
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
		              <tr>
		                <td class="text-left">
		                  <label>Transport Cost</label>
		                </td>
		                <td class="text-left">
		                  <?php echo $ResultQuerySelectPackagingAndTransport['trans_cost']; ?>
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
		              <tr>
		                <td class="text-left">
		                  <label>Transport Cost/pcs</label>
		                </td>
		                <td class="text-left">
		                  	<?php echo $ResultQuerySelectPackagingAndTransport['transCost_pcs']; ?>
		                  	<?php $TotalPackagingTransport = $TotalPackagingTransport + $ResultQuerySelectPackagingAndTransport['transCost_pcs']; ?>
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
		            </div>
		          </table>
		          <label>Initial Investment for Delivery & Process</label>
		          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Type Packging</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Price</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Qty</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Ammount</label>
		                </td>
		              </tr>
		              <?php
		                $Ammount = 0;
		                $loop = 0;
		                foreach ($Packging as $values) {
		                	$loop++;
		                  	if($values != null && $DepQty[$loop-1] > 0){
		                  		$QuerySelectTypePackaging=mysqli_query($mysqli, "SELECT * FROM tbl_type_packaging WHERE tbl_type_packaging.id_type_packaging = ".$values."");
		                		$ResultQuerySelectTypePackaging=mysqli_fetch_array($QuerySelectTypePackaging); 
		                  	?>
		                  	<tr>
				                <td class="text-center">
				                  <input name="txtpackagingpacktrans[]" id="txtpackagingpacktrans<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $ResultQuerySelectTypePackaging['type_packaging']; ?>" style="width:200px;" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txtpricepurchaseparts[]" id="txtpricepurchaseparts<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $Price[$loop-1]; ?>" style="width:200px;" readonly/>
				                </td>
				                <td class="text-center">
				                  <input name="txttotalpurchaseparts[]" id="txttotalpurchaseparts<?php echo $loop; ?>" type="text" class="form-group" style="width:200px;" value="<?php echo $EstQty[$loop-1]; ?>" readonly/>
				                </td>
				                <td class="text-center">
				                  <?php $Ammount = $Price[$loop-1] * $EstQty[$loop-1]; ?>
				                  <input name="txtpackagingpacktrans[]" id="txtpackagingpacktrans<?php echo $loop; ?>" type="text" class="form-group" value="<?php echo $Ammount; ?>" style="width:200px;" readonly/>
				                </td>
				            </tr>
		                  	<?php
		                  	}
		                }
		              ?>
		            </div>
		          </table>
		          ** Packing cost including lost & repairing cost 20% per year.
		          <br><br>
		          <table width="100%" class="table table-striped table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td class="text-left">
		                  <label>Total Packaging & Transportation : </label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:690px;width:120px;">Rp.<?php echo $TotalPackagingTransport; ?></label>
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		                <td class="text-left">
		                </td>
		              </tr>
		            </div>
		          </table>
			    </div>
	          <hr/>
	          <h3><strong>Painting Cost</strong></h3>
	          <br>
	          	<div class="control-group after-add-paintingcost">
	              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Description</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Qty (pcs)</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Price</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Total</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Supplier Name</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Remark</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:1px;">Add</label>
		                </td>
		              </tr>
		              <tr>
		              	<td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td class="text-center">
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td class="text-center">
		                  <div class="input-group-btn"> 
		                    <button class="btn btn-success add-paintingcost" type="button"><i class="glyphicon glyphicon-plus"></i></button>
		                  </div>  
		                </td>
		              </tr>
		            </div>
		          </table>
			     </div>
			     <table width="100%" class="table table-striped table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td></td>
		                <td></td>
		                <td></td>
		                <td style="padding-right:390px;"></td>
		                <td class="text-right">
		                </td>
		                <td class="text-center">
		                  <label style="padding-right:10px;">Total</label>
		                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
		                </td>
		                <td></td>
		              </tr>
		            </div>
		        </table>
	          <hr/>
	          <h3><strong>Tooling Cost</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Tooling Name</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Price</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Depreciation Qty</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Depreciation Cost</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Supplier</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Remark</label>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <input name="txttoolingname" id="txttoolingname" type="text" class="form-group" style="width:150px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtpricetoolingcost" id="txtpricetoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationqtylitetoolingcost" id="txtdepreciationqtylitetoolingcost" type="text" class="form-group" style="width:30px;"/>
	                  <input name="txtdepreciationqtybigtoolingcost" id="txtdepreciationqtybigtoolingcost" type="text" class="form-group" style="width:90px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationcosttoolingcost" id="txtdepreciationcosttoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtsuppliertoolingcost" id="txtsuppliertoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtremarktoolingcost" id="txtremarktoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	              	  <label style="padding-right:27px;">Performance Test (incl jig)</label>
	                  <!-- <input name="txtexchangerate" id="txtrev" type="text" class="form-group" value="Performance Test (incl jig)" style="width:120px;" readonly/> -->
	                </td>
	                <td class="text-center">
	                  <input name="txtpricetoolingcostperformance" id="txtpricetoolingcostperformance" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationqtylitetoolingcostperformance" id="txtdepreciationqtylitetoolingcostperformance" type="text" class="form-group" style="width:30px;" readonly/>
	                  <input name="txtdepreciationqtybigtoolingcostperformance" id="txtdepreciationqtybigtoolingcostperformance" type="text" class="form-group" style="width:90px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationcosttoolingcostperformance" id="txtdepreciationcosttoolingcostperformance" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtsuppliertoolingcostperformance" id="txtsuppliertoolingcostperformance" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtremarktoolingcostperformance" id="txtremarktoolingcostperformance" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	              		<label style="padding-right:27px;">Trial Cost</label>
	                  <!-- <input name="txtexchangerate" id="txtrev" type="text" class="form-group" value="Trial Cost" style="width:120px;" readonly/> -->
	                </td>
	                <td class="text-center">
	                  <input name="txtpricetoolingcosttrialcost" id="txtpricetoolingcosttrialcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationqtylitetoolingcosttrialcost" id="txtdepreciationqtylitetoolingcosttrialcost" type="text" class="form-group" style="width:30px;" readonly/>
	                  <input name="txtdepreciationqtybigtoolingcosttrialcost" id="txtdepreciationqtybigtoolingcosttrialcost" type="text" class="form-group" style="width:90px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationcosttoolingcosttrialcost" id="txtdepreciationcosttoolingcosttrialcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtsuppliertoolingcosttrialcost" id="txtsuppliertoolingcosttrialcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtremarktoolingcosttrialcost" id="txtremarktoolingcosttrialcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	              </tr>

	              <tr>
	              	<td class="text-left">
	              		<label style="padding-right:45px;">TOTAL TOOLING COST</label>
	                  <!-- <input name="txtexchangerate" id="txtrev" type="text" class="form-group" value="TOTAL TOOLING COST" style="width:120px;" readonly/> -->
	                </td>
	                <td class="text-center">
	                  <input name="txtpricetoolingcosttotaltoolingcost" id="txtpricetoolingcosttotaltoolingcost" type="text" class="form-group" style="width:120px;" readonly/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationqtytoolingcosttotaltoolingcost" id="txtdepreciationqtytoolingcosttotaltoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationcosttoolingcosttotaltoolingcost" id="txtdepreciationcosttoolingcosttotaltoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtsuppliertoolingcosttotaltoolingcost" id="txtsuppliertoolingcosttotaltoolingcost" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtremarktoolingcosttotaltoolingcost" id="txtremarktoolingcosttotaltoolingcost" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	              		<label style="padding-right:27px;">Tooling Interest 10%</label>
	                  <!-- <input name="txtexchangerate" id="txtrev" type="text" class="form-group" value="Tooling Interest 10%" style="width:120px;" readonly/> -->
	                </td>
	                <td class="text-center">
	                  <input name="txtpricetoolingcosttoolinginterest" id="txtpricetoolingcosttoolinginterest" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationqtytoolingcosttoolinginterest" id="txtdepreciationqtytoolingcosttoolinginterest" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtdepreciationcosttoolingcosttoolinginterest" id="txtdepreciationcosttoolingcosttoolinginterest" type="text" class="form-group" style="width:120px;"/>
	                </td>
	                <td class="text-center">
	                  <input name="txtsuppliertoolingcosttoolinginterest" id="txtsuppliertoolingcosttoolinginterest" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	                <td class="text-center">
	                  <input name="txtremarktoolingcosttoolinginterest" id="txtremarktoolingcosttoolinginterest" type="text" class="form-group" style="width:120px;" disabled/>
	                </td>
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total Depreciation Cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="txttotaldepreciationcosttoolingcost" id="txttotaldepreciationcosttoolingcost" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <div class="modal-footer">
	          	<a class="btn btn-warning" style="width:120px;" onclick="getValueToolingCost();"><i class="fa fa-refresh"></i> GENERATE</a>
              </div>
            <label> </label> <!-- Pengatur Jarak -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
              <a href="ProductQuotation.php" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
    <!-- End Content -->

    <!-- Painting Cost Fields -->
    <div class="paintingcost hide">
      <div class="control-group" style="margin-top:10px">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	        <div>
	          <tr>
	          	<td class="text-center">
	              <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	            </td>
	            <td class="text-center">
	              <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	            </td>
	            <td class="text-center">
	              <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	            </td>
	            <td class="text-center">
	              <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	            </td>
	            <td class="text-center">
	              <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	            </td>
	            <td class="text-center">
	              <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	            </td>
	            <td class="text-center">
	              <div class="input-group-btn"> 
	                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
	              </div>  
	            </td>
	          </tr>
	        </div>
      	</table>
      </div>
    </div>
    <!-- End Painting Cost Fields -->

    <script type="text/javascript">
      function getGenerate(){

        //Mengkalkulasi Weight Material
        var gettxtproductweight = document.getElementById("txtproductweight").value;
        var loop = 1;
        var totalmaterialweight = 0

        while(document.getElementById("txtmaterialmixed".concat(loop))){
        	var valuesmixed = document.getElementById("txtmaterialmixed".concat(loop)).value;
        	var real_value = valuesmixed * gettxtproductweight;
        	//untuk bagi 1000
        	real_value = real_value / 1000;
        	totalmaterialweight = totalmaterialweight + real_value;
        	document.getElementById("txtmaterialweight".concat(loop)).value = real_value;
        	loop++;
        }
        //untuk bagi 1000
        gettxtproductweight = gettxtproductweight / 1000;
        document.getElementById("txtproductweight").value = gettxtproductweight;
        //End Mengkalkulasi Weight Material


        //Mengkalkulasi Weight Returnable
        var gettxtreturnweight = document.getElementById("txtreturnweight").value;
        var valueweightreturnable = gettxtproductweight - totalmaterialweight / <?php echo $ResultQuerySelectAllProductionData['cavity']; ?>;

        document.getElementById("txtreturnweight").value = valueweightreturnable;
        //End Mengkalkulasi Weight Returnable

        var totalpricematerial = 0;
        var looping = loop;
        while(looping > 0){
        	var pricematerial = document.getElementById("txtmaterialprice".concat(looping)).value * document.getElementById("txtmaterialmixed".concat(looping)).value;
        	totalpricematerial = totalpricematerial + pricematerial;
        	looping = looping - 1;
        }
        document.getElementById("txtreturnprice").value = totalpricematerial;

      }
    </script>

    <!-- BLOW MOLDING -->
    <script type="text/javascript">
      function getValueMachineBlowMoldPreparation(){
        var getMachineBlowMoldPreparation = document.getElementById("txtmachineblowmoldpreparation").value;
        document.getElementById("txtmachineblowmold").value=getMachineBlowMoldPreparation;
      }
    </script>

    <script type="text/javascript">
      function getValueMachineBlowMold(){
        var getMachineBlowMold = document.getElementById("txtmachineblowmold").value;
        document.getElementById("txtmachineblowmoldpreparation").value=getMachineBlowMold;
      }
    </script>

    <script type="text/javascript">
      function getValueCostBlowMolding(){
      	var getPreparationTimeBlowMoldPreparation = document.getElementById("txtpreparationtimeblowmoldpreparation").value;
        var getMachineBlowMoldPreparation = document.getElementById("txtmachineblowmoldpreparation").value;
        var getCavityBlowMoldPreparation = document.getElementById("txtcavityblowmoldpreparation").value;

        var getPreparationTimeBlowMold = document.getElementById("txtpreparationtimeblowmold").value;
        var getMachineBlowMold = document.getElementById("txtmachineblowmold").value;
        var getCavityBlowMold = document.getElementById("txtcavityblowmold").value;
        var getTxtNgRatioBlowMold = document.getElementById("txtngratiomachineblowmold").value;
        var getNgRatioBlowMold = new String(getTxtNgRatioBlowMold.split("%",1));

        var ValueCostBlowMoldPreparation = 0;
        var ValueCostBlowMold = 0;
        var ResultCostBlowMolding = 0;

        var ValueCostBlowMoldPreparation = getPreparationTimeBlowMoldPreparation * getMachineBlowMoldPreparation / <?php echo $ResultQuerySelectRFQForm['volume']; ?>;
        var ValueCostBlowMoldPreparation = ValueCostBlowMoldPreparation / getCavityBlowMoldPreparation;

        var ValueCostBlowMold = getPreparationTimeBlowMold * getMachineBlowMold;
        var ValueFormulaNgRatioBlowMold = 100 - getNgRatioBlowMold;
        var ValueCostBlowMold = ValueCostBlowMold / ValueFormulaNgRatioBlowMold / getCavityBlowMold;

        var ValueCostBlowMold = ValueCostBlowMold / getCavityBlowMoldPreparation;

        ResultCostBlowMolding = ValueCostBlowMoldPreparation + ValueCostBlowMold;

        //Result
        document.getElementById("txtcostblowmoldpreparation").value=ValueCostBlowMoldPreparation;
        document.getElementById("txtcostblowmold").value=ValueCostBlowMold;
        document.getElementById("txtcostblowmolding").value=ResultCostBlowMolding;
      }
    </script>
    <!-- END BLOW MOLDING -->

    <!-- FINISHING PROCESS -->
    <script type="text/javascript">
      function getValueCostFinishingProcess(){
        var ValueAllCost = 0;
        var loop = 1;
        while(document.getElementById("txtmaterialmixed".concat(loop))){
        	var getCycleTimeFinishingProcess = document.getElementById("txtcycletimefinishingprocess".concat(loop)).value;
        	var getManHourFinishingProcess = document.getElementById("txtmanhourfinishingprocess".concat(loop)).value;
        	var getNgRatioFinishingProcess = document.getElementById("txtngratiofinishingprocess".concat(loop)).value;

        	var ValueCycleTimeFinishingProcess = getCycleTimeFinishingProcess / 60;
        	var ValueNgRatioFinishingProcess = 100 - getNgRatioFinishingProcess;
        	var ValueCostFinishingProcess = ValueCycleTimeFinishingProcess * getManHourFinishingProcess / ValueNgRatioFinishingProcess;
        	
        	document.getElementById("txtcostfinishingprocess".concat(loop)).value=ValueCostFinishingProcess;
        	ValueAllCost = ValueAllCost + ValueCostFinishingProcess;

        	loop++;
        }
        document.getElementById("txttotalcostfinishingprocess").value=ValueAllCost;
      }
    </script>
    <!-- END FINISHING PROCESS -->

    <!-- Purchase Parts -->
    <script type="text/javascript">
      function getValueTotalPurchaseParts(){
        var ValueAllTotal = 0;
        var loop = 1;
        while(document.getElementById("txtsizepurchaseparts".concat(loop))){
        	var getSizePurchaseParts = document.getElementById("txtsizepurchaseparts".concat(loop)).value;
        	var getQtyPurchaseParts = document.getElementById("txtqtypurchaseparts".concat(loop)).value;
        	var getPricePurchaseParts = document.getElementById("txtpricepurchaseparts".concat(loop)).value;

        	var ValueTotalPurchaseParts = getQtyPurchaseParts * getPricePurchaseParts;
        	document.getElementById("txttotalpurchaseparts".concat(loop)).value=ValueTotalPurchaseParts;

        	ValueAllTotal = ValueAllTotal + ValueTotalPurchaseParts;

        	loop++;
        }
        document.getElementById("txtsubtotalpurchaseparts").value=ValueAllTotal;
      }
    </script>
    <!-- END Purchase Parts -->

    <!-- Tooling Cost -->
    <script type="text/javascript">
      function getValueToolingCost(){
        var ValueTotalPriceToolingCost = 0;
        var ValueTotalDepreciationQtyToolingCost = 0;
        var ValueTotalDepreciationCostToolingCost = 0;
        // var loop = 1;
        // while(document.getElementById("txtsizepurchaseparts".concat(loop))){
        // 	var getSizePurchaseParts = document.getElementById("txtsizepurchaseparts".concat(loop)).value;
        // 	var getQtyPurchaseParts = document.getElementById("txtqtypurchaseparts".concat(loop)).value;
        // 	var getPricePurchaseParts = document.getElementById("txtpricepurchaseparts".concat(loop)).value;

        // 	var ValueTotalPurchaseParts = getQtyPurchaseParts * getPricePurchaseParts;
        // 	document.getElementById("txttotalpurchaseparts".concat(loop)).value=ValueTotalPurchaseParts;

        // 	ValueAllTotal = ValueAllTotal + ValueTotalPurchaseParts;

        // 	loop++;
        // }
        var getDepQtyLiteToolingCost = document.getElementById("txtdepreciationqtylitetoolingcost").value;
        document.getElementById("txtdepreciationqtybigtoolingcost").value = getDepQtyLiteToolingCost * <?php echo $ResultQuerySelectRFQForm['volume']; ?>;
        var getPriceToolingCost = document.getElementById("txtpricetoolingcost").value;
        var getDepQtyBigToolingCost = document.getElementById("txtdepreciationqtybigtoolingcost").value;
		document.getElementById("txtdepreciationcosttoolingcost").value = getPriceToolingCost / getDepQtyBigToolingCost;
		ValueTotalPriceToolingCost = parseInt(ValueTotalPriceToolingCost)+parseInt(getPriceToolingCost);
		ValueTotalDepreciationQtyToolingCost = parseInt(ValueTotalDepreciationQtyToolingCost)+parseInt(getDepQtyBigToolingCost);
		ValueTotalDepreciationCostToolingCost = parseInt(ValueTotalDepreciationCostToolingCost)+parseInt(document.getElementById("txtdepreciationcosttoolingcost").value);

        document.getElementById("txtdepreciationqtylitetoolingcostperformance").value = getDepQtyLiteToolingCost;
        document.getElementById("txtdepreciationqtylitetoolingcosttrialcost").value = getDepQtyLiteToolingCost;

        var getDepQtyLiteToolingCostPerformance = document.getElementById("txtdepreciationqtylitetoolingcostperformance").value;
        document.getElementById("txtdepreciationqtybigtoolingcostperformance").value = getDepQtyLiteToolingCostPerformance * <?php echo $ResultQuerySelectRFQForm['volume']; ?>;
        var getPriceToolingCostPerformance = document.getElementById("txtpricetoolingcostperformance").value;
        var getDepQtyBigToolingCostPerformance = document.getElementById("txtdepreciationqtybigtoolingcostperformance").value;
		document.getElementById("txtdepreciationcosttoolingcostperformance").value = getPriceToolingCostPerformance / getDepQtyBigToolingCostPerformance;
		ValueTotalPriceToolingCost = parseInt(ValueTotalPriceToolingCost)+parseInt(getPriceToolingCostPerformance);
		ValueTotalDepreciationQtyToolingCost = parseInt(ValueTotalDepreciationQtyToolingCost)+parseInt(getDepQtyBigToolingCostPerformance);
		ValueTotalDepreciationCostToolingCost = parseInt(ValueTotalDepreciationCostToolingCost)+parseInt(document.getElementById("txtdepreciationcosttoolingcostperformance").value);

        var getDepQtyLiteToolingCostTrialCost = document.getElementById("txtdepreciationqtylitetoolingcosttrialcost").value;
        document.getElementById("txtdepreciationqtybigtoolingcosttrialcost").value = getDepQtyLiteToolingCostTrialCost * <?php echo $ResultQuerySelectRFQForm['volume']; ?>;
        var getPriceToolingCostTrialCost = document.getElementById("txtpricetoolingcosttrialcost").value;
        var getDepQtyBigToolingCostTrialCost = document.getElementById("txtdepreciationqtybigtoolingcosttrialcost").value;
		document.getElementById("txtdepreciationcosttoolingcosttrialcost").value = getPriceToolingCostTrialCost / getDepQtyBigToolingCostTrialCost;
		ValueTotalPriceToolingCost = parseInt(ValueTotalPriceToolingCost)+parseInt(getPriceToolingCostTrialCost);
		ValueTotalDepreciationQtyToolingCost = parseInt(ValueTotalDepreciationQtyToolingCost)+parseInt(getDepQtyBigToolingCostTrialCost);
		ValueTotalDepreciationCostToolingCost = parseInt(ValueTotalDepreciationCostToolingCost)+parseInt(document.getElementById("txtdepreciationcosttoolingcosttrialcost").value);

		// ---------------------------------------------------------------------------------------------------------------------------------------

		document.getElementById("txtpricetoolingcosttotaltoolingcost").value = ValueTotalPriceToolingCost;
		document.getElementById("txtdepreciationqtytoolingcosttotaltoolingcost").value = ValueTotalDepreciationQtyToolingCost;
		document.getElementById("txtdepreciationcosttoolingcosttotaltoolingcost").value = ValueTotalDepreciationCostToolingCost;

		// ---------------------------------------------------------------------------------------------------------------------------------------

		var PercentageTotalPrice = 10 / ValueTotalPriceToolingCost;
		PercentageTotalPrice = PercentageTotalPrice * 100;
		document.getElementById("txtpricetoolingcosttoolinginterest").value = ValueTotalPriceToolingCost * PercentageTotalPrice;

		document.getElementById("txtdepreciationqtytoolingcosttoolinginterest").value = ValueTotalDepreciationQtyToolingCost;

		document.getElementById("txtdepreciationcosttoolingcosttoolinginterest").value = ValueTotalDepreciationCostToolingCost;

		document.getElementById("txttotaldepreciationcosttoolingcost").value = parseInt(ValueTotalDepreciationCostToolingCost) + parseInt(ValueTotalDepreciationCostToolingCost);



      }
    </script>
    <!-- END Tooling Cost -->

    <!-- Multiple Painting Cost -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-paintingcost").click(function(){ 
            var html = $(".paintingcost").html();
            $(".after-add-paintingcost").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Painting Cost -->

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