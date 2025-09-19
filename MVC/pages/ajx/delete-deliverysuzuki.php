<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php $part = $_POST['id_pendaftar'];
include_once("../../connection.php"); ?>
<div class="panel-body"><?php //echo $part;
                        ?> <center>
    <h4>Apakah Akan Menghapus Data Ini ??</h4>
  </center>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <div class="container">


      <?php

      $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM tbl_deliverysuzuki WHERE id='$part'");
      $ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)

      ?>

      <tr>
        <td>Manifet No.</td>
        <td> :
        <td><input name="xx" value="<?php echo $ResultQueryListMaterials['dn_no']; ?>" hidden><?php echo $ResultQueryListMaterials['dn_no']; ?></td>
      </tr>
      <tr>
        <td>Job No.</td>
        <td> :
        <td><?php echo $ResultQueryListMaterials['job_no']; ?></td>
      </tr>

      <tr>
        <td colspan="3" class="text-center"><button name="triger" value="<?php echo $ResultQueryListMaterials['id']; ?>" class="btn btn-sm btn-danger" id="simpan-data">Hapus</button></td>
      </tr>
      <tr>
        <td colspan="3">
          <div style="display:none;" class="tutup alert alert-danger " id='modal-message'>Data Telah Di Hapus</div>
        </td>
      </tr>
  </table>
  <script type="text/javascript">
    $('#simpan-data').click(function() {

      //Biaya 
      var dn_no = $("input[name=dn_no]").val();
      var job_no = $("input[name=job_no]").val();
      var customerpart_no = $("input[name=customerpart_no]").val();
      var qty_pcs = $("input[name=qty_pcs]").val();
      var status = $("input[name=status]").val();
      var xx = $("input[name=xx]").val();
      var xxx = $("input[name=xxx]").val();
      var xxxx = $("input[name=xxxx]").val();
      var xxxxx = $("input[name=xxxxx]").val();
      var triger = $("button[name=triger]").val();


      console.log(xx);
      console.log(xxx);
      console.log(xxxx);
      console.log(xxxxx);
      console.log(status);
      console.log(triger);
      $.ajax({
        url: "ajx/delete-proses-deliverysuzuki.php",
        method: "POST",
        dataType: "json",
        data: {
          xx: xx,
          xxx: xxx,
          xxxx: xxxx,
          xxxxx: xxxxx,
          status: status,
          triger: triger
        },

        success: function(data) {
          /*$('.tampildata').load("crud2/view_delivery.php");	*/
          console.log(data);
        }

      });
      $("#modal-message").show(500);
      setTimeout(location.reload.bind(location), 1200);
      $.ajax({
        url: "delivery_suzuki.php",
        method: "POST",
        data: {
          InvId: InvId
        },
        dataType: "html",
        success: function(data) {
          $('.tampildata').html(data);
        }
      });

    });
  </script>
</div>