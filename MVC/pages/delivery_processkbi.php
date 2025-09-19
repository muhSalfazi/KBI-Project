<?php
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");
  session_start();
  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

  require_once("{$base_dir}pages{$ds}core{$ds}header.php");
  require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

  $IdUser = $_SESSION["id_user"];
  $kbndn= $_GET["kbndn"];
  	$job_no = SUBSTR($kbndn, 16, 7);
	$seq_no = SUBSTR($kbndn, 23);
	$dndrkbndn= SUBSTR($kbndn, 0, 16);

?> 

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-building fa-fw""></i> Kanban Konfirmation ADM-KBI  Process</h1>
      </div>
      <!-- End Title -->


	  <!-- Awal Select DN No. -->
	  <div class="panel-body">
		<form method = "POST" action = "../pages/crud/delivery_processkbi_Add.php">
			<input type = "text" name = "kbndnkbi" autofocus required>
			<input type = "hidden" name = "job_no" value = "<?php echo $job_no ?>" >
			<input type = "hidden" name = "kbndn" value = "<?php echo $kbndn ?>" >
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
                List Data Scan <?php echo $job_no ;?> 
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  							<div class="container">
					      	<thead>
					        	<th class="text-center" style="width:40px;">No.</th>
					        	<th class="text-center" style="width:100px;">Job No.</th>
					        	<th class="text-center" style="width:100px;">Qty Scan</th>
					      	</thead>

					      	<?php
					      		$No = 0;
                    $IdRole = 0;
					      		$QueryListMaterials1=mysqli_query($mysqli, "SELECT *, COUNT( * ) AS total FROM tbl_kbndelivery WHERE kbndn_no LIKE '$dndrkbndn%' AND job_no = '$job_no' GROUP BY job_no");
							
								
					      		while($ResultQueryListMaterials1=mysqli_fetch_array($QueryListMaterials1)){
			    				    $No++;
  						    ?>

							    <tr>
						        <td class="text-center"><?php echo $No; ?></td>
								<td class="text-center"><?php echo $ResultQueryListMaterials1['job_no']; ?></td>
								<td class="text-center"><?php echo $ResultQueryListMaterials1['total']; ?></td>

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
                List Data Scan <?php echo $dndrkbndn ;?> 
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
					      		$QueryListMaterials=mysqli_query($mysqli, "SELECT * FROM tbl_kbndelivery WHERE kbndn_no LIKE '$dndrkbndn%' AND job_no = '$job_no' ORDER BY datetime_input ASC");
							
								
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