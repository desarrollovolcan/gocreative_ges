<?php include('partials/html.php'); ?>

<head>
    <?php $title = $title ?? 'Portal Cliente'; include('partials/title-meta.php'); ?>
    <?php include('partials/head-css.php'); ?>
</head>

<?php
$companySettings = app_config('company', []);
$logoColor = $companySettings['logo_color'] ?? 'assets/images/logo.png';
$logoBlack = $companySettings['logo_black'] ?? $logoColor;
$upcomingTasks = array_values(array_filter($projectTasks ?? [], static fn(array $task): bool => empty($task['completed'])));
$projectsCount = count($projectsOverview ?? []);
$openTickets = count($supportTickets ?? []);
$pendingCount = count($pendingInvoices ?? []);
$paymentsCount = count($payments ?? []);
$activeSupportTicketId = (int)($activeSupportTicketId ?? 0);
$portalLogo = $logoBlack ?: login_logo_src($companySettings);
$nextInvoice = $pendingInvoices[0] ?? null;
$latestPayment = $payments[0] ?? null;
$nextTask = $upcomingTasks[0] ?? null;
?>

<body class="bg-light">
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">
                            <article class="card overflow-hidden mb-3 border-0 shadow-sm">
                                <div class="position-relative card-side-img overflow-hidden" style="min-height: 260px; background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);">
                                    <div class="p-4 p-md-5 card-img-overlay rounded-start-0 d-flex align-items-center flex-column justify-content-center text-center">
                                        <div class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                                            <img src="<?php echo e($portalLogo); ?>" alt="Logo" height="36">
                                        </div>
                                        <p class="text-muted mb-1 text-uppercase fs-xs">Portal cliente</p>
                                        <h3 class="fw-semibold mb-2"><?php echo e($client['name'] ?? 'Cliente'); ?></h3>
                                        <p class="text-muted mb-0">Seguimiento de proyectos, facturación y soporte en un panel claro.</p>
                                        <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                                            <a class="btn btn-outline-secondary btn-sm" href="#dashboard"><i class="ti ti-dashboard"></i> Dashboard</a>
                                            <a class="btn btn-outline-secondary btn-sm" href="#facturacion"><i class="ti ti-receipt"></i> Facturación</a>
                                            <a class="btn btn-outline-secondary btn-sm" href="#proyectos"><i class="ti ti-briefcase"></i> Proyectos</a>
                                            <a class="btn btn-primary btn-sm" href="index.php?route=clients/portalLogout"><i class="ti ti-logout"></i> Cerrar sesión</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo e($success); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-top-sticky border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="me-3 position-relative">
                                            <img src="<?php echo !empty($client['avatar_path']) ? e($client['avatar_path']) : 'assets/images/users/user-1.jpg'; ?>" alt="avatar" class="rounded-circle" width="72" height="72" style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <h5 class="mb-1 d-flex align-items-center">
                                                <span class="link-reset text-dark fw-semibold"><?php echo e($client['name'] ?? 'Cliente'); ?></span>
                                            </h5>
                                            <p class="text-muted mb-1"><?php echo e($client['email'] ?? ''); ?></p>
                                            <span class="badge text-bg-light">Cliente activo</span>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-primary-subtle text-primary">Facturas: <?php echo $pendingCount; ?></span>
                                        <span class="badge bg-success-subtle text-success">Pagos: <?php echo $paymentsCount; ?></span>
                                        <span class="badge bg-info-subtle text-info">Tickets: <?php echo $openTickets; ?></span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="avatar-sm text-bg-light d-flex align-items-center justify-content-center rounded-circle">
                                            <i class="ti ti-mail fs-xl"></i>
                                        </div>
                                        <p class="mb-0 fs-sm"><?php echo e($client['email'] ?? ''); ?></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="avatar-sm text-bg-light d-flex align-items-center justify-content-center rounded-circle">
                                            <i class="ti ti-phone fs-xl"></i>
                                        </div>
                                        <p class="mb-0 fs-sm"><?php echo e($client['phone'] ?? ''); ?></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="avatar-sm text-bg-light d-flex align-items-center justify-content-center rounded-circle">
                                            <i class="ti ti-user fs-xl"></i>
                                        </div>
                                        <p class="mb-0 fs-sm"><?php echo e($client['contact'] ?? ''); ?></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm text-bg-light d-flex align-items-center justify-content-center rounded-circle">
                                            <i class="ti ti-map-pin fs-xl"></i>
                                        </div>
                                        <p class="mb-0 fs-sm"><?php echo e($client['address'] ?? ''); ?></p>
                                    </div>

                                    <div class="d-flex justify-content-start gap-2 mt-4">
                                        <a href="#facturacion" class="btn btn-light btn-sm"><i class="ti ti-receipt"></i> Facturación</a>
                                        <a href="#soporte" class="btn btn-outline-primary btn-sm"><i class="ti ti-headset"></i> Soporte</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8" id="dashboard">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header card-tabs d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="card-title mb-0">Panel del cliente</h4>
                                    </div>
                                    <ul class="nav nav-tabs card-header-tabs nav-bordered">
                                        <li class="nav-item">
                                            <a href="#tab-resumen" data-bs-toggle="tab" class="nav-link active">
                                                <span class="fw-bold">Resumen</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tab-facturacion" data-bs-toggle="tab" class="nav-link">
                                                <span class="fw-bold">Facturación</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tab-proyectos" data-bs-toggle="tab" class="nav-link">
                                                <span class="fw-bold">Proyectos</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tab-soporte" data-bs-toggle="tab" class="nav-link">
                                                <span class="fw-bold">Soporte</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tab-cuenta" data-bs-toggle="tab" class="nav-link">
                                                <span class="fw-bold">Perfil</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-resumen">
                                            <div class="row g-3 mb-3">
                                                <div class="col-sm-6">
                                                    <div class="p-3 rounded-3 border h-100">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="text-muted fs-xs text-uppercase">Facturas pendientes</span>
                                                            <span class="badge bg-warning-subtle text-warning"><?php echo $pendingCount; ?></span>
                                                        </div>
                                                        <h4 class="fw-semibold mb-1"><?php echo e(format_currency((float)($pendingTotal ?? 0))); ?></h4>
                                                        <p class="text-muted fs-sm mb-0">
                                                            <?php if ($nextInvoice): ?>
                                                                Próxima: <?php echo e($nextInvoice['fecha_vencimiento'] ?? '-'); ?> · #<?php echo e($nextInvoice['numero'] ?? $nextInvoice['id'] ?? ''); ?>
                                                            <?php else: ?>
                                                                Estás al día, no tienes pendientes.
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="p-3 rounded-3 border h-100">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="text-muted fs-xs text-uppercase">Pagos registrados</span>
                                                            <span class="badge bg-success-subtle text-success"><?php echo $paymentsCount; ?></span>
                                                        </div>
                                                        <h4 class="fw-semibold mb-1"><?php echo e(format_currency((float)($paidTotal ?? 0))); ?></h4>
                                                        <p class="text-muted fs-sm mb-0">
                                                            <?php if ($latestPayment): ?>
                                                                Último pago: <?php echo e($latestPayment['fecha_pago'] ?? '-'); ?> · <?php echo e(format_currency((float)($latestPayment['monto'] ?? 0))); ?>
                                                            <?php else: ?>
                                                                Aún no registramos pagos.
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="p-3 rounded-3 border h-100">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="text-muted fs-xs text-uppercase">Proyectos activos</span>
                                                            <span class="badge bg-primary-subtle text-primary"><?php echo $projectsCount; ?></span>
                                                        </div>
                                                        <h4 class="fw-semibold mb-1"><?php echo count($projectTasks ?? []); ?> tareas</h4>
                                                        <p class="text-muted fs-sm mb-0">
                                                            <?php if ($nextTask): ?>
                                                                Próximo entregable: <?php echo e($nextTask['title'] ?? $nextTask['name'] ?? 'Tarea'); ?>
                                                            <?php else: ?>
                                                                Sin tareas pendientes por ahora.
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="p-3 rounded-3 border h-100">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="text-muted fs-xs text-uppercase">Soporte</span>
                                                            <span class="badge bg-info-subtle text-info"><?php echo $openTickets; ?></span>
                                                        </div>
                                                        <h4 class="fw-semibold mb-1"><?php echo $openTickets; ?> tickets</h4>
                                                        <p class="text-muted fs-sm mb-0">Gestiona tus solicitudes y mensajes con el equipo.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <h6 class="fw-semibold mb-2">Últimas actividades</h6>
                                                    <div class="list-group list-group-flush">
                                                        <?php if (!empty($activities)): ?>
                                                            <?php foreach (array_slice($activities, 0, 5) as $activity): ?>
                                                                <div class="list-group-item px-0">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <div class="fw-semibold"><?php echo e($activity['title'] ?? $activity['name'] ?? 'Actividad'); ?></div>
                                                                            <div class="text-muted fs-xs"><?php echo e($activity['project_name'] ?? 'Proyecto'); ?></div>
                                                                        </div>
                                                                        <span class="badge bg-light text-muted"><?php echo e($activity['created_at'] ?? ''); ?></span>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="text-muted">Aún no registramos actividad reciente.</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h6 class="fw-semibold mb-2">Próximas tareas</h6>
                                                    <div class="list-group list-group-flush">
                                                        <?php if (!empty($upcomingTasks)): ?>
                                                            <?php foreach (array_slice($upcomingTasks, 0, 5) as $task): ?>
                                                                <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <div class="fw-semibold"><?php echo e($task['title'] ?? $task['name'] ?? 'Tarea'); ?></div>
                                                                        <div class="text-muted fs-xs"><?php echo e($task['project_name'] ?? 'Proyecto'); ?></div>
                                                                    </div>
                                                                    <span class="badge bg-secondary-subtle text-secondary"><?php echo !empty($task['due_date']) ? e($task['due_date']) : 'Sin fecha'; ?></span>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="text-muted">No hay tareas activas.</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-facturacion">
                                            <div class="row g-3">
                                                <div class="col-lg-7" id="facturacion">
                                                    <h6 class="fw-semibold mb-2">Facturas pendientes</h6>
                                                    <div class="card border-0 shadow-sm h-100">
                                                        <div class="card-body">
                                                            <?php if (!empty($pendingInvoices)): ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-centered align-middle mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>Número</th>
                                                                                <th>Vencimiento</th>
                                                                                <th>Total</th>
                                                                                <th>Estado</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach (array_slice($pendingInvoices, 0, 6) as $invoice): ?>
                                                                                <tr>
                                                                                    <td class="fw-semibold">#<?php echo e($invoice['numero'] ?? $invoice['id']); ?></td>
                                                                                    <td><?php echo e($invoice['fecha_vencimiento'] ?? '-'); ?></td>
                                                                                    <td><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
                                                                                    <td><span class="badge bg-warning-subtle text-warning text-capitalize"><?php echo e($invoice['estado'] ?? 'pendiente'); ?></span></td>
                                                                                    <td class="text-end">
                                                                                        <a class="btn btn-outline-primary btn-sm" href="index.php?route=clients/portal/invoice&id=<?php echo (int)($invoice['id'] ?? 0); ?>&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>">Ver detalle</a>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted">No hay facturas pendientes. ¡Buen trabajo!</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5" id="pagos">
                                                    <h6 class="fw-semibold mb-2">Pagos recientes</h6>
                                                    <div class="card border-0 shadow-sm h-100">
                                                        <div class="card-body">
                                                            <?php if (!empty($payments)): ?>
                                                                <div class="list-group list-group-flush">
                                                                    <?php foreach (array_slice($payments, 0, 5) as $payment): ?>
                                                                        <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                                                            <div>
                                                                                <div class="fw-semibold">Pago <?php echo e($payment['invoice_number'] ?? '#'); ?></div>
                                                                                <div class="text-muted fs-xs"><?php echo e($payment['fecha_pago'] ?? '-'); ?></div>
                                                                            </div>
                                                                            <div class="text-end">
                                                                                <div class="fw-semibold"><?php echo e(format_currency((float)($payment['monto'] ?? 0))); ?></div>
                                                                                <span class="badge bg-success-subtle text-success text-capitalize"><?php echo e($payment['invoice_status'] ?? 'pagado'); ?></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted">Aún no registramos pagos.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-proyectos">
                                            <div class="row g-3" id="proyectos">
                                                <div class="col-lg-7">
                                                    <div class="card border-0 shadow-sm h-100">
                                                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <p class="text-muted mb-0 fs-xs text-uppercase">Proyectos</p>
                                                                <h5 class="mb-0">Avance y estado</h5>
                                                            </div>
                                                            <span class="badge bg-primary-subtle text-primary"><?php echo $projectsCount; ?> proyectos</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php if (!empty($projectsOverview)): ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-centered align-middle mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>Proyecto</th>
                                                                                <th>Progreso</th>
                                                                                <th>Última actividad</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($projectsOverview as $project): ?>
                                                                                <?php
                                                                                $tasksTotal = (int)($project['tasks_total'] ?? 0);
                                                                                $tasksCompleted = (int)($project['tasks_completed'] ?? 0);
                                                                                $progress = $tasksTotal > 0 ? (int)round(($tasksCompleted / max(1, $tasksTotal)) * 100) : 0;
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="fw-semibold"><?php echo e($project['name'] ?? 'Proyecto'); ?></div>
                                                                                        <div class="text-muted fs-xs text-capitalize"><?php echo e($project['status'] ?? 'en progreso'); ?></div>
                                                                                    </td>
                                                                                    <td style="width: 40%;">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                            <span class="fw-semibold fs-xs"><?php echo $progress; ?>%</span>
                                                                                        </div>
                                                                                        <div class="text-muted fs-xxs mt-1"><?php echo $tasksCompleted; ?> de <?php echo $tasksTotal; ?> tareas</div>
                                                                                    </td>
                                                                                    <td><span class="text-muted fs-sm"><?php echo e($project['last_activity'] ?? 'Sin actividad'); ?></span></td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted">Aún no hay proyectos registrados.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5" id="tareas">
                                                    <div class="card border-0 shadow-sm h-100">
                                                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <p class="text-muted mb-0 fs-xs text-uppercase">Tareas</p>
                                                                <h5 class="mb-0">Próximas entregas</h5>
                                                            </div>
                                                            <span class="badge bg-info-subtle text-info"><?php echo count($upcomingTasks); ?> abiertas</span>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php if (!empty($upcomingTasks)): ?>
                                                                <div class="list-group list-group-flush">
                                                                    <?php foreach (array_slice($upcomingTasks, 0, 6) as $task): ?>
                                                                        <div class="list-group-item px-0">
                                                                            <div class="d-flex align-items-center justify-content-between">
                                                                                <div>
                                                                                    <div class="fw-semibold"><?php echo e($task['title'] ?? $task['name'] ?? 'Tarea'); ?></div>
                                                                                    <div class="text-muted fs-xs"><?php echo e($task['project_name'] ?? 'Proyecto'); ?></div>
                                                                                </div>
                                                                                <span class="badge bg-secondary-subtle text-secondary"><?php echo !empty($task['due_date']) ? e($task['due_date']) : 'Sin fecha'; ?></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted">No hay tareas activas.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-soporte">
                                            <div class="row g-3" id="soporte">
                                                <div class="col-lg-5">
                                                    <div class="card border-0 shadow-sm h-100">
                                                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <p class="text-muted mb-0 fs-xs text-uppercase">Soporte</p>
                                                                <h5 class="mb-0">Nuevo ticket</h5>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php if (!empty($supportError)): ?>
                                                                <div class="alert alert-danger"><?php echo e($supportError); ?></div>
                                                            <?php endif; ?>
                                                            <?php if (!empty($supportSuccess)): ?>
                                                                <div class="alert alert-success"><?php echo e($supportSuccess); ?></div>
                                                            <?php endif; ?>
                                                            <form method="post" action="index.php?route=clients/portal/tickets/create&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>#soporte">
                                                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Asunto</label>
                                                                    <input type="text" name="subject" class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Prioridad</label>
                                                                    <select name="priority" class="form-select">
                                                                        <option value="baja">Baja</option>
                                                                        <option value="media" selected>Media</option>
                                                                        <option value="alta">Alta</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Detalle</label>
                                                                    <textarea name="message" class="form-control" rows="3" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary w-100">Crear ticket</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="card border-0 shadow-sm h-100">
                                                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <p class="text-muted mb-0 fs-xs text-uppercase">Seguimiento</p>
                                                                <h5 class="mb-0">Mis tickets</h5>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row g-3">
                                                                <div class="col-lg-5">
                                                                    <?php if (!empty($supportTickets)): ?>
                                                                        <div class="list-group list-group-flush">
                                                                            <?php foreach ($supportTickets as $ticket): ?>
                                                                                <?php $isActiveTicket = (int)$ticket['id'] === $activeSupportTicketId; ?>
                                                                                <a href="index.php?route=clients/portal&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>&ticket=<?php echo (int)$ticket['id']; ?>#soporte" class="list-group-item list-group-item-action <?php echo $isActiveTicket ? 'active' : ''; ?>">
                                                                                    <div class="fw-semibold">#<?php echo (int)$ticket['id']; ?> · <?php echo e($ticket['subject'] ?? 'Ticket'); ?></div>
                                                                                    <div class="fs-xxs <?php echo $isActiveTicket ? 'text-white-50' : 'text-muted'; ?>">Estado: <?php echo e(str_replace('_', ' ', $ticket['status'] ?? 'abierto')); ?></div>
                                                                                </a>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="text-muted">Aún no has generado tickets.</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                    <?php if (!empty($activeSupportTicket)): ?>
                                                                        <div class="border rounded-3 p-3 h-100 d-flex flex-column">
                                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                                <div>
                                                                                    <h6 class="fw-semibold mb-1">#<?php echo (int)$activeSupportTicket['id']; ?> · <?php echo e($activeSupportTicket['subject'] ?? ''); ?></h6>
                                                                                    <div class="text-muted fs-xxs text-uppercase">Estado: <?php echo e(str_replace('_', ' ', $activeSupportTicket['status'] ?? 'abierto')); ?></div>
                                                                                </div>
                                                                                <span class="badge bg-info-subtle text-info text-uppercase"><?php echo e($activeSupportTicket['priority'] ?? 'media'); ?></span>
                                                                            </div>
                                                                            <div class="flex-grow-1 overflow-auto mb-3" style="max-height: 320px;">
                                                                                <?php if (!empty($supportMessages)): ?>
                                                                                    <?php foreach ($supportMessages as $message): ?>
                                                                                        <?php $isClient = ($message['sender_type'] ?? '') === 'client'; ?>
                                                                                        <div class="d-flex mb-3 <?php echo $isClient ? 'justify-content-end' : 'justify-content-start'; ?>">
                                                                                            <div class="p-3 rounded-3 <?php echo $isClient ? 'bg-primary text-white' : 'bg-light'; ?>" style="max-width: 75%;">
                                                                                                <div class="fw-semibold mb-1"><?php echo e($message['sender_name'] ?? ($isClient ? 'Tú' : 'Soporte')); ?></div>
                                                                                                <div><?php echo nl2br(e($message['message'] ?? '')); ?></div>
                                                                                                <?php if (!empty($message['created_at'])): ?>
                                                                                                    <div class="fs-xxs mt-2 <?php echo $isClient ? 'text-white-50' : 'text-muted'; ?>"><?php echo e($message['created_at']); ?></div>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                <?php else: ?>
                                                                                    <div class="text-muted">Sin mensajes aún.</div>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <form method="post" action="index.php?route=clients/portal/tickets/message&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>#soporte">
                                                                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                                                <input type="hidden" name="ticket_id" value="<?php echo $activeSupportTicketId; ?>">
                                                                                <div class="mb-2">
                                                                                    <textarea name="message" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                                                                                </div>
                                                                                <div class="text-end">
                                                                                    <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="text-muted">Selecciona un ticket para ver el detalle.</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-cuenta">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-header border-0">
                                                    <p class="text-muted mb-0 fs-xs text-uppercase">Cuenta</p>
                                                    <h5 class="mb-0">Datos de contacto</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" action="index.php?route=clients/portal/update" enctype="multipart/form-data" class="row g-3">
                                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                        <input type="hidden" name="token" value="<?php echo e($client['portal_token'] ?? ''); ?>">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Correo</label>
                                                            <input type="email" name="email" class="form-control" value="<?php echo e($client['email'] ?? ''); ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Teléfono</label>
                                                            <input type="text" name="phone" class="form-control" value="<?php echo e($client['phone'] ?? ''); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Contacto</label>
                                                            <input type="text" name="contact" class="form-control" value="<?php echo e($client['contact'] ?? ''); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Dirección</label>
                                                            <input type="text" name="address" class="form-control" value="<?php echo e($client['address'] ?? ''); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Foto de perfil</label>
                                                            <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                                            <div class="form-text">Formatos permitidos: JPG, PNG o WEBP (máx 2MB).</div>
                                                            <?php if (!empty($client['avatar_path'])): ?>
                                                                <div class="mt-2">
                                                                    <img src="<?php echo e($client['avatar_path']); ?>" alt="Avatar cliente" class="rounded-3" style="width: 72px; height: 72px; object-fit: cover;">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('partials/footer.php'); ?>
        </div>
    </div>

    <?php include('partials/customizer.php'); ?>
    <?php include('partials/footer-scripts.php'); ?>
</body>

</html>
