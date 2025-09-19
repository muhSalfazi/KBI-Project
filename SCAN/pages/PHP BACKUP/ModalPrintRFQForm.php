<?php
  include_once("../connection.php");
?> 

<?php
  if($_POST['id']) {
    $RFQFormID = $_POST['id'];
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
        $QueryGetIDRFQForm = mysqli_query($mysqli, "SELECT * FROM tbl_rfq INNER JOIN tbl_customer ON tbl_rfq.id_customer = tbl_customer.id_customer INNER JOIN tbl_material ON tbl_rfq.id_material = tbl_material.id_material INNER JOIN tbl_user ON tbl_user.id_user = tbl_rfq.id_user WHERE tbl_rfq.id_rfq = ".$RFQFormID." ORDER BY tbl_rfq.id_tbl_rfq DESC");
        while($ResultQueryGetIDRFQForm=mysqli_fetch_array($QueryGetIDRFQForm)){
          $No++;
      ?>

      <tr>
        <td class="text-center"><?php echo $No; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['project_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['customer_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['issue_date']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['full_name']; ?></td>
        <td class="text-center"><?php echo $ResultQueryGetIDRFQForm['created']; ?></td>
        <td class="text-center">
          <?php 
            echo"<a class='btn btn-success btn-xs' style='width:65px;' href='print/Print_RFQForm.php?ID=".$ResultQueryGetIDRFQForm['id_rfq']."&REVISION=".$ResultQueryGetIDRFQForm['revision']."'><i class='fa fa-print'> Print</i></a>"; 
          ?>
        </td>
      </tr>
      <?php 
        } 
      ?>

    </div>
  </table>
</div>
<?php 
  }
?>