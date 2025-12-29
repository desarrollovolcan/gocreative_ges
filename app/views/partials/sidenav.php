<div class="sidenav-menu">
    <a href="index.php" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="assets/images/logo.png" alt="logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
        <span class="logo logo-dark">
            <span class="logo-lg"><img src="assets/images/logo-black.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
    </a>
    <button class="button-on-hover">
        <i class="ti ti-menu-4 fs-22 align-middle"></i>
    </button>
    <button class="button-close-offcanvas">
        <i class="ti ti-x align-middle"></i>
    </button>
    <div class="scrollbar" data-simplebar>
        <div class="sidenav-user">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="sidenav-user-name fw-bold"><?php echo e($currentUser['name'] ?? 'Usuario'); ?></span>
                    <span class="fs-12 fw-semibold"><?php echo e($currentUser['role'] ?? ''); ?></span>
                </div>
            </div>
        </div>
        <?php
        $isAdmin = ($currentUser['role'] ?? '') === 'admin';
        $canAccess = static function (string $key) use ($permissions, $isAdmin): bool {
            return $isAdmin || in_array($key, $permissions ?? [], true);
        };
        ?>
        <ul class="side-nav">
            <li class="side-nav-title mt-2">Menú</li>
            <?php if ($canAccess('dashboard')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=dashboard" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="circle-gauge"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('clients')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=clients" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="users"></i></span>
                        <span class="menu-text">Clientes</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('projects')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=projects" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="folder"></i></span>
                        <span class="menu-text">Proyectos</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('services')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=services" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="server"></i></span>
                        <span class="menu-text">Servicios</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('invoices')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=invoices" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="file-text"></i></span>
                        <span class="menu-text">Facturas</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('email_templates')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=email-templates" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="mail"></i></span>
                        <span class="menu-text">Plantillas Email</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('email_queue')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=email-queue" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="send"></i></span>
                        <span class="menu-text">Cola de Correos</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('settings')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=settings" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="settings"></i></span>
                        <span class="menu-text">Configuración</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('users')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=users" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="user"></i></span>
                        <span class="menu-text">Usuarios</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccess('users_permissions')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=users/permissions" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="shield-check"></i></span>
                        <span class="menu-text">Permisos usuarios</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
