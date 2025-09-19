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
      <th class="text-center" style="width:100px;">ISSUE DATE</th>
      <th class="text-center" style="width:100px;">CREATED BY</th>
      <th class="text-center" style="width:100px;">DATE CREATED</th>
      <th class="text-center" style="width:100px;">MENU</th>
    </thead>

      <?php
        $No = 0;
        $QueryGetListIDPQ = mysqli_query($mysqli, "SELECT DISTINCT tbl_product_q.id_product FROM tbl_product_q WHERE tbl_product_q.idrfq_p = ".$RFQPQID." ORDER BY tbl_product_q.id_product DESC");
        while($ResultQueryGetListIDPQ=mysqli_fetch_array($QueryGetListIDPQ)){
          $QueryGetIDPQ = mysqli_query($mysqli, "SELECT * FROM tbl_product_q INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_product_q.idrfq_p INNER JOIN tbl_customer ON tbl_customer.id_customer = tbl_rfq.id_customer INNER JOIN tbl_user ON tbl_user.id_user = tbl_product_q.id_user WHERE tbl_product_q.id_product = ".$ResultQueryGetListIDPQ['id_product']."");
          if($ResultQueryGetIDPQ=mysqli_fetch_array($QueryGetIDPQ)){
            $No++;
      ?>

      <tr>
        <td class="text-center"><?php echo $No; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPQ['project_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPQ['customer_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPQ['issue_date']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPQ['full_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPQ['created_q']; ?></td>
        <td class="text-center">
          <?php 
            echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_PreliminaryProductQuotation.php?ID=".$ResultQueryGetIDPQ['idrfq_p']."&REVISION=".$ResultQueryGetIDPQ['revision_q']."'><i class='fa fa-print'> Print</i></a>"; 
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