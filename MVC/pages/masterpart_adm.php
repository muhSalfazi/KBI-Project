<?php
session_start();
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__) . $ds . '..') . $ds;
include_once("../connection.php");
require_once("{$base_dir}pages{$ds}validate{$ds}AuthUser.php");
require_once("{$base_dir}pages{$ds}core{$ds}header.php");
require_once("{$base_dir}pages{$ds}core{$ds}sidebar.php");

if (!isset($_SESSION["id_user"])) {
    die("Akses ditolak, silakan login terlebih dahulu.");
}
$IdUser = $_SESSION["id_user"];
?>

<script src="../sweetalert/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="../sweetalert/css/sweetalert.css">

<?php
if (isset($_SESSION['alert']) && $_SESSION['alert'] == '1') {
    unset($_SESSION['alert']);
    echo "<script type='text/javascript'>
        $(document).ready(function() {
            var audio = new Audio('audio/3.mp3');
            audio.play();
            swal({ 
                title: 'Data Sudah Ada',
                type: 'error',
                showCancelButton: false,
                showConfirmButton: true 
            });
        });
    </script>";
}
?>

<script type="text/javascript">
    $(document).ready(function() {

        $('.delete-link').on('click', function() {
            var getLink = $(this).attr('href');
            swal({
                title: "Apakah Yakin Menghapus?",
                text: "Jika dihapus data ini tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function() {
                window.location.href = getLink;
            });
            return false;
        });

        $('.tambah_master').click(function() {
            var id_pendaftar = $(this).attr('data-id');
            $.ajax({
                url: "ajx/tambah-master-adm.php",
                method: "POST",
                data: { id_pendaftar: id_pendaftar },
                dataType: "html",
                success: function(data) {
                    $('.master-body').html(data);
                }
            });
        });

        $('.edit_master').click(function() {
            var id_pendaftar = $(this).attr('data-id');
            $.ajax({
                url: "ajx/edit-master-adm.php",
                method: "POST",
                data: { id_pendaftar: id_pendaftar },
                dataType: "html",
                success: function(data) {
                    $('.master-body').html(data);
                }
            });
        });

        $('.delete_master').click(function() {
            var id_pendaftar = $(this).attr('data-id');
            $.ajax({
                url: "ajx/delete-master-adm.php",
                method: "POST",
                data: { id_pendaftar: id_pendaftar },
                dataType: "html",
                success: function(data) {
                    $('.master-body').html(data);
                }
            });
        });

    });
</script>

<!-- Content -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-building fa-fw"></i> Data Kanban ADM</h1>
    </div>
</div>

<br><br>

<div class="row">
    <div class="col-lg-12">
        <a class='tambah_master btn btn-sm btn-primary' data-toggle="modal" data-target="#myModal" data-id=""><i class='fa fa-plus'></i>&ensp;Add Data Kanban</a>
        <a href="import_partsadm.php" class='btn btn-primary btn-sm'><i class='fa fa-download'></i>&ensp;Import Data Kanban</a>
        <br><br>

        <div class="panel panel-default">
            <div class="panel-heading">
                List All Data Part
            </div>

            <div class="panel-body">
                <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:40px;">NO</th>
                            <th class="text-center" style="width:100px;">Inventory ID</th>
                            <th class="text-center" style="width:100px;">Part Name</th>
                            <th class="text-center" style="width:100px;">Part No.</th>
                            <th class="text-center" style="width:100px;">Job No.</th>
                            <th class="text-center" style="width:100px;">Qty Per Kanban</th>
                            <th class="text-center" style="width:100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $No = 0;
                        $QueryListMaterials = mysqli_query($mysqli, "SELECT * FROM masterpart_adm ORDER BY id DESC");
                        while ($ResultQueryListMaterials = mysqli_fetch_array($QueryListMaterials)) {
                            $No++;
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No; ?></td>
                                <td class="text-center"><?php echo $ResultQueryListMaterials['InvId']; ?></td>
                                <td class="text-center"><?php echo $ResultQueryListMaterials['PartName']; ?></td>
                                <td class="text-center"><?php echo $ResultQueryListMaterials['PartNo']; ?></td>
                                <td class="text-center"><?php echo $ResultQueryListMaterials['JobNo']; ?></td>
                                <td class="text-center"><?php echo $ResultQueryListMaterials['QtyPerKbn']; ?></td>
                                <td class="text-center">
                                    <a class='edit_master btn btn-primary btn-xs' style='width:65px;' data-toggle="modal" data-target="#myModal" data-id="<?php echo $ResultQueryListMaterials['InvId']; ?>"><i class='fa fa-edit' data-target="#modal-default"></i> Edit</a>
                                    <a class="delete_master btn btn-danger btn-xs" style="width:65px;" data-toggle="modal" data-target="#myModal" data-id="<?php echo $ResultQueryListMaterials['InvId']; ?>"><i class="fa fa-trash" data-target="#modal-default"></i> Delete</a>

                                    <form action="Printkanban.php" method="post" style="display:inline;">
                                        <input type="hidden" name="userdata" value="<?php echo $ResultQueryListMaterials['InvId'] . $ResultQueryListMaterials['JobNo']; ?>">
                                        <input type="hidden" name="level" value="M">
                                        <input type="hidden" name="size" value="4">
                                        <input type="hidden" name="jobno" value="<?php echo $ResultQueryListMaterials['JobNo']; ?>">
                                        <input type="hidden" name="modelno" value="<?php echo $ResultQueryListMaterials['ModelNo']; ?>">
                                        <input type="hidden" name="invid" value="<?php echo $ResultQueryListMaterials['InvId']; ?>">
                                        <input type="hidden" name="partname" value="<?php echo $ResultQueryListMaterials['PartName']; ?>">
                                        <input type="hidden" name="qtyperkbn" value="<?php echo $ResultQueryListMaterials['QtyPerKbn']; ?>">
                                        <input type="hidden" name="partno" value="<?php echo $ResultQueryListMaterials['PartNo']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="master-body2"></div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Master Kanban</h4>
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

<?php
require_once("{$base_dir}pages{$ds}core{$ds}footer.php");
?>
