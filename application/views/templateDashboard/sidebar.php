<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-road"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Monitoring Jalan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>




    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-map-marked"></i>
            <span>Maps</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis-jenis Maps</h6>
                <a class="collapse-item" href="<?= base_url("Maps"); ?>">Maps Dashboard</a>
                <a class="collapse-item" href="<?= base_url("Maps/petadigital"); ?>">Full Maps Tampil Data</a>
                <?php
                if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true) {
                ?>
                    <a class="collapse-item" href="<?= base_url("Maps/verifikasijalan/") . $_SESSION['token']; ?>">Full Maps Edit Verifikasi</a>
                <?php } ?>

            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">






    <!-- Nav Item -->
    <?php
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true) {
    ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url("Auth/logout"); ?>">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    <?php
    } else {
    ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url("Auth/"); ?>">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login Untuk Admin</span>
            </a>
        </li>
    <?php
    }; ?>


    <!-- CADANGAN -->
    <!-- Nav Item - Utilities Collapse Menu -->






    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->