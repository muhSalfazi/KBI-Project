<?php
// File: view_dashboard_hpm.php

?>

<div class="table-responsive">
  <table width="100%" class="table table-striped table-bordered table-hover" id="example1">
    <thead>
      <tr>
        <th class="text-center">No.</th>
        <th class="text-center">Delivery Date</th>
        <th class="text-center">Delivery Manifest No.</th>
        <th class="text-center">Job No.</th>
        <th class="text-center">Customer Part No.</th>
        <th class="text-center">Qty Box</th>
        <th class="text-center">Acuan Scan</th>
        <th class="text-center">Total Qty Pcs</th>
        <th class="text-center">Proses Scan</th>
        <th class="text-center">Plant</th>
        <th class="text-center">Dlv.Time (ETA)</th>
        <th class="text-center">Cycle</th>
        <th class="text-center">Status</th>
        <th class="text-center">Date Input</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delivery HPM</h4>
      </div>
      <div class="modal-body">
        <p class="master-body"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
  var table = $('#example1').DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: 'ajx/api_dashboard_hpm.php', // Menggunakan API baru
      type: 'POST',
      data: function (d) {
        d.status = $('#statusFilter').val() || 'Open';
        // Tidak perlu kirim tanggal_order karena sudah difilter di server
      }
    },
    order: [[0, 'asc']]
  });

  // Tombol tambah
  $(document).on('click', '.tambah_delivery', function () {
    $.ajax({
      url: 'ajx/tambah-delivery-hpm.php',
      method: 'GET',
      dataType: 'html',
      success: function (data) {
        $('.master-body').html(data);
      },
      error: function (xhr, status, error) {
        $('.master-body').html('<p class="text-danger">Gagal memuat form: ' + error + '</p>');
      }
    });
  });

  // Tombol edit
  $('#example1 tbody').on('click', '.edit_delivery', function () {
    var id_pendaftar = $(this).data('id');
    $.ajax({
      url: "ajx/edit-delivery-hpm.php",
      method: "POST",
      data: { id_pendaftar: id_pendaftar },
      dataType: "html",
      success: function (data) {
        $('.master-body').html(data);
      }
    });
  });

  // Tombol delete
  $('#example1 tbody').on('click', '.delete_delivery', function () {
    var id_pendaftar = $(this).attr('data-id');
    $.ajax({
      url: "ajx/delete-deliveryhpm.php",
      method: "POST",
      data: { id_pendaftar: id_pendaftar },
      dataType: "html",
      success: function (data) {
        $('.master-body').html(data);
      }
    });
  });

  // Filter status
  $('#statusFilter').change(function () {
    table.ajax.reload();
  });
});
</script>
