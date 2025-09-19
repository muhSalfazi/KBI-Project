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
                          $QueryListIDRFQ=mysqli_query($mysqli, "SELECT DISTINCT `id_rfq` FROM `tbl_rfq` WHERE id_rfq = ".$RFQPQID." ORDER BY tbl_rfq.id_rfq DESC");
                          while($ResultQueryListIDRFQ=mysqli_fetch_array($QueryListIDRFQ)){
                            $QueryListPackagingTransports=mysqli_query($mysqli, 
							"SELECT * FROM tbl_packaging INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_packaging.idrfq_pack 
							INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer 
							INNER JOIN tbl_user ON tbl_packaging.iduser_pack = tbl_user.id_user 
							
							WHERE tbl_packaging.idrfq_pack = ".$ResultQueryListIDRFQ['id_rfq']."
							");
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
            echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_PreliminaryPackagingTransport.php?ID=".$ResultQueryListPackagingTransports['id_packaging']."&REVISION=".$ResultQueryListPackagingTransports['revision_pack']."'><i class='fa fa-print'> Print</i></a>"; 
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