<?php 
error_reporting(0);
include_once("../../connection.php");
//include_once("../../koneksi.php");
?>
<script type="text/javascript">
	$(document).ready(function(){	
		 jQuery(document).ready(function($){
            $('.delete-link').on('click',function(){
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
                        },function(){
                        window.location.href = getLink
                    });
                return false;
            });
        });
		  
		  //Ajax modal menampilkan data
		  $('.tambah_delivery').click(function(){
			  
			  var id_pendaftar = $(this).attr('data-id');
			  $.ajax({
				url: "ajx/tambah-delivery.php",
				method: "POST",
				data: {id_pendaftar:id_pendaftar},
				dataType: "html",
				success: function(data){
				  $('.master-body').html(data);
				}
			  });
		  });
		  
		  $('.edit_master').click(function(){
			  
			  var id_pendaftar = $(this).attr('data-id');
			  $.ajax({
				url: "ajx/edit-delivery.php",
				method: "POST",
				data: {id_pendaftar:id_pendaftar},
				dataType: "html",
				success: function(data){
				  $('.master-body').html(data);
				}
			  });
		  });
		  
		   $('.delete_master').click(function(){
			  
			  var id_pendaftar = $(this).attr('data-id');
			  $.ajax({
				url: "ajx/delete-delivery.php",
				method: "POST",
				data: {id_pendaftar:id_pendaftar},
				dataType: "html",
				success: function(data){
				  $('.master-body').html(data);
				}
			  });
		  });
		  
		 
		  
		});  
