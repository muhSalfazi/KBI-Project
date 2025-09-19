<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php
session_start();
$part = $_POST['id_pendaftar'] ?? null;

if ($part === null) {
    echo "ID tidak tersedia. Pastikan elemen pengedit mengirimkan data-id.";
    exit;
}

include_once("../../connection.php");
?>
<div class="panel-body"><?php //echo $_SESSION["id_role"].'xx';//echo $part;
                        ?>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <div class="container">


      <?php

      $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM tbl_deliverytmmin WHERE id='$part'");
      $ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)

      ?>





      <tr>
        <td>Manifest No.</td>
        <td> :
        <td><input name="xx" value="<?php echo $ResultQueryListMaterials['dn_no']; ?>" <?php if ($_SESSION["id_role"] == "1") {
                                                                                          echo ' ';
                                                                                        } else {
                                                                                          echo 'readonly';
                                                                                        } ?>><?php //echo $ResultQueryListMaterials['dn_no'];
                                                                                              ?></td>
      </tr>
      <tr>
        <td>Job No.</td>
        <td> :
        <td><input name="xxx" value="<?php echo $ResultQueryListMaterials['job_no']; ?>"></td>
      </tr>
      <tr>
        <td>Customer Part No.</td>
        <td> :
        <td><input name="xxxx" value="<?php echo $ResultQueryListMaterials['customerpart_no']; ?>"></td>
      </tr>
      <tr>
        <td>Qty Pcs.</td>
        <td> :
        <td><input name="xxxxx" value="<?php echo $ResultQueryListMaterials['qty_pcs']; ?>"></td>
      </tr>
      <tr>
        <td>Delivery Date</td>
        <td> :
        <td><input type="date" placeholder="MM/DD/YYYY" name="tgl" value="<?php echo substr($ResultQueryListMaterials['tanggal_order'], 6, 4) . '-' . substr($ResultQueryListMaterials['tanggal_order'], 3, 2) . '-' . substr($ResultQueryListMaterials['tanggal_order'], 0, 2); ?>"></td>
      </tr>
      <tr>
        <td>Cycle</td>
        <td> :
        <td><input name="aaa" value="<?php echo $ResultQueryListMaterials['cycle']; ?>"></td>
      </tr>
      <tr>
        <td>Plant</td>
        <td> :
        <td><select name="plan">
            <option value="<?php echo $ResultQueryListMaterials['plan']; ?>"><?php echo $ResultQueryListMaterials['plan']; ?></option>
            <option value="KBI-1">KBI-1</option>
            <option value="KBI-2">KBI-2</option>
          </select></td>
      </tr>

      <tr>
        <td>Status</td>
        <td> :
        <td><select name="status">
            <option value="<?php echo $ResultQueryListMaterials['status']; ?>"><?php echo $ResultQueryListMaterials['status']; ?></option>
            <option value="Open">Open</option>
            <option value="Close">Close</option>
          </select></td>
      </tr>
      <tr>
        <td colspan="3" class="text-center"><button name="triger" value="<?php echo $ResultQueryListMaterials['id']; ?>" class="btn btn-sm btn-success" id="simpan-data">Simpan</button></td>
      </tr>
      <tr>
        <td colspan="3">
          <div style="display:none;" class="tutup alert alert-success " id='modal-message'>Data Telah Diupdate</div>
        </td>
      </tr>
  </table>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/jquery.mask.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.date').mask('00/00/0000');
    });
  </script>
  <script type="text/javascript">
    $('#simpan-data').click(function() {

      //Biaya 
      var dn_no = $("input[name=dn_no]").val();
      var job_no = $("input[name=job_no]").val();
      var customerpart_no = $("input[name=customerpart_no]").val();
      var qty_pcs = $("input[name=qty_pcs]").val();
      var tgl = $("input[name=tgl]").val();

      var xx = $("input[name=xx]").val();
      var xxx = $("input[name=xxx]").val();
      var xxxx = $("input[name=xxxx]").val();
      var xxxxx = $("input[name=xxxxx]").val();
      var cycle = $("input[name=aaa]").val();
      var plan = $("select[name=plan]").val();
      var status = $("select[name=status]").val();
      var triger = $("button[name=triger]").val();

      console.log(cycle);
      console.log(xx);
      console.log(xxx);
      console.log(xxxx);
      console.log(xxxxx);
      console.log(tgl);
      console.log(status);
      console.log(plan);
      console.log(triger);
      $.ajax({
        url: "ajx/edit-proses-delivery-tmmin.php",
        method: "POST",
        dataType: "json",
        data: {
          xx: xx,
          xxx: xxx,
          xxxx: xxxx,
          xxxxx: xxxxx,
          cycle: cycle,
          tgl: tgl,
          plan: plan,
          status: status,
          triger: triger
        },

        success: function(data) {
          console.log(data);
        }

      });
      $("#modal-message").show(500);
      setTimeout(location.reload.bind(location), 2000);
      /* $.ajax({
            url: "edit-proses-master.php",
            method: "POST",
            data: {InvId:InvId},
            dataType: "html",
            success: function(data){
              $('.master-body').html(data);
            }
          });*/

    });
  </script>
</div>