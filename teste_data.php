<?php include 'inicial.php'?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-info navbar-dark">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="#">Brand</a>

        <!-- Icons -->
        <ul class="navbar-nav d-flex flex-row me-1">
            <li class="nav-item me-3 me-lg-0">
                <a class="nav-link text-white" href="#"><i class="fas fa-envelope-duotone mx-1"></i> Contact</a>
            </li>
            <li class="nav-item me-3 me-lg-0">
                <a class="nav-link text-white" href="#"><i class="fas fa-cog mx-1"></i> Settings</a>
            </li>
            <li class="nav-item dropdown">
                <a data-mdb-dropdown-init class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                data-mdb-toggle="dropdown" aria-expanded="false"> <i class="fas fa-user mx-1"></i> Profile </a>
                <!-- Dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="#">My account</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">Log out</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
