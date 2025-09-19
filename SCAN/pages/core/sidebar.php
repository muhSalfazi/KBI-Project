<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav">
            <li>
                <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-database fa-fw"></i> Master<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <!-- <li>
                        <a href="masterpart.php"><i class="fa fa-users fa-fw"></i> Data Master Part</a>-->
            </li>
            <li>
                <a href="masterkanban.php"><i class="fa fa-users fa-fw"></i> Data Master Kanban</a>
            </li>
            <li>
                <a href="masterxxx.php"><i class="fa fa-th fa-fw""></i> Datas Master XXX</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href=" #"><i class="fa fa-sitemap fa-fw"></i> Warehouse Transaction<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <!-- AKSES MKT -->
                    <?php if ($_SESSION['id_role'] == 6 || $_SESSION['id_role'] == 1) { ?>
                        <li>
                            <a href="RFQForm.php"><i class="fa fa-file fa-fw"></i> Receiving</a>
                        </li>
                    <?php } ?>
                    <!-- END AKSES MKT -->

                    <!-- AKSES DE -->
                    <?php if ($_SESSION['id_role'] == 2 || $_SESSION['id_role'] == 1) { ?>
                        <li>
                            <a href="PreliminaryBillOfMaterial.php"><i class="fa fa-file fa-fw"></i> Moving</a>
                        </li>
                    <?php } ?>
                    <!-- END AKSES DE -->

                    <!-- AKSES NPD -->
                    <?php if ($_SESSION['id_role'] == 5 || $_SESSION['id_role'] == 1) { ?>
                        <li>
                            <a href="delivery.php"><i class="fa fa-file fa-fw"></i> Delivery</a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['id_role'] == 5 || $_SESSION['id_role'] == 1) { ?>
                        <li>
                            <a href="delivery_mmki.php"><i class="fa fa-file fa-fw"></i> Input Manifest</a>
                        </li>
                    <?php } ?>
                    <!-- END AKSES NPD -->
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-archive fa-fw"></i> Data Customer Order<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="purchaseorder.php"><i class="fa fa-book fa-fw"></i> Purchase Order</a>
                    </li>
                    <li>
                        <a href="deliveryorder.php"><i class="fa fa-book fa-fw"></i> Delivery Order</a>
                    </li>

                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="User.php"><i class="fa fa-user fa-fw""></i> User</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->