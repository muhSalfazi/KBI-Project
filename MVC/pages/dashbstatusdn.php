<?php
$nows = strtotime(date('d-m-Y'));
$bulan = date('m');
$tahun = date('Y');
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("config.php");
session_start();
require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

$IdUser = $_SESSION["id_user"];
?>

<!-- Content -->
<div class="row">
	<!--<script src="../js/sweetalert.min.js"></script>
	<link rel="stylesheet" href="../css/sweetalert.css">
    	 Title -->
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-industry fa-fw""></i> STATUS DN</h1>
      </div>
      <!-- End Title -->

      <br><br>

      <!-- Table -->
							<div class=" col-md-12">
				<div class="row">
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-body bk-primary text-light">
								<div class="stat-panel text-center">
									<?php
									$sqlclose = ("SELECT a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE a.tanggal_order='$nows'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp = sequence
	  ORDER BY a.id DESC");
									$queryclose = $dbh->prepare($sqlclose);
									$queryclose->execute();
									$resultsclose = $queryclose->fetchAll(PDO::FETCH_OBJ);
									$bgclose = $queryclose->rowCount();


									$sqlopen = ("SELECT a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE SUBSTR(a.datetime_input,1,10) != SUBSTR(NOW(),1,10)
	AND a.tanggal_order='$nows'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp != sequence
	  ORDER BY a.id DESC ");
									$queryopen = $dbh->prepare($sqlopen);
									$queryopen->execute();
									$resultsopen = $queryopen->fetchAll(PDO::FETCH_OBJ);
									$bgopen = $queryopen->rowCount();
									?>
									<div class="stat-panel-number h1 "><?php echo htmlentities($bgclose);
																											echo '&nbsp - &nbsp';
																											echo "<label style='color:black;'>";
																											echo htmlentities($bgopen);
																											echo "</label>"; ?></div>
									<div class="stat-panel-title text-uppercase">MANIFEST STATUS TODAY</div>
								</div>
							</div>
							<!--<a href="userlist.php" class="block-anchor panel-footer">Full Detail &nbsp;<i class="fa fa-arrow-right"></i></a>-->
						</div>
					</div>
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-body bk-success text-light">
								<div class="stat-panel text-center">

									<?php
									$sqlclosemonth = ("SELECT a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE (a.tanggal_order) LIKE '__-$bulan%'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp = sequence
	  ORDER BY a.id DESC");
									$queryclosemonth = $dbh->prepare($sqlclosemonth);
									$queryclosemonth->execute();
									$resultsclosemonth = $queryclosemonth->fetchAll(PDO::FETCH_OBJ);
									$bgclosemonth = $queryclosemonth->rowCount();


									$sqlopenmonth = ("SELECT a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE SUBSTR(a.datetime_input,1,10) != SUBSTR(NOW(),1,10)
	AND (a.tanggal_order) LIKE '__-$bulan%'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp != sequence
	  ORDER BY a.id DESC ");
									$queryopenmonth = $dbh->prepare($sqlopenmonth);
									$queryopenmonth->execute();
									$resultsopenmonth = $queryopenmonth->fetchAll(PDO::FETCH_OBJ);
									$bgopenmonth = $queryopenmonth->rowCount();
									?>
									<div class="stat-panel-number h1 "><?php echo htmlentities($bgclosemonth);
																											echo '&nbsp - &nbsp';
																											echo "<label style='color:black;'>";
																											echo htmlentities($bgopenmonth);
																											echo "</label>"; ?></div>
									<div class="stat-panel-title text-uppercase">MANIFEST STATUS CURRENT MONTH</div>
								</div>
							</div>
							<!--<a href="feedback.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>-->
						</div>
					</div>

					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-body bk-danger text-light">
								<div class="stat-panel text-center">

									<?php
									$sqlcloseyear = ("SELECT a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE (a.tanggal_order) LIKE '%$tahun'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp = sequence
	  ORDER BY a.id DESC");
									$querycloseyear = $dbh->prepare($sqlcloseyear);
									$querycloseyear->execute();
									$resultscloseyear = $querycloseyear->fetchAll(PDO::FETCH_OBJ);
									$bgcloseyear = $querycloseyear->rowCount();


									$sqlopenyear = ("SELECT a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE SUBSTR(a.datetime_input,1,10) != SUBSTR(NOW(),1,10)
	AND (a.tanggal_order) LIKE '%$tahun'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp != sequence
	  ORDER BY a.id DESC ");
									$queryopenyear = $dbh->prepare($sqlopenyear);
									$queryopenyear->execute();
									$resultsopenyear = $queryopenyear->fetchAll(PDO::FETCH_OBJ);
									$bgopenyear = $queryopenyear->rowCount();
									?>
									<div class="stat-panel-number h1 "><?php echo htmlentities($bgcloseyear);
																											echo '&nbsp - &nbsp';
																											echo "<label style='color:black;'>";
																											echo htmlentities($bgopenyear);
																											echo "</label>"; ?></div>
									<div class="stat-panel-title text-uppercase">MANIFEST STATUS CURRENT YEAR</div>
								</div>
							</div>
							<!--<a href="notification.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>-->
						</div>
					</div>


				</div>
	</div>


</div>

<!--  SCRIPT -->
<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/chartData.js"></script>
<script src="js/main.js"></script>
<script>
	window.onload = function() {

		// Line chart from swirlData for dashReport
		var ctx = document.getElementById("dashReport").getContext("2d");
		window.myLine = new Chart(ctx).Line(swirlData, {
			responsive: true,
			scaleShowVerticalLines: false,
			scaleBeginAtZero: true,
			multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
		});

		// Pie Chart from doughutData
		var doctx = document.getElementById("chart-area3").getContext("2d");
		window.myDoughnut = new Chart(doctx).Pie(doughnutData, {
			responsive: true
		});

		// Dougnut Chart from doughnutData
		var doctx = document.getElementById("chart-area4").getContext("2d");
		window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {
			responsive: true
		});

	}
</script>
<!-- AKHIR SCRIPT -->
<?php
require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>