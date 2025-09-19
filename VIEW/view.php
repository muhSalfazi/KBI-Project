<?php 
error_reporting(0);
include_once("config/connection.php");
//include_once("../../koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="100px" href="gambar/kbi.png">
	<script src="../js/jquery.js"></script>
	<script src="../sweetalert/js/sweetalert.min.js"></script>
	<link rel="stylesheet" href="../sweetalert/css/sweetalert.css">
	<script type="text/javascript" src="../assets/DataTables/media/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/DataTables/media/js/jquery.dataTables.js"></script>
	<!--<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">-->
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/media/css/dataTables.bootstrap.css">
	<title>Document</title>
</head>
<body>
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
								<th class="text-center" style="width:10%; display: none;">Action</th>
								<!--<th class="text-center" style="width:100px;">Print</th>-->
								
	</thead>
	<?php 
	$no=0;
	$tgl     = date("d-m-Y");
	$date1=substr($_POST[date1],8,2).'-'.substr($_POST[date1],5,2).'-'.substr($_POST[date1],0,4); //echo $date1;
	$date2=substr($_POST[date2],8,2).'-'.substr($_POST[date2],5,2).'-'.substr($_POST[date2],0,4); 
	$data = mysqli_query($mysqli,"SELECT a.ETA,a.datetime_input,a.tanggal_order,a.id,a.dn_no,a.job_no AS JobNo,a.customerpart_no,a.qty_pcs,
	ROUND(a.qty_pcs/b.QtyPerKbn)sequence,b.QtyPerKbn,a.status,a.plan,a.cycle,
	b.InvId,b.PartName,b.PartNo,b.ModelNo,b.QtyPerKbn,COUNT(c.job_no)countp,
	COUNT(d.id_label)countprint
	 FROM tbl_deliverynote a
	LEFT JOIN masterpart_mmki b  ON a.job_no = b.JobNo
	LEFT JOIN tbl_kbndelivery c ON CONCAT(a.dn_no,a.job_no) = CONCAT(c.dn_no,c.job_no) 
	LEFT JOIN tbl_count_print d ON d.id_label = a.id
	WHERE a.tanggal_order='$tgl'  
	-- WHERE a.tanggal_order  BETWEEN '$date1' AND  '$date2'
	 GROUP BY CONCAT(a.dn_no,a.job_no)
	 HAVING 	countp = sequence
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
		<td>
		<?php if($d['sequence']==$d['countp']){echo "<label style='color:red;'>Close</label>";} else{echo '<label>'.$d['status'].'</label>';} ?>
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
				<input class="btn btn-xs btn-default" style="display: none;" type="submit" name="submit" value="
					<?php if($d['countprint']>0){echo 'Reprint : '.$d['countprint'];} else {echo 'Print';}?>" >

					<!--<a class="btn bt-default" href="Printkanban.php?jobno=<?php echo $d['JobNo'];?>&&modelno=<?php echo $d['ModelNo'];?>&&invid=<?php echo $d['InvId'];?>" name="submit" >
					Print Label</a>-->
					
			</td>
			
			</form>
		
		<!--<a href="ajx/delete-proses-delivery.php?id=<?php echo $d['dn_no']; ?>" class="delete_master  btn btn-danger btn-xs" style="width:65px;"><i class="fa fa-trash"> Delete</i></a></td>-->
		<!--<td><a class="btn btn-xs btn-default" href="Printkanban.php?var=<?php //echo $d[job_no].$dates;?>&&seq=<?php echo $d[sequence];?>" target="_blank">Print</a></td>-->
	</tr>
	<?php }/*}*/ ?>
</table>	
</body>
</html>

<!-- Modal End-->
<script type="text/javascript">
	$(document).ready(function(){
		$('#example1').DataTable();
	});
</script>

<script type="text/javascript">
	window.onload = function()
{
			
			$.ajax({
				//type: 'POST',
				//url: "on.php",
				//data: tabel,
				success: function() {
					// $('.tampildata').load("ajx/view_delivery.php");
					$('.tampildata').load("../WHSYSTEM/pages/ajx/view_delivery.php");
				}
			});
		};
	
	</script>
