<?php include('partials/html.php'); ?>

<head>
    <?php $title = $title ?? 'Portal Cliente'; include('partials/title-meta.php'); ?>
    <?php include('partials/head-css.php'); ?>
</head>

<?php
$upcomingTasks = array_values(array_filter($projectTasks ?? [], static fn(array $task): bool => empty($task['completed'])));
$projectsCount = count($projectsOverview ?? []);
$openTickets = count($supportTickets ?? []);
$pendingCount = count($pendingInvoices ?? []);
$paymentsCount = count($payments ?? []);
$activeSupportTicketId = (int)($activeSupportTicketId ?? 0);
$portalLogo = login_logo_src(app_config('company', []));
$nextInvoice = $pendingInvoices[0] ?? null;
$latestPayment = $payments[0] ?? null;
$nextTask = $upcomingTasks[0] ?? null;
?>

<body class="bg-body-tertiary">
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-xl py-4">
                    <div class="card border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                        <div class="card-body p-4 position-relative" style="background: linear-gradient(135deg, #0d6efd 0%, #1e293b 100%);">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                        <img src="<?php echo e($portalLogo); ?>" alt="Logo" height="32">
                                    </div>
                                    <div class="text-white">
                                        <p class="mb-1 text-white-50 text-uppercase fw-semibold fs-xs">Portal del cliente</p>
                                        <h3 class="mb-1 fw-semibold"><?php echo e($client['name'] ?? 'Cliente'); ?></h3>
                                        <p class="mb-0 text-white-50">Panel en formato de control para que sigas tus proyectos, pagos y soporte.</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a class="btn btn-outline-light" href="#cuenta"><i class="ti ti-user"></i> Mis datos</a>
                                    <a class="btn btn-light" href="index.php?route=clients/portalLogout"><i class="ti ti-logout"></i> Cerrar sesión</a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <a class="badge bg-white text-primary px-3 py-2" href="#resumen"><i class="ti ti-dashboard"></i> Dashboard</a>
                                    <a class="badge bg-white text-primary px-3 py-2" href="#facturacion"><i class="ti ti-receipt"></i> Facturación</a>
                                    <a class="badge bg-white text-primary px-3 py-2" href="#proyectos"><i class="ti ti-briefcase"></i> Proyectos</a>
                                    <a class="badge bg-white text-primary px-3 py-2" href="#soporte"><i class="ti ti-lifebuoy"></i> Soporte</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo e($success); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <div class="row g-3 mb-3" id="resumen">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="text-muted fs-xs text-uppercase">Facturas pendientes</span>
                                        <span class="badge bg-warning-subtle text-warning"><?php echo $pendingCount; ?></span>
                                    </div>
                                    <h3 class="fw-semibold mb-2"><?php echo e(format_currency((float)($pendingTotal ?? 0))); ?></h3>
                                    <p class="text-muted fs-sm mb-0">
                                        <?php if ($nextInvoice): ?>
                                            Próxima: <?php echo e($nextInvoice['fecha_vencimiento'] ?? '-'); ?> · #<?php echo e($nextInvoice['numero'] ?? $nextInvoice['id'] ?? ''); ?>
                                        <?php else: ?>
                                            Estás al día, no tienes pendientes.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="text-muted fs-xs text-uppercase">Pagos registrados</span>
                                        <span class="badge bg-success-subtle text-success"><?php echo $paymentsCount; ?></span>
                                    </div>
                                    <h3 class="fw-semibold mb-2"><?php echo e(format_currency((float)($paidTotal ?? 0))); ?></h3>
                                    <p class="text-muted fs-sm mb-0">
                                        <?php if ($latestPayment): ?>
                                            Último pago: <?php echo e($latestPayment['fecha_pago'] ?? '-'); ?> · <?php echo e(format_currency((float)($latestPayment['monto'] ?? 0))); ?>
                                        <?php else: ?>
                                            Aún no registramos pagos.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="text-muted fs-xs text-uppercase">Proyectos activos</span>
                                        <span class="badge bg-primary-subtle text-primary"><?php echo $projectsCount; ?></span>
                                    </div>
                                    <h3 class="fw-semibold mb-2"><?php echo count($projectTasks ?? []); ?> tareas</h3>
                                    <p class="text-muted fs-sm mb-0">
                                        <?php if ($nextTask): ?>
                                            Próximo entregable: <?php echo e($nextTask['title'] ?? $nextTask['name'] ?? 'Tarea'); ?>
                                        <?php else: ?>
                                            Sin tareas pendientes por ahora.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="text-muted fs-xs text-uppercase">Soporte</span>
                                        <span class="badge bg-info-subtle text-info"><?php echo $openTickets; ?></span>
                                    </div>
                                    <h3 class="fw-semibold mb-2"><?php echo $openTickets; ?> tickets</h3>
                                    <p class="text-muted fs-sm mb-0">Accede a tus conversaciones y crea nuevas solicitudes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-xl-8">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs text-uppercase">Panel rápido</p>
                                        <h5 class="mb-0">Opciones relevantes</h5>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">Atajos</span>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3 border d-flex align-items-center gap-3">
                                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                    <i class="ti ti-receipt fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">Revisar facturación</h6>
                                                    <p class="text-muted fs-sm mb-2">Descubre tus documentos y estados de pago.</p>
                                                    <div class="d-flex gap-2">
                                                        <a class="btn btn-sm btn-primary" href="#facturacion">Ver facturas</a>
                                                        <a class="btn btn-sm btn-outline-primary" href="#pagos">Pagos recientes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3 border d-flex align-items-center gap-3">
                                                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                    <i class="ti ti-headset fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">Soporte y tickets</h6>
                                                    <p class="text-muted fs-sm mb-2">Crea nuevas solicitudes o revisa respuestas.</p>
                                                    <div class="d-flex gap-2">
                                                        <a class="btn btn-sm btn-success" href="#soporte">Ir a soporte</a>
                                                        <a class="btn btn-sm btn-outline-success" href="#soporte">Ver conversación</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3 border d-flex align-items-center gap-3">
                                                <div class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                    <i class="ti ti-briefcase fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">Seguimiento de proyectos</h6>
                                                    <p class="text-muted fs-sm mb-2">Revisa avances, tareas y próximas fechas.</p>
                                                    <a class="btn btn-sm btn-info" href="#proyectos">Abrir proyectos</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3 border d-flex align-items-center gap-3">
                                                <div class="bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                    <i class="ti ti-user-circle fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">Mi perfil</h6>
                                                    <p class="text-muted fs-sm mb-2">Actualiza tus datos de contacto y notificaciones.</p>
                                                    <a class="btn btn-sm btn-secondary" href="#cuenta">Ver perfil</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4" id="pagos">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs text-uppercase">Actividad</p>
                                        <h5 class="mb-0">Últimos movimientos</h5>
                                    </div>
                                    <span class="badge bg-dark-subtle text-dark">Hoy</span>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($activities)): ?>
                                        <div class="list-group list-group-flush">
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
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">Aún no registramos actividad reciente.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3" id="facturacion">
                        <div class="col-xl-7">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs text-uppercase">Facturación</p>
                                        <h5 class="mb-0">Facturas pendientes</h5>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning"><?php echo $pendingCount; ?> abiertas</span>
                                </div>
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
                        <div class="col-xl-5">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs text-uppercase">Pagos</p>
                                        <h5 class="mb-0">Pagos recientes</h5>
                                    </div>
                                    <span class="badge bg-success-subtle text-success"><?php echo $paymentsCount; ?> registros</span>
                                </div>
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

                    <div class="row g-3 mb-3" id="proyectos">
                        <div class="col-xl-7">
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
                        <div class="col-xl-5" id="tareas">
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

                    <div class="row g-3 mb-4" id="soporte">
                        <div class="col-xl-5">
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
                        <div class="col-xl-7">
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

                    <div class="row g-3 mb-4" id="cuenta">
                        <div class="col-lg-12">
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
            <?php include('partials/footer.php'); ?>
        </div>
    </div>

    <?php include('partials/customizer.php'); ?>
    <?php include('partials/footer-scripts.php'); ?>
</body>

</html>
