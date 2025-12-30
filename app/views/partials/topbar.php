<?php
$logoColor = $companySettings['logo_color'] ?? 'assets/images/logo.png';
$logoBlack = $companySettings['logo_black'] ?? 'assets/images/logo-black.png';
$logoSmallColor = $companySettings['logo_color'] ?? 'assets/images/logo-sm.png';
$logoSmallBlack = $companySettings['logo_black'] ?? 'assets/images/logo-sm.png';
?>

<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-topbar">
                <a href="index.php" class="logo-light">
                    <span class="logo-lg">
                        <img src="<?php echo e($logoColor); ?>" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="<?php echo e($logoSmallColor); ?>" alt="small logo">
                    </span>
                </a>
                <a href="index.php" class="logo-dark">
                    <span class="logo-lg">
                        <img src="<?php echo e($logoBlack); ?>" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="<?php echo e($logoSmallBlack); ?>" alt="small logo">
                    </span>
                </a>
            </div>
            <button class="sidenav-toggle-button btn btn-default btn-icon">
                <i class="ti ti-menu-4 fs-22"></i>
            </button>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="app-search d-none d-xl-flex me-2">
                <form method="get" action="index.php" class="position-relative">
                    <input type="hidden" name="route" value="search">
                    <input type="search" class="form-control topbar-search rounded-pill" name="q" placeholder="Buscar...">
                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                </form>
            </div>

            <div class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                        <i data-lucide="bell" class="fs-xxl"></i>
                        <span class="badge text-bg-danger badge-circle topbar-badge"><?php echo $notificationCount; ?></span>
                    </button>
                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                        <div class="px-3 py-2 border-bottom">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-md fw-semibold">Notificaciones</h6>
                                </div>
                                <div class="col text-end">
                                    <a href="index.php?route=notifications" class="badge badge-soft-success badge-label py-1">Ver todas</a>
                                </div>
                            </div>
                        </div>
                        <div style="max-height: 300px;" data-simplebar>
                            <?php foreach ($notifications as $notification): ?>
                                <div class="dropdown-item notification-item py-2 text-wrap">
                                    <span class="d-flex align-items-center gap-3">
                                        <span class="flex-grow-1 text-muted">
                                            <span class="fw-medium text-body"><?php echo e($notification['title']); ?></span><br>
                                            <span class="fs-xs"><?php echo e($notification['message']); ?></span>
                                        </span>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link fw-bold" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-user-circle fs-22"></i>
                        <span class="ms-1"><?php echo e($currentUser['name'] ?? ''); ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="index.php?route=users" class="dropdown-item">Usuarios</a>
                        <div class="dropdown-divider"></div>
                        <a href="index.php?route=logout" class="dropdown-item">Salir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
