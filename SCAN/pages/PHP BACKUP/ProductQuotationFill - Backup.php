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
	                  <label style="padding-right:55px;">Mass Pro</label>
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
	                  <label style="padding-right:55px;">Exchange Rate</label>
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
	                  $QuerySelectAllProductionData = $mysqli->query("SELECT * FROM tbl_product_q INNER JOIN tbl_rfq ON tbl_product_q.idrfq_p = tbl_rfq.id_rfq WHERE tbl_product_q.idrfq_p = $IdRFQForm");
	                  $ResultQuerySelectAllProductionData = mysqli_fetch_array($QuerySelectAllProductionData);

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
	                  <label style="padding-right:27px;">NG Ratio</label>
	                </td>
	                <td class="text-left">
	                  <label style="padding-right:27px;">Cost</label>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">Total Weight</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Product material cost</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">Color Pigment/MB</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">UV</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Returnable material cost</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Material change loss</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total Cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <hr/>
	          <h3><strong>Blow Molding</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
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
	                  <label style="padding-right:10px;">Machine Size</label>
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
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">Blow Molding Preparation</label>
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
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">Blow Molding</label>
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
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
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
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;"> 1. Cutting(4 point)</label>
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
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;"> 2. Drilling</label>
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
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;"> 3. Punching (4 Point)</label>
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
	              </tr>
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;"> 4. Trimming</label>
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
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;"> 5. Air Cleaning</label>
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
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;"> 6. Guide & Packing Assy</label>
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
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;"> 7. Inspection & Packing</label>
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
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total Cost</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
	          <hr/>
	          <h3><strong>Purchase Parts</strong></h3>
	          <br>
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <div>
	              <tr>
	                <td class="text-left">
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
	              <tr>
	              	<td class="text-left">
	                  <label style="padding-right:10px;">GUIDE</label>
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
	              </tr>
	              <tr>
	                <td class="text-left">
	                  <label style="padding-right:10px;">PACKING (Ø132.4xØ124.4xt4 mm)</label>
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
	              </tr>
	              <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td class="text-right">
	                  <label style="padding-right:10px;">Total</label>
	                </td>
	                <td class="text-center">
	                  <input name="txtexchangerate" id="txtrev" type="text" class="form-group" style="width:120px;"/>
	                </td>
	              </tr>
	            </div>
	          </table>
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
	          	<div class="control-group after-add-toolingcost">
	              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		            <div>
		              <tr>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Description</label>
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
		                  <label style="padding-right:27px;">Remark 1</label>
		                </td>
		                <td class="text-left">
		                  <label style="padding-right:27px;">Remark 2</label>
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
		                    <button class="btn btn-success add-toolingcost" type="button"><i class="glyphicon glyphicon-plus"></i></button>
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

    <!-- Tooling Cost Fields -->
    <div class="toolingcost hide">
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
    <!-- End Tooling Cost Fields -->


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

    <!-- Multiple Tooling Cost -->
    <script type="text/javascript">
      $(document).ready(function() {
        $(".add-toolingcost").click(function(){ 
            var html = $(".toolingcost").html();
            $(".after-add-toolingcost").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
      });
    </script>
    <!-- End Tooling Cost -->

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