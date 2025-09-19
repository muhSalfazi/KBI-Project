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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Preliminary Bill Of Material</h1>
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
                      List All Data Preliminary Bill Of Material
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
                          $QueryListBillOfMaterials=mysqli_query($mysqli, "SELECT DISTINCT `id_rfq` FROM `tbl_rfq` ORDER BY tbl_rfq.id_rfq DESC");
                          while($ResultQueryListBillOfMaterials=mysqli_fetch_array($QueryListBillOfMaterials)){
                            $QueryListRFQForms=mysqli_query($mysqli, "SELECT * FROM tbl_rfq LEFT JOIN tbl_bill_of_material ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer WHERE tbl_rfq.id_rfq = ".$ResultQueryListBillOfMaterials['id_rfq']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListBillOfMaterials['id_rfq'].")");
                            if($ResultQueryListRFQForms=mysqli_fetch_array($QueryListRFQForms)){
                              if($ResultQueryListRFQForms['id_rfq'] != null && $ResultQueryListRFQForms['id_rfq_bill'] == null){
                                $No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['issue_date']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListRFQForms['deadline_de']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='PreliminaryBillOfMaterialFill.php?ID=".$ResultQueryListRFQForms['id_rfq']."'><i class='fa fa-edit'> Fill</i></a>"; 
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
                      List All Data Preliminary Bill Of Material
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
                          $QueryListIDBillOfMaterials=mysqli_query($mysqli, "SELECT DISTINCT `id_rfq_bill` FROM `tbl_bill_of_material` ORDER BY tbl_bill_of_material.id_rfq_bill DESC");
                          while($ResultQueryListIDBillOfMaterials=mysqli_fetch_array($QueryListIDBillOfMaterials)){
                            $QueryListBillOfMaterials=mysqli_query($mysqli, "SELECT * FROM tbl_bill_of_material INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_bill_of_material.id_user = tbl_user.id_user WHERE tbl_bill_of_material.id_rfq_bill = ".$ResultQueryListIDBillOfMaterials['id_rfq_bill']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryListIDBillOfMaterials['id_rfq_bill'].") AND tbl_bill_of_material.revision_pbom = (SELECT MAX(tbl_bill_of_material.revision_pbom) as revision_pbom FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$ResultQueryListIDBillOfMaterials['id_rfq_bill'].") AND tbl_bill_of_material.revision_bom = (SELECT MAX(tbl_bill_of_material.revision_bom) as revision_bom FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$ResultQueryListIDBillOfMaterials['id_rfq_bill'].")");
                            if($ResultQueryListBillOfMaterials=mysqli_fetch_array($QueryListBillOfMaterials)){
                            	$No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListBillOfMaterials['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListBillOfMaterials['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListBillOfMaterials['full_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListBillOfMaterials['created_b']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='PreliminaryBillOfMaterialEdit.php?ID=".$ResultQueryListBillOfMaterials['id_rfq_bill']."&IDBILL=".$ResultQueryListBillOfMaterials['id_bill']."'><i class='fa fa-edit'> Edit</i></a>"; 
                            ?> 

                            <?php echo "<a href='#ModalPrintPBOM' class='btn btn-success btn-xs' style='width:65px;' data-toggle='modal' data-id=".$ResultQueryListBillOfMaterials['id_rfq_bill']."><i class='fa fa-print'> Print</i></a>"; 
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

    <!-- Modal ModalPrintPBOM--> 
      <div class="modal fade" id="ModalPrintPBOM" role="dialog">
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
    <!-- End Modal ModalPrintPBOM--> 
 
    <!-- Javascript ModalPrintPBOM --> 
    <script type="text/javascript">
      $(document).ready(function(){
          $('#ModalPrintPBOM').on('show.bs.modal', function (e) {
              var id = $(e.relatedTarget).data('id');
              //menggunakan fungsi ajax untuk pengambilan data
              $.ajax({
                  type : 'post',
                  url : 'ModalPrintPreliminaryBillOfMaterial.php',
                  data :  'id='+ id,
                  success : function(data){
                  $('.fetched-data').html(data);//menampilkan data ke dalam modal
                  }
              });
           });
      });
    </script>
    <!-- End Javascript ModalPrintPBOM --> 

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   