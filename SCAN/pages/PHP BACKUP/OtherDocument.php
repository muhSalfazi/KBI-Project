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
          <h1 class="page-header"><i class="fa fa-book fa-fw""></i> Other Document</h1>
      </div>
      <!-- End Title -->

      <!-- Table -->
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
                List All Data Other Document
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  							<div class="container">
					      	<thead>
					        	<th class="text-center" style="width:40px;">NO</th>
                    <th class="text-center" style="width:100px;">PROJECT NAME</th>
                    <th class="text-center" style="width:100px;">CUSTOMER NAME</th>
                    <th class="text-center" style="width:100px;">ISSUE DATE</th>
                    <th class="text-center" style="width:100px;">MENU</th>
					      	</thead>

					      	<?php
					      		$No = 0;
                    $IdRole = 0;
					      		$QueryListOtherDocuments=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_material ON tbl_rfq.id_material = tbl_material.id_material ORDER BY tbl_rfq.id_rfq DESC");
					      		while($ResultQueryListOtherDocuments=mysqli_fetch_array($QueryListOtherDocuments)){
			    				    $No++;
  						    ?>

							    <tr>
						        <td class="text-center"><?php echo $No; ?></td>
                    <td class="text-center"><?php echo $ResultQueryListOtherDocuments['project_name']; ?></td>
                    <td class="text-center"><?php echo $ResultQueryListOtherDocuments['customer_name']; ?></td>
                    <td class="text-center"><?php echo $ResultQueryListOtherDocuments['issue_date']; ?></td>
                    <td class="text-center">
                      <?php 
                        echo"<a class='btn btn-primary btn-xs' style='width:65px;' href='OtherDocumentOpen.php?ID=".$ResultQueryListOtherDocuments['id_rfq']."'><i class='fa fa-folder-open'> Open</i></a>"; 
                      ?> 
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
            <center><h4 class="modal-title"><b>Upload New File Other Document</b></h4></center>
          </div>
          <div class="modal-body">
            <form action="../pages/crud/OtherDocument_Add.php" name="modal_popup" enctype="multipart/form-data" method="post">
              <div class="form-group">
                <label>Upload File</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <input name="od" type="file" class="form-control" style="width:330px;" required="" />
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
              <h4 class="modal-title" style="text-align:center;"> Are You Sure Delete This File ?</h4>
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