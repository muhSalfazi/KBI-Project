<?php
  $ds = DIRECTORY_SEPARATOR;
  $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
  include_once("../connection.php");
  session_start();
  require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");

  require_once("{$base_dir}pages{$ds}core{$ds}header.php");
  require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

  $IdUser = $_SESSION["id_user"];
?> 

	 <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-users fa-fw""></i> Customer</h1>
      </div>
      <!-- End Title -->

      <!-- Button -->
      <!-- <a href="../pages/cetak/data_proses.php">
      	<button style="width:150px;" class="btn btn-warning"><i class="fa fa-print"></i> Cetak Daftar</button>
      </a> -->
      <a href="#">
      	<button style="width:150px;" data-toggle="modal" data-target="#ModalAdd" class="btn btn-primary"><i class="fa fa-plus"></i> Add Customer</button>
      </a>
      <!-- End Button -->

      <br><br>

      <!-- Table -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
                List All Data Customer
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  							<div class="container">
					      	<thead>
					        	<th class="text-center" style="width:40px;">NO</th>
					        	<th class="text-center" style="width:100px;">CUSTOMER NAME</th>
                    <th class="text-center" style="width:100px;">ADDRESS</th>
                    <th class="text-center" style="width:100px;">CONTACT</th>
					        	<th class="text-center" style="width:100px;">MENU</th>
					      	</thead>

					      	<?php
					      		$No = 0;
                    $IdRole = 0;
					      		$QueryListCustomers=mysqli_query($mysqli, "SELECT * FROM tbl_customer ORDER BY id_customer DESC");
					      		while($ResultQueryListCustomers=mysqli_fetch_array($QueryListCustomers)){
			    				    $No++;
  						    ?>

							    <tr>
						        <td class="text-center"><?php echo $No; ?></td>
                    <td class="text-center"><?php echo $ResultQueryListCustomers['customer_name']; ?></td>
						        <td class="text-center"><?php echo $ResultQueryListCustomers['address']; ?></td>
						        <td class="text-center"><?php echo $ResultQueryListCustomers['contact']; ?></td>
                    <td class="text-center">
                      <?php 
                        echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='CustomerEdit.php?ID=".$ResultQueryListCustomers['id_customer']."'><i class='fa fa-edit'> Edit</i></a>"; 
                      ?> 

                      <a href="#" class="btn btn-danger btn-xs" style="width:65px;" onclick="confirm_modal('../pages/crud/Customer_Delete.php?&ID=<?php echo  $ResultQueryListCustomers['id_customer']; ?>');"><i class="fa fa-trash"> Delete</i></a>
                    </td>
							    </tr>
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

    </div>
    <!-- End Content -->

    <!-- Modal Content Add -->
    <div id="ModalAdd" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content" style="width:400px;">
          <div class="modal-header" style="padding:35px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <center><h4 class="modal-title"><b>Create New Customer</b></h4></center>
          </div>
          <div class="modal-body">
            <form action="../pages/crud/Customer_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">>
              <div class="form-group">
                <label>Customer Name</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input name="customername" type="text" class="form-control" style="width:330px;" placeholder="Customer Name" required="" />
                  </div>
              </div>
              <div class="form-group">
                <label>Address</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-map-marker"></i>
                    </div>
                    <input name="address" type="text" class="form-control" style="width:330px;" placeholder="Address" required="" />
                  </div>
              </div>
              <div class="form-group">
                <label>Contact</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input name="contact" type="text" class="form-control" style="width:330px;" placeholder="Contact" required="" />
                  </div>
              </div>
              <label> </label> <!-- Pengatur Jarak -->
              <div class="modal-footer">
                <button class="btn btn-success" type="submit" style="width:110px;"><i class="fa fa-save"></i> SAVE</button>
                <button type="reset" class="btn btn-danger" style="width:110px;" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> CANCEL</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal Content Add -->

    <!-- Modal Content Delete -->
      <!-- Modal Popup untuk delete --> 
      <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" style="text-align:center;"> Are You Sure Delete This Customer ?</h4>
            </div>
                      
            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
              <a href="#" style="width:100px;" class="btn btn-danger" id="delete_link"><i class="fa fa-trash"> Delete</i></a>
              <button type="button" style="width:100px;" class="btn btn-success" data-dismiss="modal"><i class="fa fa-times"> Cancel</i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal Popup untuk delete --> 

      <!-- Javascript untuk popup modal Hapus--> 
      <script type="text/javascript">
          function confirm_modal(delete_url)
          {
            $('#modal_delete').modal('show', {backdrop: 'static'});
            document.getElementById('delete_link').setAttribute('href' , delete_url);
          }
      </script>
      <!-- End Javascript untuk popup modal Hapus--> 
    <!-- End Modal Content Delete -->

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   