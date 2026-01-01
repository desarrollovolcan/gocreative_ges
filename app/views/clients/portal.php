<?php include('partials/html.php'); ?>

<head>
    <?php $title = $title ?? 'Portal Cliente'; include('partials/title-meta.php'); ?>
    <?php include('partials/head-css.php'); ?>
</head>

<?php
$tasksByProject = [];
foreach (($projectTasks ?? []) as $task) {
    $tasksByProject[$task['project_id']][] = $task;
}
$upcomingTasks = array_values(array_filter($projectTasks ?? [], static function (array $task): bool {
    return empty($task['completed']);
}));
$projectsCount = count($projectsOverview ?? []);
$openTickets = count($supportTickets ?? []);
$pendingCount = count($pendingInvoices ?? []);
$paymentsCount = count($payments ?? []);
$activeSupportTicketId = (int)($activeSupportTicketId ?? 0);
?>

<body>
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <?php $subtitle = "Portal"; $title = "Panel del Cliente"; include('partials/page-title.php'); ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo e($success); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <div class="card overflow-hidden border-0 mb-3">
                        <div class="card-body position-relative bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <p class="text-white-50 mb-2">Bienvenido/a</p>
                                    <h3 class="fw-semibold mb-2"><?php echo e($client['name'] ?? 'Portal Cliente'); ?></h3>
                                    <p class="text-white-50 mb-3">Accede al estado de tus proyectos, pagos y tickets en un solo dashboard.</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a class="btn btn-light" href="index.php?route=clients/portalLogout">Cerrar sesión</a>
                                        <a class="btn btn-outline-light" href="#perfil">Actualizar perfil</a>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-lg-end text-center mt-3 mt-lg-0">
                                    <div class="d-inline-flex align-items-center gap-3 bg-white bg-opacity-10 rounded-3 px-3 py-2">
                                        <div class="avatar-lg bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-briefcase fs-32 text-white"></i>
                                        </div>
                                        <div class="text-start">
                                            <div class="text-white-50 fs-xs">Proyectos activos</div>
                                            <div class="fs-3 fw-semibold"><?php echo $projectsCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-xxl-2 col-md-4 col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted fs-xs">Facturas pendientes</span>
                                        <span class="badge bg-warning-subtle text-warning"><?php echo $pendingCount; ?></span>
                                    </div>
                                    <h4 class="fw-semibold mb-0"><?php echo e(format_currency((float)($pendingTotal ?? 0))); ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-4 col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted fs-xs">Pagos realizados</span>
                                        <span class="badge bg-success-subtle text-success"><?php echo $paymentsCount; ?></span>
                                    </div>
                                    <h4 class="fw-semibold mb-0"><?php echo e(format_currency((float)($paidTotal ?? 0))); ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-4 col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted fs-xs">Tareas activas</span>
                                        <span class="badge bg-info-subtle text-info"><?php echo count($upcomingTasks); ?></span>
                                    </div>
                                    <h4 class="fw-semibold mb-0"><?php echo count($projectTasks ?? []); ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-4 col-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted fs-xs">Tickets soporte</span>
                                        <span class="badge bg-secondary-subtle text-secondary"><?php echo $openTickets; ?></span>
                                    </div>
                                    <h4 class="fw-semibold mb-0"><?php echo $openTickets; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-8 col-12">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted fs-xs mb-1">Próxima entrega</p>
                                        <h5 class="fw-semibold mb-0">
                                            <?php
                                            $nextTask = $upcomingTasks[0] ?? null;
                                            echo $nextTask ? e($nextTask['title'] ?? $nextTask['name'] ?? 'Tarea') : 'Sin tareas pendientes';
                                            ?>
                                        </h5>
                                    </div>
                                    <a href="#tareas" class="btn btn-primary btn-sm">Ver tareas</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-xl-7">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs">Proyectos y avance</p>
                                        <h5 class="mb-0">Estado de proyectos</h5>
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
                                                                <div class="text-muted fs-xs"><?php echo e($project['status'] ?? 'en progreso'); ?></div>
                                                            </td>
                                                            <td style="width: 40%;">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <span class="fw-semibold fs-xs"><?php echo $progress; ?>%</span>
                                                                </div>
                                                                <div class="text-muted fs-xxs mt-1"><?php echo $tasksCompleted; ?> de <?php echo $tasksTotal; ?> tareas completadas</div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted fs-sm"><?php echo e($project['last_activity'] ?? 'Sin actividad'); ?></span>
                                                            </td>
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
                                        <p class="text-muted mb-0 fs-xs">Planificación</p>
                                        <h5 class="mb-0">Próximas tareas</h5>
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

                    <div class="row g-3 mb-3">
                        <div class="col-xl-7">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs">Facturación</p>
                                        <h5 class="mb-0">Facturas pendientes</h5>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning"><?php echo $pendingCount; ?> pendientes</span>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($pendingInvoices)): ?>
                                        <div class="table-responsive">
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
                                                    <?php foreach (array_slice($pendingInvoices, 0, 5) as $invoice): ?>
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
                                    <?php else: ?>
                                        <div class="text-muted">No hay facturas pendientes.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs">Pagos</p>
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

                    <div class="row g-3 mb-3" id="soporte">
                        <div class="col-xl-5">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header border-0 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-0 fs-xs">Soporte</p>
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
                                        <p class="text-muted mb-0 fs-xs">Seguimiento</p>
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

                    <div class="row g-3 mb-4" id="perfil">
                        <div class="col-lg-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header border-0">
                                    <p class="text-muted mb-0 fs-xs">Perfil</p>
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
