<?php
session_start();
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
include_once("../connection.php");
require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

$IdUser = $_SESSION["id_user"];
?>
<script src="../sweetalert/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
<?php
if (isset($_SESSION['alert']) == '1') {
	unset($_SESSION['alert']);
	echo "<script type='text/javascript'>
	   $(document).ready(function() {
		   var audio = new Audio('audio/3.mp3');
						audio.play();
				swal({ 
				   title: 'Data Sudah Ada',
					  type: 'error',
					  //timer: 1000,
					  showCancelButton: false,
					  showConfirmButton: true 
				  },
				  function(){
					//window.location.href = 'masterkanban.php';
				});
				});
</script>";
} else {
} ?>
<script type="text/javascript">
	$(document).ready(function() {
		jQuery(document).ready(function($) {
			$('.delete-link').on('click', function() {
				var getLink = $(this).attr('href');
				swal({
					title: "Apakah Yakin Menghapus?",
					text: "Jika dihapus data ini tidak dapat dikembalikan!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel!",
					closeOnConfirm: false,
					closeOnCancel: true
				}, function() {
					window.location.href = getLink
				});
				return false;
			});
		});

		//Ajax modal menampilkan data
		$('.tambah_master').click(function() {

			var id_pendaftar = $(this).attr('data-id');
			$.ajax({
				url: "ajx/tambah-master-hino.php",
				method: "POST",
				data: {
					id_pendaftar: id_pendaftar
				},
				dataType: "html",
				success: function(data) {
					$('.master-body').html(data);
				}
			});
		});

		$('.edit_master').click(function() {

			var id_pendaftar = $(this).attr('data-id');
			console.log(id_pendaftar);
			$.ajax({
				url: "ajx/edit-master-hino.php",
				method: "POST",
				data: {
					id_pendaftar: id_pendaftar
				},
				dataType: "html",
				success: function(data) {
					$('.master-body').html(data);
				}
			});
		});

		$('.delete_master').click(function() {

			var id_pendaftar = $(this).attr('data-id');
			$.ajax({
				url: "ajx/delete-master-hino.php",
				method: "POST",
				data: {
					id_pendaftar: id_pendaftar
				},
				dataType: "html",
				success: function(data) {
					$('.master-body').html(data);
				}
			});
		});

	});
</script>

