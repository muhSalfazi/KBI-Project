<?php
  include_once("../connection.php");
?> 

<?php
  if($_POST['id']) {
    $RFQPQID = $_POST['id'];
?>

<div class="modal-body">
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
                          $QueryListIDRFQ=mysqli_query($mysqli, "SELECT DISTINCT `idperf_oftest` FROM `tbl_perf_of_test` WHERE idrfq_perf = ".$RFQPQID." ORDER BY idrfq_perf DESC");
                          while($ResultQueryListIDRFQ=mysqli_fetch_array($QueryListIDRFQ)){
                            $QueryListPerformanceOfTest=mysqli_query($mysqli, 
							"SELECT * FROM tbl_perf_of_test INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_perf_of_test.idrfq_perf 
							INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer 
							INNER JOIN tbl_user ON tbl_perf_of_test.id_user = tbl_user.id_user 
							WHERE idperf_oftest = ".$ResultQueryListIDRFQ['idperf_oftest']."
							");
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
            echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_PreliminaryPerformanceOfTest.php?ID=".$ResultQueryListPerformanceOfTest['idperf_oftest']."&REVISION=".$ResultQueryListPerformanceOfTest['revision_perf']."'><i class='fa fa-print'> Print</i></a>"; 
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
<?php 
  }
?>