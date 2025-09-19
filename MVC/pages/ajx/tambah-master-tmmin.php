<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php $part = $_POST["id_pendaftar"];
include_once("../../connection.php"); ?>
<div class="panel-body">
	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		<div class="container">


			<?php

			$QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM masterpart_tmmin WHERE InvId='$part'");
			$ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)

			?>


			<tr>
				<td>Inventory ID</td>
				<td> :</td>
				<td><input name="a"></td>
			</tr>
			<tr>
				<td>Model No.</td>
				<td> :
				<td><input name="g"></td>
			</tr>
			<tr>
				<td>Part Name</td>
				<td> :
				<td><input name="b"></td>
			</tr>
			<tr>
				<td>Part No</td>
				<td> :
				<td><input name="c"></td>
			</tr>
			<tr>
				<td>Job No</td>
				<td> :
				<td><input name="d"></td>
			</tr>
			<tr>
				<td>Qty Per Kanban</td>
				<td> :
				<td><input type="number" name="e"></td>
			</tr>
			<tr>
				<td colspan="3" class="text-center"><button name="f" value="<?php echo $ResultQueryListMaterials['InvId']; ?>" class="btn btn-sm btn-success" id="simpan-data">Simpan</button></td>
			</tr>
			<tr>
				<td colspan="3">
					<div style="display:none;" class="tutup alert alert-success " id='modal-message'>Data Telah Di Input</div>
				</td>
			</tr>
	</table>
	<script type="text/javascript">
		$('#simpan-data').click(function() {

			//Biaya 
			var a = $("input[name=a]").val();
			var b = $("input[name=b]").val();
			var c = $("input[name=c]").val();
			var d = $("input[name=d]").val();
			var e = $("input[name=e]").val();
			var g = $("input[name=g]").val();
			var f = $("button[name=f]").val();
			if (a == "") {
				$(document).ready(function() {
					var audio = new Audio('audio/3.mp3');
					audio.play();
					swal({
							title: 'Inventory ID',
							text: "tidak boleh kosong!",
							type: 'error',
							timer: 1000,
							showCancelButton: false,
							showConfirmButton: true
						},
						function() {
							// swal.close(); 
							//window.location.href = 'delivery_smart.php';
						});
				});
				return false;
			}
			/*else if(g == "" ){
				 $(document).ready(function() {
				var audio = new Audio('audio/3.mp3');
							audio.play();
					swal({ 
					   title: 'Model No.',
					   text: "tidak boleh kosong!",
						  type: 'error',
						  timer: 1000,
						  showCancelButton: false,
						  showConfirmButton: true 
					  },
					  function(){
						 // swal.close(); 
						//window.location.href = 'delivery_smart.php';
					});
					});
					return false;
			}*/
			else if (b == "") {
				$(document).ready(function() {
					var audio = new Audio('audio/3.mp3');
					audio.play();
					swal({
							title: 'Part Name',
							text: "tidak boleh kosong!",
							type: 'error',
							timer: 1000,
							showCancelButton: false,
							showConfirmButton: true
						},
						function() {
							// swal.close(); 
							//window.location.href = 'delivery_smart.php';
						});
				});
				return false;
			} else if (c == "") {
				$(document).ready(function() {
					var audio = new Audio('audio/3.mp3');
					audio.play();
					swal({
							title: 'Part No',
							text: "tidak boleh kosong!",
							type: 'error',
							timer: 1000,
							showCancelButton: false,
							showConfirmButton: true
						},
						function() {
							// swal.close(); 
							//window.location.href = 'delivery_smart.php';
						});
				});
				return false;
			}
			/*else if(d == "" ){
				$(document).ready(function() {
				var audio = new Audio('audio/3.mp3');
							audio.play();
					swal({ 
					   title: 'Job No',
					   text: "tidak boleh kosong!",
						  type: 'error',
						  timer: 1000,
						  showCancelButton: false,
						  showConfirmButton: true 
					  },
					  function(){
						 // swal.close(); 
						//window.location.href = 'delivery_smart.php';
					});
					});
					return false;
			}*/
			else if (e == "") {
				$(document).ready(function() {
					var audio = new Audio('audio/3.mp3');
					audio.play();
					swal({
							title: 'Qty Per Kanban',
							text: "tidak boleh kosong!",
							type: 'error',
							timer: 1000,
							showCancelButton: false,
							showConfirmButton: true
						},
						function() {
							// swal.close(); 
							//window.location.href = 'delivery_smart.php';
						});
				});
				return false;
			}
			console.log(a);
			console.log(b);
			console.log(c);
			console.log(d);
			console.log(e);
			console.log(f);
			console.log(g);
			$.ajax({
				url: "ajx/tambah-proses-master-tmmin.php",
				method: "POST",
				dataType: "json",
				data: {
					a: a,
					b: b,
					c: c,
					d: d,
					e: e,
					f: f,
					g: g
				},

				success: function(data) {
					console.log(data);
				}

			});
			$("#modal-message").show(500);
			window.location = ('masterpart_tmmin.php');
			//setTimeout(location.reload.bind(location), 2000);
			/*location.reload(true);
		 $.ajax({
            url: "edit-proses-master.php",
            method: "POST",
            data: {InvId:InvId},
            dataType: "html",
            success: function(data){
              $('.master-body2').html(data);
            }
          });*/

		});
	</script>
</div>