<!-- Content -->
<div class="row">
	<!-- Title -->
	<div class="col-lg-12">
		<h1 class="page-header"><i class="fa fa-building fa-fw""></i> Data Kanban HINO</h1>
      </div>
      <!-- End Title -->



      <br><br>

      <!-- Table -->
      <div class=" row">
				<div class="col-lg-12">
					<a class='tambah_master btn btn-sm btn-primary btn-sm' data-toggle="modal" data-target="#myModal" data-id="<?php echo  $ResultQueryListMaterials['InvId']; ?>" data-target="#modal-default"><i class='fa fa-plus'></i>&ensp;Add Data Kanban</a>
					<a href="import_partshino.php" class='btn btn-primary btn-sm'><i class='fa fa-download'></i>&ensp;Import Data Kanban</a>
					<br></br>
					<div class="panel panel-default">
						<div class="panel-heading">
							List All Data Part&nbsp;&nbsp;
						</div>

						<div class="panel-body">
							<script type="text/javascript" src="../js/jquery.dataTables.min"></script>
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<div class="container">
									<thead>
										<th class="text-center" style="width:40px;">NO</th>
										<th class="text-center" style="width:100px;">Inventory ID</th>
										<!-- <th class="text-center" style="width:100px;">Model No.</th> -->
										<th class="text-center" style="width:100px;">Part Name</th>
										<th class="text-center" style="width:100px;">Part No.</th>
										<th class="text-center" style="width:100px;">Job No.</th>
										<th class="text-center" style="width:100px;">Qty Per Kanban</th>

										<th class="text-center" style="width:100px;">Action</th>
									</thead>

									<?php
									$No = 0;
									$IdRole = 0;
									$QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM masterpart_hino ORDER BY id DESC");
									while ($ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)) {
										$No++;
									?>

										<tr>
											<td class="text-center"><?php echo $No; ?></td>
											<td class="text-center"><?php echo $ResultQueryListMaterials['InvId']; ?></td>
											<!-- <td class="text-center"><?php echo $ResultQueryListMaterials['ModelNo']; ?></td> -->
											<td class="text-center"><?php echo $ResultQueryListMaterials['PartName']; ?></td>
											<td class="text-center"><?php echo $ResultQueryListMaterials['PartNo']; ?></td>
											<td class="text-center"><?php echo $ResultQueryListMaterials['JobNo']; ?></td>
											<td class="text-center"><?php echo $ResultQueryListMaterials['QtyPerKbn']; ?></td>
											<td class="text-center">
												<a id="edit_master" class='edit_master btn btn-primary btn-xs' style='width:65px;' data-toggle="modal" data-target="#myModal" data-id="<?php echo  $ResultQueryListMaterials['InvId']; ?>" data-target="#modal-default"><i class='fa fa-edit'> Edit</i></a>
												<a class="delete_master  btn btn-danger btn-xs" style="width:65px;" data-toggle="modal" data-target="#myModal" data-id="<?php echo  $ResultQueryListMaterials['InvId']; ?>"><i class="fa fa-trash"> Delete</i></a>
												<!--<a href="ajx/delete-proses-master.php?id=<?php echo $ResultQueryListMaterials['InvId']; ?>" class="delete-link  btn btn-danger btn-xs" style="width:65px;"><i class="fa fa-trash"> Delete</i></a>-->
												<!-- awal submit kanban qrcode -->
												<form action="Printkanban.php" method="post">
													<div class="form-group">
														<input name="userdata" type="hidden" value="<?php echo $ResultQueryListMaterials['InvId']; ?><?php echo $ResultQueryListMaterials['JobNo']; ?>" />
													</div>
													<div class="form-group">
														<input name="level" type="hidden" value="M" />
													</div>
													<div class="form-group">
														<input name="size" type="hidden" value="4" />
													</div>
													<div class="form-group">
														<input name="jobno" type="hidden" value="<?php echo $ResultQueryListMaterials['JobNo']; ?>" />
													</div>
													<div class="form-group">
														<input name="modelno" type="hidden" value="<?php echo $ResultQueryListMaterials['ModelNo']; ?>" />
													</div>
													<div class="form-group">
														<input name="invid" type="hidden" value="<?php echo $ResultQueryListMaterials['InvId']; ?>" />
													</div>
													<div class="form-group">
														<input name="partname" type="hidden" value="<?php echo $ResultQueryListMaterials['PartName']; ?>" />
													</div>
													<div class="form-group">
														<input name="qtyperkbn" type="hidden" value="<?php echo $ResultQueryListMaterials['QtyPerKbn']; ?>" />
													</div>
													<div class="form-group">
														<input name="partno" type="hidden" value="<?php echo $ResultQueryListMaterials['PartNo']; ?>" />
													</div>
													<div class="form-group">
														<!--<input type="submit" name="submit" value="Print Kanban" >-->
													</div>
												</form>
												<!-- akhir submit kanban qrcode -->
											</td>
										</tr>
									<?php
									}
									?>

								</div>
							</table>

						</div>


					</div>

					<div class="master-body2"></div>

				</div>
	</div>
</div>
<!-- End Table -->

</div>
<!-- End Content -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- konten modal-->
		<div class="modal-content">
			<!-- heading modal -->
			<div class="modal-header">
				<!-- tombol untuk menghilangkan modal ini -->
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Master Kanban</h4>
			</div>
			<!-- body modal, disini kita simpan pesan atau konfirmasinya -->
			<div class="modal-body">
				<p class="master-body"></p>

			</div>
			<!-- footer modal / bagian bawah dari modal popup -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>


<!-- <?php
			require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
			?>    -->