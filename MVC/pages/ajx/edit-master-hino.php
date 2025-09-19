<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php
session_start();
$part = $_POST["id_pendaftar"];
include_once("../../connection.php"); ?>
<div class="panel-body">
	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		<div class="container">


			<?php

			$QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM masterpart_hino WHERE InvId='$part'");
			$ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)

			?>


			<tr>
				<td>Inventory ID</td>
				<td> : </td>
				<td><input name="InvId" value="<?php echo $ResultQueryListMaterials['InvId']; ?>"></td>
			</tr>
			<tr>
				<td>Part Name</td>
				<td> :
				<td><input name="PartName" value="<?php echo $ResultQueryListMaterials['PartName']; ?>"></td>
			</tr>
			<tr>
				<td>Part No</td>
				<td> :
				<td><input name="PartNo" value="<?php echo $ResultQueryListMaterials['PartNo']; ?>"></td>
			</tr>
			<tr>
				<td>Job No</td>
				<td> :
				<td><input name="JobNo" value="<?php echo $ResultQueryListMaterials['JobNo']; ?>"></td>
			</tr>
			<tr>
				<td>Qty Per Kanban</td>
				<td> :
				<td><input name="QtyPerKbn" value="<?php echo $ResultQueryListMaterials['QtyPerKbn']; ?>"></td>
			</tr>
			<tr>
				<td colspan="3" class="text-center"><button name="triger" value="<?php echo $ResultQueryListMaterials['InvId']; ?>" class="btn btn-sm btn-success" id="simpan-data">Simpan</button></td>
			</tr>
			<tr>
				<td colspan="3">
					<div style="display:none;" class="tutup alert alert-success " id='modal-message'>Data Telah Diupdate</div>
				</td>
			</tr>
	</table>
	<script type="text/javascript">
		$('#simpan-data').click(function() {

			//Biaya 
			var InvId = $("input[name=InvId]").val();
			var PartName = $("input[name=PartName]").val();
			var PartNo = $("input[name=PartNo]").val();
			var JobNo = $("input[name=JobNo]").val();
			var QtyPerKbn = $("input[name=QtyPerKbn]").val();

			var triger = $("button[name=triger]").val();
			console.log(InvId);
			console.log(PartName);
			console.log(PartNo);
			console.log(JobNo);
			console.log(QtyPerKbn);
			console.log(triger);
			$.ajax({
				url: "ajx/edit-proses-master-hino.php",
				method: "POST",
				dataType: "json",
				data: {
					InvId: InvId,
					PartName: PartName,
					PartNo: PartNo,
					JobNo: JobNo,
					QtyPerKbn: QtyPerKbn,
					triger: triger
				},

				success: function(data) {
					console.log(data);
				}

			}, 1000);
			$("#modal-message").show(500);
			setTimeout(location.reload.bind(location), 1200);


		});
	</script>
</div>