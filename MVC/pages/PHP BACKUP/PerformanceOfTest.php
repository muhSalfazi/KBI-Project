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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Performance Of Test</h1>
      </div>
      <!-- End Title -->

      <br><br>

      <div class="full-container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#new">NEW</a></li>
          <li><a data-toggle="tab" href="#complete">COMPLETE</a></li>
        </ul>

        <div class="tab-content">
          <div id="new" class="tab-pane fade in active">
            <!-- Table New -->
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                      List All Data Performance Of Test
                  </div>

                  <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <div class="container">
                        <thead>
                          <th class="text-center" style="width:40px;">NO</th>
                          <th class="text-center" style="width:100px;">PROJECT NAME</th>
                          <th class="text-center" style="width:100px;">CUSTOMER NAME</th>
                          <th class="text-center" style="width:100px;">ISSUE DATE</th>
                          <th class="text-center" style="width:100px;">DUE DATE</th>
                          <th class="text-center" style="width:100px;">MENU</th>
                        </thead>

                        <?php
                          $No = 0;
                          $QueryListIDRFQ=mysqli_query($mysqli, "SELECT DISTINCT `id_rfq` FROM `tbl_rfq` ORDER BY tbl_rfq.id_rfq DESC");
                          while($ResultQueryListIDRFQ=mysqli_fetch_array($QueryListIDRFQ)){
                            $QueryListRFQForms=mysqli_query($mysqli, "
							SELECT * FROM tbl_rfq LEFT JOIN tbl_perf_of_test ON tbl_rfq.id_rfq = tbl_perf_of_test.idrfq_perf 
							INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer 
							WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDRFQ['id_rfq']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision 
							FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDRFQ['id_rfq'].")");
                            if($ResultQueryListRFQForms=mysqli_fetch_array($QueryListRFQForms)){
                              if($ResultQueryListRFQForms['id_rfq'] != null && $ResultQueryListRFQForms['idrfq_perf'] == null){
                                $No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['issue_date']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['deadline_qe']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='PerformanceOfTestFill.php?ID=".$ResultQueryListRFQForms['id_rfq']."'><i class='fa fa-edit'> Fill</i></a>"; 
                            ?>
                          </td>
                        </tr>
                        <?php 
                              }
                            }
                          } 
                        ?>

                      </div>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Table New -->
          </div>
          <div id="complete" class="tab-pane fade">
            <!-- Table Complete -->
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                      List All Data Performance Of Test
                  </div>

                  <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <div class="container">
                        <thead>
                          <th class="text-center" style="width:40px;">NO</th>
                          <th class="text-center" style="width:100px;">PROJECT NAME</th>
                          <th class="text-center" style="width:100px;">CUSTOMER NAME</th>
                          <th class="text-center" style="width:100px;">CREATED BY</th>
                          <th class="text-center" style="width:100px;">DATE CREATED</th>
                          <th class="text-center" style="width:100px;">MENU</th>
                        </thead>

                        <?php
                          $No = 0;
                          $QueryListIDRFQ=mysqli_query($mysqli, "SELECT DISTINCT `id_rfq` FROM `tbl_rfq` ORDER BY tbl_rfq.id_rfq DESC");
                          while($ResultQueryListIDRFQ=mysqli_fetch_array($QueryListIDRFQ)){
                            $QueryListPerformanceOfTest=mysqli_query($mysqli, 
							"SELECT * FROM tbl_perf_of_test INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_perf_of_test.idrfq_perf 
							INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer 
							INNER JOIN tbl_user ON tbl_perf_of_test.id_user = tbl_user.id_user 
							WHERE tbl_perf_of_test.idrfq_perf = ".$ResultQueryListIDRFQ['id_rfq']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision 
							FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDRFQ['id_rfq'].") AND tbl_perf_of_test.revision_perf = (SELECT MAX(tbl_perf_of_test.revision_perf) as revision_perf FROM tbl_perf_of_test 
							WHERE tbl_perf_of_test.idrfq_perf = ".$ResultQueryListIDRFQ['id_rfq'].")");
                            if($ResultQueryListPerformanceOfTest=mysqli_fetch_array($QueryListPerformanceOfTest)){
                              $No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPerformanceOfTest['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPerformanceOfTest['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPerformanceOfTest['full_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPerformanceOfTest['created_perf']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='PerformanceOfTestEdit.php?ID=".$ResultQueryListPerformanceOfTest['idrfq_perf']."'><i class='fa fa-edit'> Edit</i></a>"; 
                            ?> 

                            <?php 
                              echo"<a href='#ModalPrintPerformanceOfTest' class='btn btn-success btn-xs' style='width:65px;' data-toggle='modal' data-id=".$ResultQueryListPerformanceOfTest['idrfq_perf']."><i class='fa fa-print'> Print</i></a>"; 
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
            <!-- End Table Complete -->
          </div>
        </div>
      </div>

    </div>
    <!-- End Content -->

    <!-- Modal Content Delete -->
      <!-- Modal Popup untuk delete --> 
      <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" style="text-align:center;"> Are You Sure Delete This Data ?</h4>
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
	
	<!-- Modal ModalPrintPerformanceOfTest--> 
      <div class="modal fade" id="ModalPrintPerformanceOfTest" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header" style="padding:35px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <center><h4 class="modal-title">Print Report By Revision PoT</h4></center>
                  </div>
                  <div class="modal-body">
                      <div class="fetched-data"></div>
                  </div>
              </div>
          </div>
      </div>
    <!-- End Modal ModalPrintPerformanceOfTest--> 
 
    <!-- Javascript ModalPrintPerformanceOfTest --> 
    <script type="text/javascript">
      $(document).ready(function(){
          $('#ModalPrintPerformanceOfTest').on('show.bs.modal', function (e) {
              var id = $(e.relatedTarget).data('id');
              //menggunakan fungsi ajax untuk pengambilan data
              $.ajax({
                  type : 'post',
                  url : 'ModalPrintPerformanceOfTest.php',
                  data :  'id='+ id,
                  success : function(data){
                  $('.fetched-data').html(data);//menampilkan data ke dalam modal
                  }
              });
           });
      });
    </script>
    <!-- End Javascript ModalPrintPerformanceOfTest --> 

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   