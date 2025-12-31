<?php
$logoColor = $companySettings['logo_color'] ?? 'assets/images/logo.png';
$logoBlack = $companySettings['logo_black'] ?? 'assets/images/logo-black.png';
$logoSmallColor = $companySettings['logo_color'] ?? 'assets/images/logo-sm.png';
$logoSmallBlack = $companySettings['logo_black'] ?? 'assets/images/logo-sm.png';
?>

<div class="sidenav-menu">
    <a href="index.php" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="<?php echo e($logoColor); ?>" alt="logo"></span>
            <span class="logo-sm"><img src="<?php echo e($logoSmallColor); ?>" alt="small logo"></span>
        </span>
        <span class="logo logo-dark">
            <span class="logo-lg"><img src="<?php echo e($logoBlack); ?>" alt="dark logo"></span>
            <span class="logo-sm"><img src="<?php echo e($logoSmallBlack); ?>" alt="small logo"></span>
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
        $hasCompany = !empty($currentCompany['id']);
        $hasPermission = static function (string $key) use ($permissions, $isAdmin): bool {
            if ($isAdmin) {
                return true;
            }
            if (in_array($key, $permissions ?? [], true)) {
                return true;
            }
            $legacyKey = permission_legacy_key_for($key);
            return $legacyKey ? in_array($legacyKey, $permissions ?? [], true) : false;
        };
        $canAccessAny = static function (array $keys) use ($hasPermission): bool {
            foreach ($keys as $key) {
                if ($hasPermission($key)) {
                    return true;
                }
            }
            return false;
        };
        ?>
        <ul class="side-nav">
            <li class="side-nav-title mt-2">Menú</li>
            <?php if ($hasCompany && $hasPermission('dashboard_view')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=dashboard" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="circle-gauge"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('crm_view')): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="handshake"></i></span>
                        <span class="menu-text">CRM Comercial</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrm">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="index.php?route=crm/hub" class="side-nav-link">
                                    <span class="menu-text">Panel CRM</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="index.php?route=crm/reports" class="side-nav-link">
                                    <span class="menu-text">Reportes &amp; Insights</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-briefs.php" class="side-nav-link">
                                    <span class="menu-text">Briefs Comerciales</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-orders.php" class="side-nav-link">
                                    <span class="menu-text">Órdenes de Venta</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-renewals.php" class="side-nav-link">
                                    <span class="menu-text">Renovaciones</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('crm_view')): ?>
                <li class="side-nav-title">Flujo CRM</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarCrmProspeccion" aria-expanded="false" aria-controls="sidebarCrmProspeccion" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="radar"></i></span>
                        <span class="menu-text">Prospección</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrmProspeccion">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="crm-leads.php" class="side-nav-link">
                                    <span class="menu-text">Leads</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-briefs.php" class="side-nav-link">
                                    <span class="menu-text">Briefs Comerciales</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-campaign.php" class="side-nav-link">
                                    <span class="menu-text">Campaign</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-contacts.php" class="side-nav-link">
                                    <span class="menu-text">Contacts</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarCrmVentas" aria-expanded="false" aria-controls="sidebarCrmVentas" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="shopping-cart"></i></span>
                        <span class="menu-text">Ventas</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrmVentas">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="crm-opportunities.php" class="side-nav-link">
                                    <span class="menu-text">Opportunities</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-deals.php" class="side-nav-link">
                                    <span class="menu-text">Deals</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-pipeline.php" class="side-nav-link">
                                    <span class="menu-text">Pipeline</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-proposals.php" class="side-nav-link">
                                    <span class="menu-text">Proposals</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-estimations.php" class="side-nav-link">
                                    <span class="menu-text">Estimations</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-orders.php" class="side-nav-link">
                                    <span class="menu-text">Órdenes de Venta</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarCrmPostventa" aria-expanded="false" aria-controls="sidebarCrmPostventa" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="handshake"></i></span>
                        <span class="menu-text">Postventa</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrmPostventa">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="crm-customers.php" class="side-nav-link">
                                    <span class="menu-text">Customers</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-activities.php" class="side-nav-link">
                                    <span class="menu-text">Activities</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="tickets-list.php" class="side-nav-link">
                                    <span class="menu-text">Service Desk</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-renewals.php" class="side-nav-link">
                                    <span class="menu-text">Renovaciones</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="crm-reports.php" class="side-nav-link">
                                    <span class="menu-text">Reports &amp; Insights</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('clients_view')): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarClients" aria-expanded="false" aria-controls="sidebarClients" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="users"></i></span>
                        <span class="menu-text">Clientes</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarClients">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="index.php?route=clients" class="side-nav-link">
                                    <span class="menu-text">Listado</span>
                                </a>
                            </li>
                            <?php if ($hasPermission('tickets_view')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=tickets" class="side-nav-link">
                                        <span class="menu-text">Tickets</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('projects_view')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=projects" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="folder"></i></span>
                        <span class="menu-text">Proyectos</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $canAccessAny(['services_view', 'services_edit', 'system_services_view', 'system_services_edit', 'service_types_view', 'service_types_edit'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarServices" aria-expanded="false" aria-controls="sidebarServices" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="server"></i></span>
                        <span class="menu-text">Servicios</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarServices">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="index.php?route=services" class="side-nav-link">
                                    <span class="menu-text">Listado servicios</span>
                                </a>
                            </li>
                            <?php if ($hasPermission('services_edit')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=services/create" class="side-nav-link">
                                        <span class="menu-text">Asignar servicio a cliente</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasPermission('system_services_edit')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=maintainers/services/create" class="side-nav-link">
                                        <span class="menu-text">Crear servicio</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasPermission('service_types_edit')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=maintainers/service-types/create" class="side-nav-link">
                                        <span class="menu-text">Crear tipo de servicio</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('quotes_view')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=quotes" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                        <span class="menu-text">Cotizaciones</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('invoices_view')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=invoices" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="file-text"></i></span>
                        <span class="menu-text">Facturas</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('payments_view')): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarPayments" aria-expanded="false" aria-controls="sidebarPayments" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="credit-card"></i></span>
                        <span class="menu-text">Pagos</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPayments">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="index.php?route=payments/buttons" class="side-nav-link">
                                    <span class="menu-text">Botones de pago</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="index.php?route=payments/paid" class="side-nav-link">
                                    <span class="menu-text">Pagos realizados</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="index.php?route=payments/pending" class="side-nav-link">
                                    <span class="menu-text">Pagos pendientes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('email_templates_view')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=email-templates" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="mail"></i></span>
                        <span class="menu-text">Plantillas Email</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($hasCompany && $hasPermission('email_queue_view')): ?>
                <li class="side-nav-item">
                    <a href="index.php?route=email-queue" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="send"></i></span>
                        <span class="menu-text">Cola de Correos</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($canAccessAny(['users_view', 'roles_view', 'users_companies_view', 'users_permissions_view', 'companies_view', 'settings_view', 'email_config_view', 'online_payments_config_view', 'system_services_view', 'service_types_view'])): ?>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarMaintainers" aria-expanded="false" aria-controls="sidebarMaintainers" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="database"></i></span>
                        <span class="menu-text">Mantenedores</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMaintainers">
                        <ul class="sub-menu">
                            <?php if ($canAccessAny(['users_view', 'users_edit', 'roles_view', 'users_companies_view', 'users_permissions_view'])): ?>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarMaintainersUsers" aria-expanded="false" aria-controls="sidebarMaintainersUsers" class="side-nav-link">
                                        <span class="menu-text">Usuarios</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarMaintainersUsers">
                                        <ul class="sub-menu">
                                            <?php if ($hasPermission('users_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=users" class="side-nav-link">
                                                        <span class="menu-text">Listado usuarios</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($hasPermission('users_permissions_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=users/permissions" class="side-nav-link">
                                                        <span class="menu-text">Roles y permisos</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($hasPermission('roles_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=roles" class="side-nav-link">
                                                        <span class="menu-text">Roles</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($hasPermission('users_companies_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=users/assign-company" class="side-nav-link">
                                                        <span class="menu-text">Asignar empresa</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasPermission('companies_view')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=companies" class="side-nav-link">
                                        <span class="menu-text">Empresas</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasCompany && $hasPermission('settings_view')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=settings" class="side-nav-link">
                                        <span class="menu-text">Configuraciones</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasCompany && $hasPermission('email_config_view')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=maintainers/email-config" class="side-nav-link">
                                        <span class="menu-text">Configuración de correo</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasCompany && $hasPermission('online_payments_config_view')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=maintainers/online-payments" class="side-nav-link">
                                        <span class="menu-text">Pagos en línea</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
