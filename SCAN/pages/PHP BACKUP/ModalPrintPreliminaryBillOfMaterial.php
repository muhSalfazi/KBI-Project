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
        $QueryGetListIDPBOM = mysqli_query($mysqli, "SELECT DISTINCT tbl_bill_of_material.revision_pbom FROM tbl_bill_of_material WHERE tbl_bill_of_material.id_rfq_bill = ".$RFQBillID." ORDER BY tbl_bill_of_material.id_bill DESC");
        while($ResultQueryGetListIDPBOM=mysqli_fetch_array($QueryGetListIDPBOM)){
          $QueryGetIDPBOM = mysqli_query($mysqli, "SELECT * FROM tbl_bill_of_material INNER JOIN tbl_user ON tbl_user.id_user = tbl_bill_of_material.id_user WHERE tbl_bill_of_material.id_rfq_bill = ".$RFQBillID." AND tbl_bill_of_material.revision_pbom = ".$ResultQueryGetListIDPBOM['revision_pbom']."");
          if($ResultQueryGetIDPBOM=mysqli_fetch_array($QueryGetIDPBOM)){
            $QueryGetIDRFQForm = mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer WHERE tbl_rfq.id_rfq = ".$ResultQueryGetIDPBOM['id_rfq_bill']." AND tbl_rfq.revision = (SELECT MAX(tbl_rfq.revision) as revision FROM tbl_rfq WHERE tbl_rfq.id_rfq = ".$ResultQueryGetIDPBOM['id_rfq_bill'].")");
            if($ResultQueryGetIDRFQForm=mysqli_fetch_array($QueryGetIDRFQForm)){
            $No++;
      ?>

      <tr>
        <td class="text-center"><?php echo $No; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['project_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['customer_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['issue_date']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPBOM['full_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDPBOM['created_b']; ?></td>
        <td class="text-center">
          <?php 
            echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_PreliminaryBillOfMaterial.php?ID=".$ResultQueryGetIDPBOM['id_rfq_bill']."&REVISION=".$ResultQueryGetIDPBOM['revision_pbom']."'><i class='fa fa-print'> Print</i></a>"; 
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
<?php 
  }
?>