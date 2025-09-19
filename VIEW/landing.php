<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View-WH</title>
    <link rel="icon" type="image/png" sizes="100px" href="kbi.png">
    <script src="vendor/js/jquery.214.js"></script>
    <link href="vendor/css/jquimin.css" rel='stylesheet' type='text/css'>
    <script src="vendor/js/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="vendor/js/bootstrap.min.js"></script>
    <script src="vendor/js/bootstrap-datepicker.min.js"></script>
    <link href="vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css/datepicker.min.css" rel="stylesheet">
    <!-- icon dan fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
<h3>
    DASHBOARD
</h3>
<table class="table table-bordered" style="font-size: 11px; color: black;">
		<tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Actual-Input</th>
                    <th class="text-center">Date-Planing</th>
                    <th class="text-center" style="display: none;">id</th>
                    <th class="text-center">Manifest.No</th>
                    <th class="text-center">Job.No</th>
                    <th class="text-center">Customerpar.No</th>
                    <th class="text-center">Qty/Pcs</th>
                    <th class="text-center">Qty/Kanban</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Plan</th>
                    <th class="text-center">Cycle</th>
                    <th class="text-center">Invenory.Id</th>
                    <th class="text-center">Part Name</th>
                    <th class="text-center" style="display: none;">Part.No</th>
                    <th class="text-center" style="display: none;">Model.No</th>
                    <th class="text-center" style="display: none;">Job.No</th>
                    <th class="text-center" style="display: none;">Id.Lael</th>
		</tr>
		<?php 
		include 'config/koneksi.php'; 
		$no=1;
        $tgl     = date("d-m-Y");
		$sql     = "SELECT * FROM view_deliveryclose where tanggal_order='$tgl'";
        $query   = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($query)) {
			?>
			<tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['datetime_input'];?></td>
                    <td><?php echo $row['tanggal_order'];?></td>
                    <td style="display: none;"><?php echo $row['id'];?></td>
                    <td><?php echo $row['dn_no'];?></td>
					<td><?php echo $row['JobNo'];?></td>
					<td><?php echo $row['customerpart_no'];?></td>
					<td><?php echo $row['qty_pcs'];?></td>
					<td><?php echo $row['QtyPerKbn'];?></td>
					<!-- <td><?php echo $row['status'];?></td> -->
                    <td>
                        <?php if($d['sequence']==$d['countp']){echo "<label style='color:red;'>Close</label>";} else{echo '<label>'.$d['status'].'</label>';} ?>
                    </td>
					<td><?php echo $row['plan'];?></td>
					<td><?php echo $row['cycle'];?></td>
					<td><?php echo $row['InvId'];?></td>
					<td><?php echo $row['PartName'];?></td>
					<td style="display: none;"><?php echo $row['PartNo'];?></td>
					<td style="display: none;"><?php echo $row['ModelNo'];?></td>
					<td style="display: none;"><?php echo $row['job_no'];?></td>
					<td style="display: none;"><?php echo $row['id_label'];?></td>
					
                    <!-- <td>
                        <a class='btn btn-success' href="form-edit.php?id=<?php echo $row['id']; ?>">
                            <span class="fa fa-edit"></span>
                        </a>
                    </td>
                    <td>
                        <a class='btn btn-warning' href="detail.php?code=<?php echo $row['code']; ?>">
                        <span class="fa fa-eye"></span>
                    </a>     
                    </td>
                    <td>
                        <a class='btn btn-danger' href="delet.php?id=<?php echo $row['id']; ?>">
                        <span class="fa fa-close"></span>
                    </a>
                    </td> -->
			</tr>
			<?php 
		}
		?>
 
	</table>
</div>

</body>
</html>

	

	
	
	
	
	
	
	

	
	
	
	
	
	
	
