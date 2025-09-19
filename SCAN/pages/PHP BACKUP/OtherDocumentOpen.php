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

<?php
if ($_GET['ID']) {
//validasi ID

  $IdRFQ = $_GET['ID'];
?>

	  <!-- Content -->
    <div class="row">

    	<!-- Title -->
      <div class="col-lg-12">
          <h1 class="page-header"><i class="fa fa-user fa-fw""></i> RFQ Document</h1>
      </div>
      <!-- End Title -->

      <br><br><br><br><br><br>

      <?php
        $QuerySelectAllDocument=mysqli_query($mysqli, "SELECT tbl_rfq.project_name as project_name_rfq, tbl_rfq.name_doc AS name_doc_rfq, tbl_rfq.size_doc AS size_doc_rfq, tbl_rfq.path_file AS path_file_rfq, tbl_bill_of_material.name_doc AS name_doc_bilofmat, tbl_bill_of_material.size_doc AS size_doc_bilofmat, tbl_bill_of_material.path_file AS path_file_bilofmat, tbl_product_q.name_doc AS name_doc_prodq, tbl_product_q.size_doc AS size_doc_prodq, tbl_product_q.path_file AS path_file_prodq, tbl_perf_of_test.name_doc AS name_doc_prefoftest, tbl_perf_of_test.size_doc AS size_doc_prefoftest, tbl_perf_of_test.path_file AS path_file_prefoftest FROM tbl_rfq LEFT JOIN tbl_bill_of_material ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill LEFT JOIN tbl_product_q ON tbl_rfq.id_rfq = tbl_product_q.idrfq_p LEFT JOIN tbl_perf_of_test ON tbl_rfq.id_rfq = tbl_perf_of_test.idrfq_perf WHERE tbl_rfq.id_rfq = $IdRFQ");
        $ResultQuerySelectAllDocument=mysqli_fetch_array($QuerySelectAllDocument);  
      ?>

      <div class="modal-content" style="width:700px;">
        <div class="modal-header" style="padding:35px;">
          <center><h3 class="modal-title"><b>All <?php echo $ResultQuerySelectAllDocument['project_name_rfq']; ?> Document</b></h3></center>
        </div>
        <div class="modal-body">
          <h3><strong>RFQ FORM</strong></h3>
          <table width="100%" border="1">
            <div>
              <thead>
                <th class="text-center" style="width:10px;">NO</th>
                <th class="text-left" style="width:170px;">Name</th>
                <th class="text-center" style="width:10px;">Size</th>
                <th class="text-center" style="width:10px;">Menu</th>
              </thead>
              <?php
                $NameFileRFQ = explode(",",$ResultQuerySelectAllDocument['name_doc_rfq']);
                $SizeFileRFQ = explode(",",$ResultQuerySelectAllDocument['size_doc_rfq']);
                $PathFileRFQ = explode(",",$ResultQuerySelectAllDocument['path_file_rfq']);
                $IndexRFQ = 0;
                foreach ($SizeFileRFQ as $ValueSizeFileRFQ) {
                  
                  if($ValueSizeFileRFQ != null){
                    ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $IndexRFQ+1; ?>
                      </td>
                      <td class="text-left">
                        <?php echo $NameFileRFQ[$IndexRFQ]; ?>
                      </td>
                      <td class="text-center">
                        <?php echo $SizeFileRFQ[$IndexRFQ]; ?>
                      </td>
                      <td class="text-center">
                        <?php 
                          echo"<a class='btn-warning btn-xs' style='width:65px;' href='file/RFQForm/".$NameFileRFQ[$IndexRFQ]."'><i class='fa fa-cloud-download'> Download</i></a>"; 
                        ?> 
                      </td>
                    </tr>
                    <?php
                  $IndexRFQ++;
                  }

                }
              ?>
            </div>
          </table>
          <hr/>
          <h3><strong>BILL OF MATERIAL</strong></h3>
          <table width="100%" border="1">
            <div>
              <thead>
                <th class="text-center" style="width:10px;">NO</th>
                <th class="text-left" style="width:170px;">Name</th>
                <th class="text-center" style="width:10px;">Size</th>
                <th class="text-center" style="width:10px;">Menu</th>
              </thead>
              <?php
                $NameFileBilOfMat = explode(",",$ResultQuerySelectAllDocument['name_doc_bilofmat']);
                $SizeFileBilOfMat = explode(",",$ResultQuerySelectAllDocument['size_doc_bilofmat']);
                $PathFileBilOfMat = explode(",",$ResultQuerySelectAllDocument['path_file_bilofmat']);
                $IndexBilOfMat = 0;
                foreach ($SizeFileBilOfMat as $ValueSizeFileBilOfMat) {
                  
                  if($ValueSizeFileBilOfMat!= null){
                    ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $IndexBilOfMat+1; ?>
                      </td>
                      <td class="text-left">
                        <?php echo $NameFileBilOfMat[$IndexBilOfMat]; ?>
                      </td>
                      <td class="text-center">
                        <?php echo $SizeFileBilOfMat[$IndexBilOfMat]; ?>
                      </td>
                      <td class="text-center">
                        <?php 
                          echo"<a class='btn-warning btn-xs' style='width:65px;' href='file/BillOfMaterial/".$NameFileBilOfMat[$IndexBilOfMat]."'><i class='fa fa-cloud-download'> Download</i></a>"; 
                        ?> 
                      </td>
                    </tr>
                    <?php
                  $IndexBilOfMat++;
                  }

                }
              ?>
            </div>
          </table>
          <hr/>
          <h3><strong>PRODUCT QUOTATION</strong></h3>
          <table width="100%" border="1">
            <div>
              <thead>
                <th class="text-center" style="width:10px;">NO</th>
                <th class="text-left" style="width:170px;">Name</th>
                <th class="text-center" style="width:10px;">Size</th>
                <th class="text-center" style="width:10px;">Menu</th>
              </thead>
              <?php
                $NameFileProdQ = explode(",",$ResultQuerySelectAllDocument['name_doc_prodq']);
                $SizeFileProdQ = explode(",",$ResultQuerySelectAllDocument['size_doc_prodq']);
                $PathFileProdQ = explode(",",$ResultQuerySelectAllDocument['path_file_prodq']);
                $IndexProdQ = 0;
                foreach ($SizeFileProdQ as $ValueSizeFileProdQ) {
                  
                  if($ValueSizeFileProdQ != null){
                    ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $IndexProdQ+1; ?>
                      </td>
                      <td class="text-left">
                        <?php echo $NameFileProdQ[$IndexProdQ]; ?>
                      </td>
                      <td class="text-center">
                        <?php echo $SizeFileProdQ[$IndexProdQ]; ?>
                      </td>
                      <td class="text-center">
                        <?php 
                          echo"<a class='btn-warning btn-xs' style='width:65px;' href='file/ProductQuotation/".$NameFileProdQ[$IndexProdQ]."'><i class='fa fa-cloud-download'> Download</i></a>"; 
                        ?> 
                      </td>
                    </tr>
                    <?php
                  $IndexProdQ++;
                  }

                }
              ?>
            </div>
          </table>
          <hr/>
          <h3><strong>PERFORMANCE OF TEST</strong></h3>
          <table width="100%" border="1">
            <div>
              <thead>
                <th class="text-center" style="width:10px;">NO</th>
                <th class="text-left" style="width:170px;">Name</th>
                <th class="text-center" style="width:10px;">Size</th>
                <th class="text-center" style="width:10px;">Menu</th>
              </thead>
              <?php
                $NameFilePrefOfTest = explode(",",$ResultQuerySelectAllDocument['name_doc_prefoftest']);
                $SizeFilePrefOfTest = explode(",",$ResultQuerySelectAllDocument['size_doc_prefoftest']);
                $PathFilePrefOfTest = explode(",",$ResultQuerySelectAllDocument['path_file_prefoftest']);
                $IndexPrefOfTest = 0;
                foreach ($PathFilePrefOfTest as $ValuePathFilePrefOfTest) {
                  
                  if($ValuePathFilePrefOfTest != null){
                    ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $IndexPrefOfTest+1; ?>
                      </td>
                      <td class="text-left">
                        <?php echo $NameFilePrefOfTest[$IndexPrefOfTest]; ?>
                      </td>
                      <td class="text-center">
                        <?php echo $SizeFilePrefOfTest[$IndexPrefOfTest]; ?>
                      </td>
                      <td class="text-center">
                        <?php 
                          echo"<a class='btn-warning btn-xs' style='width:65px;' href='file/PerformanceOfTest/".$NameFileRFQ[$IndexPrefOfTest]."'><i class='fa fa-cloud-download'> Download</i></a>"; 
                        ?> 
                      </td>
                    </tr>
                    <?php
                  $IndexPrefOfTest++;
                  }

                }
              ?>
            </div>
          </table>
          <hr/>
          <h3><strong>PACKAGING & TRANSPORT</strong></h3>
          <table width="100%" border="1">
            <div>
              <thead>
                <th class="text-center" style="width:10px;">NO</th>
                <th class="text-left" style="width:170px;">Name</th>
                <th class="text-center" style="width:10px;">Size</th>
                <th class="text-center" style="width:10px;">Menu</th>
              </thead>
            </div>
          </table>
          <hr/>
          <h3><strong>NPD QUOTATION</strong></h3>
          <table width="100%" border="1">
            <div>
              <thead>
                <th class="text-center" style="width:10px;">NO</th>
                <th class="text-left" style="width:170px;">Name</th>
                <th class="text-center" style="width:10px;">Size</th>
                <th class="text-center" style="width:10px;">Menu</th>
              </thead>
            </div>
          </table>
          <hr/>
        </div>
      </div>

    </div>
    <!-- End Content -->

<?php
}
//End Validasi ID
?>   

<?php
  require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>   