</script>
<div class="table-responsive">
 <table width="100%" class="table table-striped table-bordered table-hover" id="example1">
	<thead>
		<th class="text-center" style="width:5%;">No.</th>
		<th class="text-center" >Delivery Date</th>
								<th class="text-center" >Manifest No.</th>
								
					        	<th class="text-center" >Job No.</th>
					        	<th class="text-center" >Customer Part No.</th>
								<th class="text-center" >Qty Box.</th>
								<th class="text-center" >Acuan Scan</th>
								<th class="text-center" >Total Qty Pcs.</th>
								
								<th class="text-center" >Proses Scan</th>
								
								<th class="text-center" >Plant</th>
								<th class="text-center" >Dlv.Time(ETA)</th>
								<th class="text-center" >Cycle</th>
								<th class="text-center" >Status</th>
								<th class="text-center" >Date Input</th>
								<th class="text-center" style="width:10%;">Action</th>
								<!--<th class="text-center" style="width:100px;">Print</th>-->
								
	</thead>
	<?php 
	$no=0;
	$date1=substr($_POST['date1'],8,2).'-'.substr($_POST['date1'],5,2).'-'.substr($_POST['date1'],0,4); echo $date1;
	$date2=substr($_POST['date2'],8,2).'-'.substr($_POST['date2'],5,2).'-'.substr($_POST['date2'],0,4); 
	$data = mysqli_query($mysqli,"SELECT a.ETA,a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp
	-- COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	-- LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE a.tanggal_order  BETWEEN '$date1' AND  '$date2'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp != sequence
	  ORDER BY a.id DESC ");
	while($d=mysqli_fetch_array($data)){
		
		$no++;
		/*$sequence=$d['sequence'];
		for ($i=1; $i <= $sequence; $i++)
		{*/
	?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php 

$date=$d['tanggal_order'];
$bln = substr($date,3,2);
$tgl = substr($date,0,2);
$thn = substr($date,6,4);
$dates= substr($date,8,4).substr($date,3,2).substr($date,0,2);
echo $tgl.'-';
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
echo '-'.$thn;


		//echo $d['tanggal_order'] ?></td>
		<td><?php echo $d['dn_no']?></td>

		<td><?php echo $d['JobNo'] ?></td>
		<td><?php echo $d['customerpart_no'] ?></td>
		<td><?php echo $d['QtyPerKbn'] ?></td>
		<td><?php echo $d['sequence'] ?></td>
		<td><?php echo $d['qty_pcs'] ?></td>
		<td><?php echo $d['countp'] ?></td>
		
		<td><?php echo $d['plan'] ?></td>
		<td><?php echo $d['ETA'] ?></td>
		<td><?php echo $d['cycle']?></td>
		<td><?php if($d['sequence']!=$d['countp']){
								$d['status'] = 'Open';
								echo '<label>'.$d['status'].'</label>';
							}
				?>
		</td>
		<td><?php echo $d['datetime_input']?></td>
		<td>
		<a id="admin" id="edit_master" class='edit_master btn btn-primary btn-xs'  data-toggle="modal" data-target="#myModal" data-id="<?php echo  $d['id']; ?>" ><i class='fa fa-edit'> </i></a>
		&nbsp; <input name="id_del" value="<?php echo $d['dn_no'] ?>" hidden>
		<a id="admin" class="delete_master  btn btn-danger btn-xs"  data-toggle="modal" data-target="#myModal" data-id="<?php echo  $d['id']; ?>" ><i class="fa fa-trash"></i></a>
		<form action="Printkanban.php" method="post">
				<div class="form-group">
				<input name="userdata" type="hidden"  value="<?php echo $d['JobNo'].$dates;?>" />
				</div>
				<div class="form-group">
				<input name="level" type="hidden" value="M" />
				</div>
				<div class="form-group">
				<input name="size" type="hidden" value="4" />
				</div>
				<div class="form-group">
				<input name="jobno" type="hidden" value="<?php echo $d['JobNo']; ?>" />
				</div>
				<div class="form-group">
				<input name="modelno" type="hidden" value="<?php echo $d['ModelNo']; ?>" />
				</div>
				<div class="form-group">
				<input name="invid" type="hidden" value="<?php echo $d['InvId']; ?>" />
				</div>
				<div class="form-group">
				<input name="partname" type="hidden" value="<?php echo $d['PartName']; ?>" />
				</div>
				<div class="form-group">
				<input name="qtyperkbn" type="hidden" value="<?php echo $d['QtyPerKbn']; ?>" />
				</div>
				<div class="form-group">
				<input name="partno" type="hidden" value="<?php echo $d['PartNo']; ?>" />
				<input name="sequence" type="hidden" value="<?php echo $d['sequence']; ?>" />
				<input name="id_kbi" type="hidden" value="<?php echo $d['id']; ?>" />
				<input name="dn" type="hidden" value="<?php echo $d['dn_no'];?>"/>
				<input name="cycle" type="hidden" value="<?php echo $d['cycle'];?>"/>
				</div>
				
				<a  href="Printkanban.php?id_kbi=<?php echo $d['id']; ?>&&view=1" 
				onclick="window.open(this.href, '_blank', 'left=20,top=20,width=1000,height=500,toolbar=1,resizable=0'); return false;"><span class="glyphicon glyphicon-search"></span></a>
					<!--<button class="btn btn-xs btn-default" type="submit" name="view" value="1">View label</Button>-->
				<!-- <input class="btn btn-xs btn-default" type="submit" name="submit" value="
					<?php if($d['countprint']>0){echo 'Reprint : '.$d['countprint'];} else {echo 'Print';}?>" > -->

					<!--<a class="btn bt-default" href="Printkanban.php?jobno=<?php echo $d['JobNo'];?>&&modelno=<?php echo $d['ModelNo'];?>&&invid=<?php echo $d['InvId'];?>" name="submit" >
					Print Label</a>-->
					
			</td>
			
			</form>
		
		<!--<a href="ajx/delete-proses-delivery.php?id=<?php echo $d['dn_no']; ?>" class="delete_master  btn btn-danger btn-xs" style="width:65px;"><i class="fa fa-trash"> Delete</i></a></td>-->
		<!--<td><a class="btn btn-xs btn-default" href="Printkanban.php?var=<?php //echo $d[job_no].$dates;?>&&seq=<?php echo $d['sequence'];?>" target="_blank">Print</a></td>-->
	</tr>
	<?php }/*}*/ ?>
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
<!-- Modal End-->
<script type="text/javascript">
	$(document).ready(function(){
		$('#example1').DataTable();
	});
</script>
