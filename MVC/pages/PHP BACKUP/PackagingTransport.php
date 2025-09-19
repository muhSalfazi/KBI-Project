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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Packaging Transport</h1>
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
                      List All Data Packaging Transport
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
                            $QueryListRFQForms=mysqli_query($mysqli, "SELECT * FROM tbl_rfq LEFT JOIN tbl_packaging ON tbl_rfq.id_rfq = tbl_packaging.idrfq_pack INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDRFQ['id_rfq']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDRFQ['id_rfq'].")");
                            if($ResultQueryListRFQForms=mysqli_fetch_array($QueryListRFQForms)){
                              if($ResultQueryListRFQForms['idrfq_pack'] == null){
                                $No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['issue_date']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['deadline_npd']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='PackagingTransportFill.php?ID=".$ResultQueryListRFQForms['id_rfq']."'><i class='fa fa-edit'> Fill</i></a>"; 
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
                      List All Data Packaging Transport
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
                            $QueryListPackagingTransports=mysqli_query($mysqli, "SELECT * FROM tbl_packaging INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_packaging.idrfq_pack INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_packaging.iduser_pack = tbl_user.id_user WHERE tbl_packaging.idrfq_pack = ".$ResultQueryListIDRFQ['id_rfq']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDRFQ['id_rfq'].") AND tbl_packaging.revision_pack = (SELECT MAX(tbl_packaging.revision_pack) as revision_pack FROM tbl_packaging WHERE tbl_packaging.idrfq_pack = ".$ResultQueryListIDRFQ['id_rfq'].")");
                            if($ResultQueryListPackagingTransports=mysqli_fetch_array($QueryListPackagingTransports)){
                              $No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPackagingTransports['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPackagingTransports['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPackagingTransports['full_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListPackagingTransports['created_pack']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='PackagingTransportEdit.php?ID=".$ResultQueryListIDRFQ['id_rfq']."'><i class='fa fa-edit'> Edit</i></a>"; 
                            ?> 

                             <?php 
                               echo"<a href='#ModalPrintPackagingTransport' class='btn btn-success btn-xs' style='width:65px;' data-toggle='modal' data-id=".$ResultQueryListIDRFQ['id_rfq']."><i class='fa fa-print'> Print</i></a>";
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
	<!-- Modal ModalPrintPackagingTransport--> 
      <div class="modal fade" id="ModalPrintPackagingTransport" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header" style="padding:35px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <center><h4 class="modal-title">Print Report By Revision PT</h4></center>
                  </div>
                  <div class="modal-body">
                      <div class="fetched-data"></div>
                  </div>
              </div>
          </div>
      </div>
    <!-- End Modal ModalPrintPackagingTransport--> 
 
    <!-- Javascript ModalPrintPackagingTransport --> 
    <script type="text/javascript">
      $(document).ready(function(){
          $('#ModalPrintPackagingTransport').on('show.bs.modal', function (e) {
              var id = $(e.relatedTarget).data('id');
              //menggunakan fungsi ajax untuk pengambilan data
              $.ajax({
                  type : 'post',
                  url : 'ModalPrintPackagingTransport.php',
                  data :  'id='+ id,
                  success : function(data){
                  $('.fetched-data').html(data);//menampilkan data ke dalam modal
                  }
              });
           });
      });
    </script>
    <!-- End Javascript ModalPrintPackagingTransport --> 

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   