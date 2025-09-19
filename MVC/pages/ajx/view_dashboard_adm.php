<?php
include_once("../../connection.php");
//include_once("../../koneksi.php");
$status = isset($_POST['status']) ? $_POST['status'] : '';
// echo var_dump($status);

$query = "SELECT 
						a.ETA, 
						a.datetime_input, 
						a.tanggal_order, 
						a.id, 
						a.dn_no, 
						a.job_no AS JobNo, 
						a.customerpart_no, 
						a.qty_pcs,
            ROUND(a.qty_pcs / b.QtyPerKbn) sequence_adm, 
						a.status, 
						a.plan, 
						a.cycle,
            b.InvId, 
						b.PartName, 
						b.PartNo, 
						b.ModelNo, 
						b.QtyPerKbn as qty_adm, 
						COUNT(c.job_no) countp
          FROM tbl_deliveryadm a
          LEFT JOIN masterpart_adm b ON a.job_no = b.JobNo
          LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no, a.job_no) = CONCAT(c.dn_no, c.job_no)";

if ($status != '') {
	if ($status == 'Open') {
		$query .= " WHERE a.status = 'Open'";
	} elseif ($status == 'Close') {
		$query .= " WHERE a.status = 'Close'";
	}
}

$query .= " GROUP BY CONCAT(a.dn_no, a.job_no) ORDER BY a.id DESC";


$data = mysqli_query($mysqli, $query);
?>

<script type="text/javascript">
	$(document).ready(function() {
		// Menampilkan sweetalert konfirmasi saat mengklik link dengan kelas .delete-link
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
				window.location.href = getLink;
			});
			return false;
		});

		// Menampilkan modal untuk tambah data delivery
		$('.tambah_delivery').click(function() {
			var id_pendaftar = $(this).attr('data-id');
			$.ajax({
				url: "ajx/tambah-delivery.php",
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

		// Menampilkan modal untuk edit data delivery
		$('.edit_master').click(function() {
			var id_pendaftar = $(this).attr('data-id');
			$.ajax({
				url: "ajx/edit-delivery.php",
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

		// Menampilkan modal untuk delete data delivery
		$('.delete_master').click(function() {
			var id_pendaftar = $(this).attr('data-id');
			$.ajax({
				url: "ajx/delete-delivery.php",
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

<div class="table-responsive">
	<table width="100%" class="table table-striped table-bordered table-hover" id="example1">
		<thead>
			<tr>
				<th class="text-center" style="width:5%;">No.</th>
				<th class="text-center">Delivery Date</th>
				<th class="text-center">Delivery Manifest No.</th>
				<th class="text-center">Job No.</th>
				<th class="text-center">Customer Part No.</th>
				<th class="text-center">Total Qty Pcs.</th>
				<th class="text-center">Plant</th>
				<th class="text-center">Dlv.Time (ETA)</th>
				<th class="text-center">Cycle</th>
				<th class="text-center">Status</th>
				<th class="text-center">Date Input</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 0;
			while ($d = mysqli_fetch_array($data)) {
				$no++;
			?>
				<tr>
					<td class="text-center"><?php echo $no; ?></td>
					<td class="text-center">
						<?php
						$date = $d['tanggal_order'];
						$bln = substr($date, 3, 2);
						$tgl = substr($date, 0, 2);
						$thn = substr($date, 6, 4);
						echo $tgl . '-';
						switch ($bln) {
							case 1:
								echo "Jan";
								break;
							case 2:
								echo "Feb";
								break;
							case 3:
								echo "Mar";
								break;
							case 4:
								echo "Apr";
								break;
							case 5:
								echo "Mei";
								break;
							case 6:
								echo "Jun";
								break;
							case 7:
								echo "Jul";
								break;
							case 8:
								echo "Ags";
								break;
							case 9:
								echo "Sep";
								break;
							case 10:
								echo "Okt";
								break;
							case 11:
								echo "Nop";
								break;
							case 12:
								echo "Des";
								break;
							default:
								echo " ";
								break;
						}
						echo '-' . $thn;
						?>
					</td>
					<td class="text-center"><?php echo $d['dn_no'] ?></td>
					<td class="text-center"><?php echo $d['JobNo'] ?></td>
					<td class="text-center"><?php echo $d['customerpart_no'] ?></td>
					<td class="text-center"><?php echo $d['qty_pcs'] ?></td>
					<td class="text-center"><?php echo $d['plan'] ?></td>
					<td class="text-center"><?php echo $d['ETA'] ?></td>
					<td class="text-center"><?php echo $d['cycle'] ?></td>
					<td class="text-center">
						<?php
						if (($d['sequence_adm'] == $d['countp'])) {
							$d['status'] = 'Close';
							echo '<label style="color:red;">' . $d['status'] . '</label>';
						} else {
							echo '<label>' . $d['status'] . '</label>';
						}
						?>
					</td>
					<td><?php echo $d['datetime_input'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- konten modal-->
		<div class="modal-content">
			<!-- heading modal -->
			<div class="modal-header">
				<!-- tombol untuk menghilangkan modal ini -->
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Manifest.No</h4>
			</div>
			<!-- body modal, disini kita simpan pesan atau konfirmasinya -->
			<div class="modal-body">
				<p class="master-body"></p>
			</div>
			<!-- footer modal / bagian bawah dari modal popup -->
			<div class="modal-footer">
				<button type="button" class="tampil btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal End -->

<script type="text/javascript">
	$(document).ready(function() {
		// Inisialisasi DataTables pada tabel dengan id example1
		$('#example1').DataTable({
			"paging": true,
			"pageLength": 5,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": false,
		});
	});
</script>