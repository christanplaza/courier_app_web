<?php
$activePage = $_SESSION['currentPage'];
?>

<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark shadow">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark min-vh-100">
        <a href="/courier_app_web/user/dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">Courier App</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/courier_app_web/user/dashboard.php" class="nav-link text-white <?php echo $activePage == 'dashboard' ? 'active' : ''; ?>" aria-current="page">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/courier_app_web/user/orders.php" class="nav-link text-white  <?php echo $activePage == 'orders' ? 'active' : ''; ?>">
                    Orders
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><?php echo $_COOKIE['name']; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="../user/logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>