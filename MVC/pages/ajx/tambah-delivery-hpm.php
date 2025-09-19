<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php error_reporting(0); ?>
<?php
session_start(); // Memulai sesi
$part = $_POST['id_pendaftar'];
include_once("../../connection.php");
$IdUser = $_SESSION['id_user'];
?>
<div class="panel-body">
  <?php
  // Ambil data dari tabel tbl_deliveryhpm berdasarkan dn_no
  $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM tbl_deliveryhpm WHERE dn_no='$part'");
  $ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials);
  ?>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <div class="container">
      <!-- Input fields untuk form -->
      <tr>
        <td>Manifest No.</td>
        <td> : </td>
        <td><input name="xx" required></td>
      </tr>
      <tr>
        <td>Job No.</td>
        <td> : </td>
        <td><input name="xxx"></td>
      </tr>
      <tr>
        <td>Customer Part No.</td>
        <td> : </td>
        <td><input name="xxxx"></td>
      </tr>
      <tr>
        <td>Qty Pcs.</td>
        <td> : </td>
        <td><input name="xxxxx"></td>
      </tr>
      <tr>
        <td>Delivery Date</td>
        <td> : </td>
        <td><input type="date" name="status"></td>
      </tr>
      <tr>
        <td>Plant</td>
        <td> : </td>
        <td>
          <select name="plan">
            <option value="KBI-1">KBI-1</option>
            <option value="KBI-2">KBI-2</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Cycle</td>
        <td> : </td>
        <td><input type="text" name="cycle"></td>
      </tr>
      <tr>
        <td colspan="3" class="text-center">
          <button name="triger" class="btn btn-sm btn-success" id="simpan-data">Simpan</button>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <div style="display:none;" class="tutup alert alert-success" id='modal-message'>Data Telah Diupdate</div>
        </td>
      </tr>
    </div>
  </table>

  <script type="text/javascript">
    $('#simpan-data').click(function() {
      // Ambil nilai dari input fields
      var status = $("input[name=status]").val();
      var user = "<?php echo $IdUser; ?>";
      var xx = $("input[name=xx]").val();
      var xxx = $("input[name=xxx]").val();
      var xxxx = $("input[name=xxxx]").val();
      var xxxxx = $("input[name=xxxxx]").val();
      var cycle = $("input[name=cycle]").val();
      var plan = $("select[name=plan]").val();
      var triger = $("button[name=triger]").val();

      // Validasi input fields
      if (xx == "") {
        showAlert("Delivery Note No", "tidak boleh kosong!");
        return false;
      } else if (xxx == "") {
        showAlert("Job No.", "tidak boleh kosong!");
        return false;
      } else if (xxxx == "") {
        showAlert("Customer Part No", "tidak boleh kosong!");
        return false;
      } else if (xxxxx == "") {
        showAlert("Qty Pcs", "tidak boleh kosong!");
        return false;
      } else if (status == "") {
        showAlert("Delivery Date", "tidak boleh kosong!");
        return false;
      } else if (cycle == "") {
        showAlert("Cycle", "tidak boleh kosong!");
        return false;
      }

      console.log(xx, user, xxx, xxxx, xxxxx, status, plan, triger);

      // Kirim data dengan AJAX
      $.ajax({
        url: "ajx/tambah-proses-delivery-hpm.php",
        method: "POST",
        dataType: "json",
        data: {
          xx: xx,
          user: user,
          xxx: xxx,
          xxxx: xxxx,
          xxxxx: xxxxx,
          plan: plan,
          cycle: cycle,
          status: status,
          triger: triger
        },
        success: function(data) {
          console.log(data);
          // window.location = ('delivery_hpm.php?page=ok');
        }
      });
      // Redirect ke halaman delivery_hpm.php
      $("#modal-message").show(500);
      window.location = ('delivery_hpm.php');
    });

    // Fungsi untuk menampilkan alert
    function showAlert(title, text) {
      $(document).ready(function() {
        var audio = new Audio('audio/3.mp3');
        audio.play();
        swal({
          title: title,
          text: text,
          type: 'error',
          timer: 1000,
          showCancelButton: false,
          showConfirmButton: true
        });
      });
    }
  </script>
</div>