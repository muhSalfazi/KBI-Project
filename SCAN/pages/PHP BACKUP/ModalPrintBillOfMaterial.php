<?php
  include_once("../connection.php");
?> 

<?php
  if($_POST['id']) {
    $RFQBillID = $_POST['id'];
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
        $QueryGetListIDBOM = mysqli_query($mysqli, "SELECT DISTINCT tbl_bill_of_material.id_bill FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$RFQBillID." ORDER BY tbl_bill_of_material.id_bill DESC");
        while($ResultQueryGetListIDBOM=mysqli_fetch_array($QueryGetListIDBOM)){
          $QueryGetIDBOM = mysqli_query($mysqli, "SELECT * FROM tbl_bill_of_material INNER JOIN tbl_rfq ON tbl_rfq.id_rfq = tbl_bill_of_material.id_rfq_bill INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_user ON tbl_bill_of_material.id_user = tbl_user.id_user WHERE tbl_bill_of_material.id_bill = ".$ResultQueryGetListIDBOM['id_bill']." AND tbl_bill_of_material.revision_pbom = (SELECT MAX(tbl_bill_of_material.revision_pbom) as revision_pbom FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$RFQBillID.") AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$RFQBillID.")");
          if($ResultQueryGetIDBOM=mysqli_fetch_array($QueryGetIDBOM)){
            $No++;
      ?>

      <tr>
        <td class="text-center"><?php echo $No; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDBOM['project_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDBOM['customer_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDBOM['issue_date']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDBOM['full_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDBOM['created_npd']; ?></td>
        <td class="text-center">
          <?php 
            echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_BillOfMaterial.php?ID=".$ResultQueryGetIDBOM['id_rfq_bill']."&REVISION=".$ResultQueryGetIDBOM['revision_bom']."'><i class='fa fa-print'> Print</i></a>"; 
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