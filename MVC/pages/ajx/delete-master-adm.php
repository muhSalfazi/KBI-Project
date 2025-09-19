<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php $part = $_POST["id_pendaftar"];
include_once("../../connection.php"); ?>
<div class="panel-body">
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <div class="container">


      <?php

      $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM masterpart_adm WHERE InvId='$part'");
      $ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)

      ?>


      <tr>
        <td>Inventory ID</td>
        <td> :</td>
        <td><input name="InvId" value="<?php echo $ResultQueryListMaterials['InvId']; ?>" hidden><?php echo $ResultQueryListMaterials['InvId']; ?></td>
      </tr>
      <tr>
        <td>Part Name</td>
        <td> :
        <td><?php echo $ResultQueryListMaterials['PartName']; ?></td>
      </tr>

      <tr>
        <td colspan="3" class="text-center"><button name="triger" value="<?php echo $ResultQueryListMaterials['InvId']; ?>" class="btn btn-sm btn-danger" id="simpan-data">Hapus</button></td>
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
      var InvId = $("input[name=InvId]").val();
      var PartName = $("input[name=PartName]").val();
      var PartNo = $("input[name=PartNo]").val();
      var JobNo = $("input[name=JobNo]").val();
      var QtyPerKbn = $("input[name=QtyPerKbn]").val();

      var triger = $("button[name=triger]").val();
      console.log(InvId);
      console.log(PartName);
      console.log(PartNo);
      console.log(JobNo);
      console.log(QtyPerKbn);
      console.log(triger);
      $.ajax({
        url: "ajx/delete-proses-master-adm.php",
        method: "POST",
        dataType: "json",
        data: {
          InvId: InvId,
          PartName: PartName,
          PartNo: PartNo,
          JobNo: JobNo,
          QtyPerKbn: QtyPerKbn,
          triger: triger
        },

        success: function(data) {
          console.log(data);
        }

      });
      $("#modal-message").show(500);
      setTimeout(location.reload.bind(location), 1200);
      /* $.ajax({
            url: "edit-proses-master.php",
            method: "POST",
            data: {InvId:InvId},
            dataType: "html",
            success: function(data){
              $('.master-body2').html(data);
            }
          });*/

    });
  </script>
</div>