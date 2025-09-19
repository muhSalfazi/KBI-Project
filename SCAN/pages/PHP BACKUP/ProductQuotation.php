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
          <h1 class="page-header"><i class="fa fa-file fa-fw""></i> Product Quotation</h1>
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
                      List All Data Product Quotation
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
                          $IdRole = 0;
                          $QueryListRFQForms=mysqli_query($mysqli, "SELECT MAX(tbl_rfq.revision) AS revision, tbl_rfq.id_rfq, tbl_rfq.project_name, tbl_customer.customer_name, tbl_rfq.issue_date, tbl_rfq.deadline_npd, tbl_bill_of_material.id_rfq_bill, tbl_bill_of_material.id_intacs, tbl_product_q.idrfq_p, tbl_perf_of_test.idrfq_perf, tbl_packaging.idrfq_pack, tbl_npd.idrfq_npd FROM tbl_rfq LEFT JOIN tbl_bill_of_material ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill LEFT JOIN tbl_product_q on tbl_product_q.idrfq_p = tbl_rfq.id_rfq LEFT JOIN tbl_perf_of_test ON tbl_perf_of_test.idrfq_perf = tbl_rfq.id_rfq LEFT JOIN tbl_packaging ON tbl_packaging.idrfq_pack = tbl_rfq.id_rfq LEFT JOIN tbl_npd ON tbl_packaging.idrfq_pack = tbl_npd.idrfq_npd INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_material ON tbl_rfq.id_material = tbl_material.id_material ORDER BY tbl_rfq.id_rfq DESC");
                          while($ResultQueryListRFQForms=mysqli_fetch_array($QueryListRFQForms)){
                            if($ResultQueryListRFQForms['id_rfq_bill'] != null && $ResultQueryListRFQForms['id_intacs'] != null && $ResultQueryListRFQForms['idrfq_p'] != null && $ResultQueryListRFQForms['idrfq_perf'] != null && $ResultQueryListRFQForms['idrfq_pack'] != null && $ResultQueryListRFQForms['idrfq_npd'] == null){
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
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='ProductQuotationFill.php?ID=".$ResultQueryListRFQForms['id_rfq']."'><i class='fa fa-edit'> Fill</i></a>"; 
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
            <!-- End Table New -->
          </div>
          <div id="complete" class="tab-pane fade">
            <!-- Table Complete -->
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                      List All Data Product Quotation
                  </div>

                  <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <div class="container">
                        <thead>
                          <th class="text-center" style="width:40px;">NO</th>
                          <th class="text-center" style="width:100px;">PROJECT NAME</th>
                          <th class="text-center" style="width:100px;">CUSTOMER NAME</th>
                          <th class="text-center" style="width:100px;">DUE DATE</th>
                          <th class="text-center" style="width:100px;">MENU</th>
                        </thead>

                        <?php
                          $No = 0;
                          $IdRole = 0;
                          $QueryListNPDs=mysqli_query($mysqli, "SELECT * FROM tbl_npd ORDER BY id_npd DESC");
                          while($ResultQueryListNPDs=mysqli_fetch_array($QueryListNPDs)){
                            $No++;
                        ?>

                        <tr>
                          <td class="text-center"><?php echo $No; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListNPDs['project_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListNPDs['customer_name']; ?></td>
                          <td class="text-center"><?php echo $ResultQueryListNPDs['sop']; ?></td>
                          <td class="text-center">
                            <?php 
                              echo"<a class='btn btn-warning btn-xs' style='width:65px;' href='ProductQuotationEdit.php?ID=".$ResultQueryListNPDs['id_npd']."'><i class='fa fa-edit'> Edit</i></a>"; 
                            ?> 

                            <?php 
                              echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_ProductQuotation.php?ID=".$ResultQueryListNPDs['id_npd']."'><i class='fa fa-print'> Print</i></a>"; 
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

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   