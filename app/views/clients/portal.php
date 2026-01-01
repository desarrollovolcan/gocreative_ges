<?php include('partials/html.php'); ?>

<head>
    <?php $title = $title ?? 'Portal Cliente'; include('partials/title-meta.php'); ?>
    <?php include('partials/head-css.php'); ?>
</head>

<?php
$companySettings = app_config('company', []);
$logoColor = $companySettings['logo_color'] ?? 'assets/images/logo.png';
$logoBlack = $companySettings['logo_black'] ?? $logoColor;
$portalLogo = $logoBlack ?: login_logo_src($companySettings);
$clientInitial = strtoupper(mb_substr($client['name'] ?? 'C', 0, 1));

$upcomingTasks = array_values(array_filter($projectTasks ?? [], static fn(array $task): bool => empty($task['completed'])));
$projectsCount = count($projectsOverview ?? []);
$openTickets = count($supportTickets ?? []);
$pendingCount = count($pendingInvoices ?? []);
$paymentsCount = count($payments ?? []);
$activeSupportTicketId = (int)($activeSupportTicketId ?? 0);
$nextInvoice = $pendingInvoices[0] ?? null;
$latestPayment = $payments[0] ?? null;
$nextTask = $upcomingTasks[0] ?? null;
?>

<body class="bg-light">
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-xxl py-4 px-3 px-lg-4">
                    <div class="card border-0 shadow-sm mb-3 position-relative overflow-hidden">
                        <div class="card-body p-4">
                            <div class="row g-3 align-items-center justify-content-between">
                                <div class="col-lg-7 d-flex align-items-center gap-3">
                                    <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 64px; height: 64px;">
                                        <span class="fw-semibold text-primary fs-4 lh-1"><?php echo e($clientInitial); ?></span>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 text-uppercase fs-xs">Portal del cliente</p>
                                        <h4 class="mb-1 fw-semibold">Hola, <?php echo e($client['name'] ?? 'Cliente'); ?></h4>
                                        <p class="text-muted mb-0">Vista corporativa clara para seguir facturación, proyectos y soporte en un solo lugar.</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex flex-wrap justify-content-lg-end justify-content-start gap-2">
                                    <a class="btn btn-soft-primary" href="#facturacion">Facturación</a>
                                    <a class="btn btn-soft-success" href="#soporte">Soporte</a>
                                    <a class="btn btn-soft-warning text-dark" href="#perfil">Perfil</a>
                                    <a class="btn btn-outline-secondary" href="index.php?route=clients/portal/logout">Cerrar sesión</a>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <a class="btn btn-outline-secondary" href="#perfil">Perfil</a>
                                <a class="btn btn-soft-primary" href="#resumen">Resumen</a>
                                <a class="btn btn-outline-danger" href="index.php?route=clients/portal/logout">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body py-3">
                            <div class="nav nav-pills flex-nowrap overflow-auto gap-2">
                                <a class="btn btn-soft-primary" href="#resumen">Resumen</a>
                                <a class="btn btn-soft-success" href="#facturacion">Facturas</a>
                                <a class="btn btn-soft-info" href="#pagos">Pagos</a>
                                <a class="btn btn-soft-warning text-dark" href="#proyectos">Proyectos</a>
                                <a class="btn btn-soft-secondary" href="#soporte">Soporte</a>
                                <a class="btn btn-soft-dark" href="#perfil">Cuenta</a>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="col-lg-3 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted fs-xs mb-3">Menú</h6>
                                    <div class="nav flex-column gap-2">
                                        <a class="btn btn-soft-primary text-start" href="#resumen">Resumen</a>
                                        <a class="btn btn-soft-success text-start" href="#facturacion">Facturación</a>
                                        <a class="btn btn-soft-info text-start" href="#pagos">Pagos</a>
                                        <a class="btn btn-soft-warning text-start text-dark" href="#proyectos">Proyectos</a>
                                        <a class="btn btn-soft-secondary text-start" href="#soporte">Soporte</a>
                                        <a class="btn btn-soft-dark text-start" href="#perfil">Perfil</a>
                                        <a class="btn btn-outline-danger text-start" href="index.php?route=clients/portal/logout">Cerrar sesión</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <?php if (!empty($success)): ?>
                                <div class="alert alert-success"><?php echo e($success); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['error'])): ?>
                                <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
                            <?php endif; ?>

                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4" id="resumen">
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="text-muted fs-xs mb-0 text-uppercase">Facturas pendientes</p>
                                                <span class="badge bg-warning-subtle text-warning"><?php echo $pendingCount; ?></span>
                                            </div>
                                            <h3 class="fw-semibold mb-1"><?php echo e(format_currency((float)($pendingTotal ?? 0))); ?></h3>
                                            <p class="text-muted mb-0"><?php echo $pendingCount; ?> documento(s)</p>
                                            <?php if ($nextInvoice): ?>
                                                <div class="mt-2 text-muted fs-sm">Próxima: <?php echo e($nextInvoice['fecha_vencimiento'] ?? '-'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="text-muted fs-xs mb-0 text-uppercase">Pagos registrados</p>
                                                <span class="badge bg-success-subtle text-success"><?php echo $paymentsCount; ?></span>
                                            </div>
                                            <h3 class="fw-semibold mb-1"><?php echo e(format_currency((float)($paidTotal ?? 0))); ?></h3>
                                            <p class="text-muted mb-0"><?php echo $paymentsCount; ?> pago(s)</p>
                                            <?php if ($latestPayment): ?>
                                                <div class="mt-2 text-muted fs-sm">Último: <?php echo e($latestPayment['fecha_pago'] ?? '-'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="text-muted fs-xs mb-0 text-uppercase">Proyectos</p>
                                                <span class="badge bg-info-subtle text-info"><?php echo $projectsCount; ?></span>
                                            </div>
                                            <h3 class="fw-semibold mb-1"><?php echo $projectsCount; ?></h3>
                                            <p class="text-muted mb-0"><?php echo count($projectTasks ?? []); ?> tareas totales</p>
                                            <?php if ($nextTask): ?>
                                                <div class="mt-2 text-muted fs-sm">Próxima tarea: <?php echo e($nextTask['title'] ?? $nextTask['name'] ?? ''); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="text-muted fs-xs mb-0 text-uppercase">Soporte</p>
                                                <span class="badge bg-primary-subtle text-primary"><?php echo $openTickets; ?></span>
                                            </div>
                                            <h3 class="fw-semibold mb-1"><?php echo $openTickets; ?> ticket(s)</h3>
                                            <p class="text-muted mb-0">Seguimiento de solicitudes y mensajes activos.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <div class="row g-3 mb-4 align-items-stretch" id="facturacion">
                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Facturas pendientes</h5>
                                        <span class="badge bg-light text-muted"><?php echo $pendingCount; ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($pendingInvoices)): ?>
                                        <div class="table-responsive d-none d-lg-block">
                                            <table class="table table-centered align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Número</th>
                                                        <th>Vence</th>
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
                                                                <a class="btn btn-outline-primary btn-sm" href="index.php?route=clients/portal/invoice&id=<?php echo (int)($invoice['id'] ?? 0); ?>&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>">Ver</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-lg-none">
                                            <div class="list-group list-group-flush">
                                                <?php foreach (array_slice($pendingInvoices, 0, 6) as $invoice): ?>
                                                    <div class="list-group-item px-0">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <div class="fw-semibold">#<?php echo e($invoice['numero'] ?? $invoice['id']); ?></div>
                                                            <span class="badge bg-warning-subtle text-warning text-capitalize"><?php echo e($invoice['estado'] ?? 'pendiente'); ?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="text-muted fs-xs">Vence: <?php echo e($invoice['fecha_vencimiento'] ?? '-'); ?></div>
                                                            <div class="fw-semibold"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <a class="btn btn-outline-primary btn-sm w-100" href="index.php?route=clients/portal/invoice&id=<?php echo (int)($invoice['id'] ?? 0); ?>&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>">Ver detalle</a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">No tienes facturas pendientes.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5" id="pagos">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Pagos recientes</h5>
                                        <span class="badge bg-light text-muted"><?php echo $paymentsCount; ?></span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <?php if (!empty($payments)): ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach (array_slice($payments, 0, 6) as $payment): ?>
                                                <div class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="fw-semibold">Pago <?php echo e($payment['invoice_number'] ?? '#'); ?></div>
                                                            <div class="text-muted fs-xs"><?php echo e($payment['fecha_pago'] ?? '-'); ?></div>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="fw-semibold"><?php echo e(format_currency((float)($payment['monto'] ?? 0))); ?></div>
                                                            <span class="badge bg-success-subtle text-success text-capitalize"><?php echo e($payment['invoice_status'] ?? 'pagado'); ?></span>
                                                        </div>
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

                    <div class="row g-3 mb-4" id="proyectos">
                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Proyectos</h5>
                                        <span class="badge bg-light text-muted"><?php echo $projectsCount; ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($projectsOverview)): ?>
                                        <div class="table-responsive d-none d-lg-block">
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
                                        <div class="d-lg-none">
                                            <div class="list-group list-group-flush">
                                                <?php foreach ($projectsOverview as $project): ?>
                                                    <?php
                                                    $tasksTotal = (int)($project['tasks_total'] ?? 0);
                                                    $tasksCompleted = (int)($project['tasks_completed'] ?? 0);
                                                    $progress = $tasksTotal > 0 ? (int)round(($tasksCompleted / max(1, $tasksTotal)) * 100) : 0;
                                                    ?>
                                                    <div class="list-group-item px-0">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <div class="fw-semibold"><?php echo e($project['name'] ?? 'Proyecto'); ?></div>
                                                                <div class="text-muted fs-xs text-capitalize"><?php echo e($project['status'] ?? 'en progreso'); ?></div>
                                                            </div>
                                                            <span class="badge bg-primary-subtle text-primary"><?php echo $progress; ?>%</span>
                                                        </div>
                                                        <div class="progress mt-2" style="height: 6px;">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="d-flex justify-content-between text-muted fs-xxs mt-2">
                                                            <span><?php echo $tasksCompleted; ?> de <?php echo $tasksTotal; ?> tareas</span>
                                                            <span><?php echo e($project['last_activity'] ?? 'Sin actividad'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">Aún no hay proyectos registrados.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5" id="tareas">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Próximas tareas</h5>
                                        <span class="badge bg-light text-muted"><?php echo count($upcomingTasks); ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($upcomingTasks)): ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach (array_slice($upcomingTasks, 0, 6) as $task): ?>
                                                <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <div class="fw-semibold"><?php echo e($task['title'] ?? $task['name'] ?? 'Tarea'); ?></div>
                                                        <div class="text-muted fs-xs"><?php echo e($task['project_name'] ?? 'Proyecto'); ?></div>
                                                    </div>
                                                    <span class="badge bg-secondary-subtle text-secondary"><?php echo !empty($task['due_date']) ? e($task['due_date']) : 'Sin fecha'; ?></span>
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
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0">
                                    <h5 class="mb-0">Crear ticket</h5>
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
                                        <button type="submit" class="btn btn-primary w-100">Enviar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Mis tickets</h5>
                                        <span class="badge bg-light text-muted"><?php echo $openTickets; ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-5">
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
                                        <div class="col-md-7">
                                            <?php if (!empty($activeSupportTicket)): ?>
                                                <div class="border rounded-3 p-3 h-100 d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h6 class="fw-semibold mb-1">#<?php echo (int)$activeSupportTicket['id']; ?> · <?php echo e($activeSupportTicket['subject'] ?? ''); ?></h6>
                                                            <div class="text-muted fs-xxs text-uppercase">Estado: <?php echo e(str_replace('_', ' ', $activeSupportTicket['status'] ?? 'abierto')); ?></div>
                                                        </div>
                                                        <h4 class="fw-semibold mb-1"><?php echo $openTickets; ?> tickets</h4>
                                                        <p class="text-muted fs-sm mb-0">Gestiona tus solicitudes y mensajes con el equipo.</p>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mt-3">
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
                                            <?php else: ?>
                                                <div class="text-muted">Selecciona un ticket para ver su detalle.</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4" id="perfil">
                        <div class="card-header border-0">
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
            <?php include('partials/footer.php'); ?>
        </div>
    </div>

    <?php include('partials/customizer.php'); ?>
    <?php include('partials/footer-scripts.php'); ?>
</body>

</html>
