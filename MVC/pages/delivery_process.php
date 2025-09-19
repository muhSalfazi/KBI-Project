<?php
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");
  session_start();
  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

  require_once("{$base_dir}pages{$ds}core{$ds}header.php");
  require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

  $IdUser = $_SESSION["id_user"];
  $dnno = $_GET["dn_no"];

?> 

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-building fa-fw""></i> DN Process</h1>
      </div>
      <!-- End Title -->


	  <!-- Awal Select DN No. -->
	  <div class="panel-body">
		<form method = "POST" action = "../pages/crud/delivery_process_Add.php">
			<input type = "text" name = "kbndn" autofocus required>
			<input type = "hidden" name = "dn_no" value = "<?php echo $dnno ?>" >
			<input type = "submit" name = "submit" value = "Insert">
		</form>

		</div>

      </a>
      <!-- Akhir Select DN No. -->
      <!-- Table -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
                List Data Scan <?php echo $dnno ;?> 
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  							<div class="container">
					      	<thead>
					        	<th class="text-center" style="width:40px;">No.</th>
					        	<th class="text-center" style="width:100px;">Job No.</th>
					        	<th class="text-center" style="width:100px;">Qty Scan</th>
								<th class="text-center" style="width:100px;">Qty Scan pcs</th>
								<th class="text-center" style="width:100px;">Qty DN pcs</th>
								<th class="text-center" style="width:100px;">Qty Outstanding</th>
								
					      	</thead>

					      	<?php
					      		$No = 0;
                    $IdRole = 0;
					      		//$QueryListMaterials1=mysqli_query($mysqli, "
								//								   SELECT *, COUNT( * ) AS total FROM tbl_kbndelivery
								//								   INNER JOIN master_partadm ON master_partadm.JobNo=tbl_kbndelivery.job_no
								//								   WHERE dn_no = '$dnno' GROUP BY job_no");
								$QueryListMaterials1 = mysqli_query($mysqli, "
																	SELECT *, COUNT(*) AS total , COUNT(*)*QtyPerKbn AS totalpcs
																	FROM tbl_kbndelivery 
																	INNER JOIN master_partadm ON master_partadm.JobNo=tbl_kbndelivery.job_no
																	INNER JOIN tbl_deliverynote ON tbl_deliverynote.dn_no=tbl_kbndelivery.dn_no 
																	AND tbl_deliverynote.job_no=tbl_kbndelivery.job_no
																	WHERE tbl_kbndelivery.dn_no = '$dnno' 
																	GROUP BY tbl_kbndelivery.job_no
																	");
																
								$cekqtydn= mysqli_query ($mysqli, " select qty_pcs FROM tbl_deliverynote WHERE dn_no='$dnno'");
								$resultcekqtydn=mysqli_fetch_array($cekqtydn);
								
					      		while($ResultQueryListMaterials1=mysqli_fetch_array($QueryListMaterials1)){
			    				    $No++;
									//$outstanding = ($resultcekqtydn['qty_pcs'])-($ResultQueryListMaterials1['total'] * $ResultQueryListMaterials1['QtyPerKbn']);
									$outstanding = ($ResultQueryListMaterials1['qty_pcs'])-($ResultQueryListMaterials1['total'] * $ResultQueryListMaterials1['QtyPerKbn']);
							?>

							    <tr>
						        <td class="text-center"><?php echo $No; ?></td>
								<td class="text-center"><?php echo $ResultQueryListMaterials1['job_no']; ?></td>
								<td class="text-center"><?php echo $ResultQueryListMaterials1['total']; ?></td>
								<td class="text-center"><?php echo ($ResultQueryListMaterials1['total'] * $ResultQueryListMaterials1['QtyPerKbn']); ?></td>
								<td class="text-center"><?php echo ($ResultQueryListMaterials1['qty_pcs']); ?></td>
								<td class="text-center"><?php echo ($outstanding); ?></td>

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

      <!-- Table 1-->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
                List Data Scan <?php echo $dnno ;?> 
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  							<div class="container">
					      	<thead>
					        	<th class="text-center" style="width:40px;">No.</th>
					        	<th class="text-center" style="width:100px;">Job No.</th>
								<th class="text-center" style="width:100px;">Seq No.</th>
					        	<th class="text-center" style="width:100px;">Date & Time Input</th>
					      	</thead>

					      	<?php
					      		$No = 0;
                    $IdRole = 0;
					      		$QueryListMaterials=mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbndn_no LIKE '$dnno%' ORDER BY datetime_input ASC");
							
								
					      		while($ResultQueryListMaterials=mysqli_fetch_array($QueryListMaterials)){
			    				    $No++;
  						    ?>

							    <tr>
						        <td class="text-center"><?php echo $No; ?></td>
                    <td class="text-center"><?php echo $ResultQueryListMaterials['job_no']; ?></td>
					<td class="text-center"><?php echo $ResultQueryListMaterials['seq_no']; ?></td>
					<td class="text-center"><?php echo $ResultQueryListMaterials['datetime_input']; ?></td>

  							  <?php 
  									 } 
  								?>

  							</div>
  						</table>
  	        </div>
  			  </div>
  			</div>
  		</div>
  		<!-- End Table 1-->

    </div> 
    <!-- End Content -->



<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   