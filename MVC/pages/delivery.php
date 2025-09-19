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
          <h1 class="page-header"><i class="fa fa-building fa-fw""></i> DN Process</h1>
      </div>
      <!-- End Title -->


	  <!-- Awal Select DN No. -->
	  <div class="center-div">
		<form method = "POST" action = "delivery_selectdn.php">
			<input type = "text" name = "dnno" autofocus required>
			<input type = "submit" name = "submit" value = "Submit">
		</form>

		</div>

      </a>
      <!-- Akhir Select DN No. -->

      <br><br>

      <!-- Table -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
                List All Open Delivery Order/Note
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  							<div class="container">
					      	<thead>
					        	<th class="text-center" style="width:40px;">No.</th>
								<th class="text-center" style="width:100px;">Delivery Note No.</th>
					        	<th class="text-center" style="width:100px;">Job No.</th>
					        	<th class="text-center" style="width:100px;">Customer Part No.</th>
								<th class="text-center" style="width:100px;">Qty Pcs.</th>
								<th class="text-center" style="width:100px;">Status</th>
					      	</thead>

					      	<?php
					      		$No = 0;
                    $IdRole = 0;
					      		$QueryListMaterials=mysqli_query($mysqli, "SELECT * FROM tbl_deliverynote WHERE status = 'Open' ORDER BY job_no DESC");
					      		while($ResultQueryListMaterials=mysqli_fetch_array($QueryListMaterials)){
			    				    $No++;
  						    ?>

							    <tr>
						        <td class="text-center"><?php echo $No; ?></td>
                    <td class="text-center"><?php echo $ResultQueryListMaterials['dn_no']; ?></td>
					<td class="text-center"><?php echo $ResultQueryListMaterials['job_no']; ?></td>
					<td class="text-center"><?php echo $ResultQueryListMaterials['customerpart_no']; ?></td>
					<td class="text-center"><?php echo $ResultQueryListMaterials['qty_pcs']; ?></td>
					<td class="text-center"><?php echo $ResultQueryListMaterials['status']; ?></td>
  							  <?php 
  									} 
  								?>

  							</div>
  						</table>
  	        </div>
  			  </div>
  			</div>
  		</div>
  		<!-- End Table -->

    </div>
    <!-- End Content -->



<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   