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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> RFQ Form</h1>
      </div>
      <!-- End Title -->

      <?php
        $QuerySelectsFeasibility=mysqli_query($mysqli, "SELECT * FROM doc_feasibility WHERE status = 1 AND doc_use = 0");
        $ResultQuerySelectsFeasibility=mysqli_fetch_array($QuerySelectsFeasibility);
      ?>

      <!-- Button -->
      <!-- <a href="../pages/cetak/data_proses.php">
      	<button style="width:150px;" class="btn btn-warning"><i class="fa fa-print"></i> Cetak Daftar</button>
      </a> -->
      <?php
        if(!$ResultQuerySelectsFeasibility['iddoc_feasibility'] == null){
          ?>
          <a href="RFQFormAdd.php">
            <button style="width:150px;" data-toggle="modal" data-target="#ModalAdd" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Data</button>
          </a>
          <?php
        }else{
          ?>
          <button style="width:150px;" data-toggle="modal" data-target="#ModalAdd" class="btn btn-primary" disabled><i class="fa fa-plus"></i> Add New Data</button>
          <?php
        }
      ?>
      
      <!-- End Button -->

      <br><br>

	<!-- Table -->
	<div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
                List All Data RFQ Form
            </div>

            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			    <div class="container">
		      <thead>
		        <th class="text-center" style="width:40px;">NO</th>
            <th class="text-center" style="width:100px;">PROJECT NAME</th>
  					<th class="text-center" style="width:100px;">CUSTOMER NAME</th>
          	<th class="text-center" style="width:100px;">ISSUE DATE</th>
            <th class="text-center" style="width:100px;">CREATED BY</th>
            <th class="text-center" style="width:100px;">DATE CREATED</th>
  					<th class="text-center" style="width:100px;">MENU</th>
				  </thead>

		      	<?php
		      		$No = 0;
        			$IdRole = 0;
		      		$QueryListRFQForms=mysqli_query($mysqli, "SELECT DISTINCT `id_rfq` FROM `tbl_rfq` ORDER BY tbl_rfq.id_rfq DESC");
		      		while($ResultQueryListRFQForms=mysqli_fetch_array($QueryListRFQForms)){
                $QueryIdRFQForm=mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_user ON tbl_user.id_user = tbl_rfq.id_user INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer WHERE tbl_rfq.id_rfq = ".$ResultQueryListRFQForms['id_rfq']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListRFQForms['id_rfq'].")");
                if($ResultQueryIdRFQForm=mysqli_fetch_array($QueryIdRFQForm)){
      				    $No++;
				    ?>

				    <tr>
			        <td class="text-center"><?php echo $No; ?></td>
              <td class="text-center"><?php echo $ResultQueryIdRFQForm['project_name']; ?></td>
              <td class="text-center"><?php echo $ResultQueryIdRFQForm['customer_name']; ?></td>
              <td class="text-center"><?php echo $ResultQueryIdRFQForm['issue_date']; ?></td>
              <td class="text-center"><?php echo $ResultQueryIdRFQForm['full_name']; ?></td>
              <td class="text-center"><?php echo $ResultQueryIdRFQForm['created']; ?></td>
              <td class="text-center">
                <?php 
                  echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='RFQFormEdit.php?ID=".$ResultQueryIdRFQForm['id_rfq']."'><i class='fa fa-edit'> Edit</i></a>"; 
                ?> 

                <?php echo "<a href='#ModalPrintRFQ' class='btn btn-success btn-xs' style='width:65px;' data-toggle='modal' data-id=".$ResultQueryIdRFQForm['id_rfq']."><i class='fa fa-print'> Print</i></a>"; 
                ?>
              </td>
			      </tr>
    				<?php
    						}
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

      <!-- Modal ModalPrintRFQ--> 
      <div class="modal fade" id="ModalPrintRFQ" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header" style="padding:35px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <center><h4 class="modal-title">Print Report By Revision</h4></center>
                  </div>
                  <div class="modal-body">
                      <div class="fetched-data"></div>
                  </div>
              </div>
          </div>
      </div>
      <!-- End Modal ModalPrintRFQ--> 
 
    <!-- Javascript ModalPrintRFQ --> 
    <script type="text/javascript">
      $(document).ready(function(){
          $('#ModalPrintRFQ').on('show.bs.modal', function (e) {
              var id = $(e.relatedTarget).data('id');
              //menggunakan fungsi ajax untuk pengambilan data
              $.ajax({
                  type : 'post',
                  url : 'ModalPrintRFQForm.php',
                  data :  'id='+ id,
                  success : function(data){
                  $('.fetched-data').html(data);//menampilkan data ke dalam modal
                  }
              });
           });
      });
    </script>
    <!-- End Javascript ModalPrintRFQ --> 

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   