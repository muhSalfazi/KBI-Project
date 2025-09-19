</div>
        <!-- /#page-wrapper -->

        <br>
        <footer class="main-footer">
            <div class="text-center">
                <strong>Delivery SYSTEM <a href="http://kyoraku.id/" target="_blank">KBI-<span id="year"></span></a></strong>
            </div>
        </footer>


    </div>
        <script>
            document.getElementById("year").textContent = new Date().getFullYear();
        </script>
    <!-- /#wrapper -->

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.js"></script> 
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <!-- Datepicker -->
    <script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Datetimepicker -->
    <script src="../vendor/datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

    <script>
        $(function() {
            $('#side-menu').metisMenu();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#side-menu').metisMenu({
                toggle: true,
                doubleTapToGo: true
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#side-menu li > a').on('click', function (e) {
                const $submenu = $(this).next('.nav-second-level');
                if ($submenu.length) {
                    e.preventDefault(); // cegah link default
                    $submenu.slideToggle(200); // animasi buka/tutup submenu
                    $(this).find('.fa.arrow').toggleClass('open'); // opsional: rotate arrow
                    $(this).parent().toggleClass('active');
                }
            });
        });
    </script>

    <script src="../chart/chart-dashboard.js"></script>
    
    </script>        
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
