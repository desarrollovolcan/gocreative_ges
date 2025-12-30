<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo e($error); ?></div>
<?php else: ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo e($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <div class="container">
        <?php
        $tasksByProject = [];
        foreach (($projectTasks ?? []) as $task) {
            $tasksByProject[$task['project_id']][] = $task;
        }
        $upcomingTasks = array_filter($projectTasks ?? [], static function (array $task): bool {
            return empty($task['completed']);
        });
        ?>
        <div class="row">
            <div class="col-12">
                <article class="card overflow-hidden mb-0 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden" style="min-height: 220px; background-image: linear-gradient(135deg, rgba(17,24,39,0.95), rgba(30,41,59,0.88)), url(assets/images/profile-bg.jpg); background-size: cover; background-position: center;">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="backdrop-filter: blur(6px);"></div>
                        <div class="position-relative p-4 p-md-5 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4 text-white">
                            <div>
                                <span class="badge bg-white text-dark mb-3">Portal cliente</span>
                                <h2 class="mb-2 fw-semibold"><?php echo e($client['name'] ?? 'Portal Cliente'); ?></h2>
                                <p class="mb-0 text-white-50">Seguimiento de proyectos, tareas y pagos en un solo espacio.</p>
                            </div>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="rounded-3 p-3 text-center" style="min-width: 120px; background: rgba(255,255,255,0.08);">
                                    <div class="fw-semibold fs-4"><?php echo count($pendingInvoices ?? []); ?></div>
                                    <div class="text-white-50 fs-xs">Pendientes</div>
                                </div>
                                <div class="rounded-3 p-3 text-center" style="min-width: 120px; background: rgba(255,255,255,0.08);">
                                    <div class="fw-semibold fs-4"><?php echo count($payments ?? []); ?></div>
                                    <div class="text-white-50 fs-xs">Pagos</div>
                                </div>
                                <div class="rounded-3 p-3 text-center" style="min-width: 120px; background: rgba(255,255,255,0.08);">
                                    <div class="fw-semibold fs-4"><?php echo count($activities ?? []); ?></div>
                                    <div class="text-white-50 fs-xs">Actividades</div>
                                </div>
                                <div class="rounded-3 p-3 text-center" style="min-width: 120px; background: rgba(255,255,255,0.08);">
                                    <div class="fw-semibold fs-4"><?php echo count($upcomingTasks); ?></div>
                                    <div class="text-white-50 fs-xs">Tareas activas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="px-3 mt-n4">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-top-sticky shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-3 position-relative">
                                    <?php if (!empty($client['avatar_path'])): ?>
                                        <img src="<?php echo e($client['avatar_path']); ?>" alt="Avatar cliente" class="rounded-3" style="width: 72px; height: 72px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="avatar-lg bg-dark-subtle text-dark rounded-3 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-building fs-28"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h5 class="mb-0 d-flex align-items-center">
                                        <span class="link-reset"><?php echo e($client['name'] ?? ''); ?></span>
                                    </h5>
                                    <p class="text-muted mb-2">Rut: <?php echo e($client['rut'] ?? '-'); ?></p>
                                    <span class="badge text-bg-light badge-label">Cliente activo</span>
                                </div>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-3">
                                        <i class="ti ti-mail fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Correo</div>
                                        <div class="fw-semibold"><?php echo e($client['email'] ?? '-'); ?></div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-3">
                                        <i class="ti ti-phone fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Teléfono</div>
                                        <div class="fw-semibold"><?php echo e($client['phone'] ?? '-'); ?></div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-3">
                                        <i class="ti ti-user fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Contacto</div>
                                        <div class="fw-semibold"><?php echo e($client['contact'] ?? '-'); ?></div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-3">
                                        <i class="ti ti-map-pin fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Dirección</div>
                                        <div class="fw-semibold"><?php echo e($client['address'] ?? '-'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="card-title mb-3 mt-4">Resumen financiero</h4>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-3 rounded-3 border bg-white">
                                        <div class="text-muted fs-xs">Pendientes</div>
                                        <div class="fw-semibold"><?php echo count($pendingInvoices ?? []); ?></div>
                                        <div class="text-muted fs-xs"><?php echo e(format_currency((float)($pendingTotal ?? 0))); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-3 border bg-white">
                                        <div class="text-muted fs-xs">Pagos</div>
                                        <div class="fw-semibold"><?php echo count($payments ?? []); ?></div>
                                        <div class="text-muted fs-xs"><?php echo e(format_currency((float)($paidTotal ?? 0))); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-3 rounded-3 border bg-light">
                                <h6 class="fw-semibold mb-2">Resumen de planificación</h6>
                                <div class="d-flex justify-content-between text-muted fs-xs">
                                    <span>Tareas activas</span>
                                    <span><?php echo count($upcomingTasks); ?></span>
                                </div>
                                <div class="d-flex justify-content-between text-muted fs-xs mt-1">
                                    <span>Última actividad</span>
                                    <span><?php echo !empty($activities[0]['created_at']) ? e($activities[0]['created_at']) : 'Sin registros'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header card-tabs d-flex align-items-center flex-wrap gap-2">
                            <div class="flex-grow-1">
                                <h4 class="card-title">Portal Cliente</h4>
                            </div>
                            <ul class="nav nav-tabs card-header-tabs nav-bordered flex-wrap gap-1">
                                <li class="nav-item">
                                    <a href="#portal-wall" data-bs-toggle="tab" aria-expanded="true" class="nav-link active py-1 px-2">
                                        <i class="ti ti-layout-dashboard me-1"></i><span class="fw-semibold">Muro</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-projects" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1 px-2">
                                        <i class="ti ti-briefcase me-1"></i><span class="fw-semibold">Proyectos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-activities" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1 px-2">
                                        <i class="ti ti-activity me-1"></i><span class="fw-semibold">Actividades</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-payments" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1 px-2">
                                        <i class="ti ti-credit-card me-1"></i><span class="fw-semibold">Pagos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-invoices" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1 px-2">
                                        <i class="ti ti-receipt me-1"></i><span class="fw-semibold">Facturas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-profile" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1 px-2">
                                        <i class="ti ti-user me-1"></i><span class="fw-semibold">Perfil</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-support" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1 px-2">
                                        <i class="ti ti-help-circle me-1"></i><span class="fw-semibold">Soporte</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="portal-wall">
                                    <div class="row g-3">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <h5 class="mb-1">Estado de proyectos</h5>
                                                        <p class="text-muted mb-0">Un vistazo rápido a lo que está en curso.</p>
                                                    </div>
                                                    <a href="#portal-projects" data-portal-tab="#portal-projects" class="btn btn-outline-primary btn-sm">Ver todos</a>
                                                </div>
                                            </div>
                                        <?php if (!empty($projectsOverview)): ?>
                                            <?php foreach ($projectsOverview as $project): ?>
                                                <?php
                                                $tasksTotal = (int)($project['tasks_total'] ?? 0);
                                                $tasksCompleted = (int)($project['tasks_completed'] ?? 0);
                                                $tasksProgress = (float)($project['tasks_progress'] ?? 0);
                                                $progress = $tasksTotal > 0 ? (int)min(100, round($tasksProgress / $tasksTotal)) : 0;
                                                ?>
                                                <div class="col-md-6">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                                            <div>
                                                                <h6 class="mb-1"><?php echo e($project['name'] ?? 'Proyecto'); ?></h6>
                                                                <div class="text-muted fs-xs">Estado: <?php echo e($project['status'] ?? ''); ?></div>
                                                            </div>
                                                            <span class="badge bg-primary-subtle text-primary"><?php echo e($project['status'] ?? ''); ?></span>
                                                        </div>
                                                        <p class="text-muted fs-sm mb-2"><?php echo e($project['description'] ?? 'Sin descripción registrada.'); ?></p>
                                                        <div class="mb-2">
                                                            <div class="d-flex justify-content-between fs-xs text-muted">
                                                                <span>Progreso</span>
                                                                <span><?php echo $progress; ?>%</span>
                                                            </div>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between fs-xs text-muted">
                                                            <span>Tareas: <?php echo $tasksCompleted; ?>/<?php echo $tasksTotal; ?></span>
                                                            <span>Inicio: <?php echo e($project['start_date'] ?? 'Por definir'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <div class="text-muted">No hay proyectos registrados.</div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-4">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <h5 class="mb-1">Próximas tareas</h5>
                                                <p class="text-muted mb-0">Planificación tipo Gantt basada en fechas de inicio y entrega.</p>
                                            </div>
                                            <a href="#portal-projects" data-portal-tab="#portal-projects" class="btn btn-outline-secondary btn-sm">Ver planificación</a>
                                        </div>
                                        <?php if (!empty($upcomingTasks)): ?>
                                            <div class="list-group list-group-flush">
                                                <?php foreach (array_slice($upcomingTasks, 0, 5) as $task): ?>
                                                    <?php
                                                    $taskStart = $task['start_date'] ?? '';
                                                    $taskEnd = $task['end_date'] ?? '';
                                                    $taskProgress = (int)($task['progress_percent'] ?? 0);
                                                    ?>
                                                    <div class="list-group-item px-0">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <div class="fw-semibold"><?php echo e($task['title'] ?? '-'); ?></div>
                                                                <div class="text-muted fs-xs"><?php echo e($task['project_name'] ?? '-'); ?> · <?php echo e($taskStart !== '' ? $taskStart : 'Sin inicio'); ?> → <?php echo e($taskEnd !== '' ? $taskEnd : 'Sin entrega'); ?></div>
                                                            </div>
                                                            <span class="badge bg-primary-subtle text-primary"><?php echo $taskProgress; ?>%</span>
                                                        </div>
                                                        <div class="progress progress-sm mt-2">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo min(100, $taskProgress); ?>%"></div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-muted">No hay tareas pendientes en este momento.</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-4">
                                        <h5 class="mb-3">Actividad reciente</h5>
                                        <?php if (!empty($activities)): ?>
                                            <div class="list-group list-group-flush">
                                                <?php foreach (array_slice($activities, 0, 5) as $activity): ?>
                                                    <div class="list-group-item px-0 d-flex align-items-center gap-3">
                                                        <span class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-checklist text-primary"></i>
                                                        </span>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-semibold"><?php echo e($activity['title'] ?? '-'); ?></div>
                                                            <div class="text-muted fs-xs"><?php echo e($activity['project_name'] ?? '-'); ?> · <?php echo e($activity['created_at'] ?? '-'); ?></div>
                                                        </div>
                                                        <?php if (!empty($activity['completed'])): ?>
                                                            <span class="badge bg-success-subtle text-success">Completada</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary-subtle text-secondary">En progreso</span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-muted">No hay actividades registradas.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="tab-pane" id="portal-projects">
                                    <?php if (!empty($projectsOverview)): ?>
                                        <div class="row g-3">
                                            <?php foreach ($projectsOverview as $project): ?>
                                                <?php
                                                $tasksTotal = (int)($project['tasks_total'] ?? 0);
                                                $tasksCompleted = (int)($project['tasks_completed'] ?? 0);
                                                $tasksProgress = (float)($project['tasks_progress'] ?? 0);
                                                $progress = $tasksTotal > 0 ? (int)min(100, round($tasksProgress / $tasksTotal)) : 0;
                                                ?>
                                                <div class="col-md-6">
                                                        <div class="card border-0 shadow-sm h-100">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-start justify-content-between mb-2">
                                                                    <div>
                                                                        <h6 class="mb-1"><?php echo e($project['name'] ?? 'Proyecto'); ?></h6>
                                                                        <div class="text-muted fs-xs"><?php echo e($project['mandante_name'] ?? 'Mandante no definido'); ?></div>
                                                                    </div>
                                                                    <span class="badge bg-primary-subtle text-primary"><?php echo e($project['status'] ?? ''); ?></span>
                                                                </div>
                                                                <p class="text-muted fs-sm mb-3"><?php echo e($project['description'] ?? 'Sin descripción registrada.'); ?></p>
                                                                <div class="row text-muted fs-xs">
                                                                    <div class="col-6">
                                                                        <div>Inicio</div>
                                                                        <div class="fw-semibold text-dark"><?php echo e($project['start_date'] ?? 'Por definir'); ?></div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div>Entrega</div>
                                                                        <div class="fw-semibold text-dark"><?php echo e($project['delivery_date'] ?? 'Por definir'); ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <div class="d-flex justify-content-between fs-xs text-muted">
                                                                        <span>Avance</span>
                                                                        <span><?php echo $progress; ?>%</span>
                                                                    </div>
                                                                    <div class="progress progress-sm">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2 fs-xs text-muted">Tareas completadas: <?php echo $tasksCompleted; ?> de <?php echo $tasksTotal; ?></div>
                                                                <?php $projectTaskList = $tasksByProject[$project['id']] ?? []; ?>
                                                                <div class="mt-3 p-2 rounded bg-light">
                                                                    <div class="fw-semibold fs-xs text-uppercase text-muted">Planificación (Gantt)</div>
                                                                    <?php if (!empty($projectTaskList)): ?>
                                                                        <div class="mt-2">
                                                                            <?php foreach (array_slice($projectTaskList, 0, 3) as $task): ?>
                                                                                <?php
                                                                                $taskStart = $task['start_date'] ?? '';
                                                                                $taskEnd = $task['end_date'] ?? '';
                                                                                $taskProgress = (int)($task['progress_percent'] ?? 0);
                                                                                ?>
                                                                                <div class="mb-2">
                                                                                    <div class="d-flex justify-content-between fs-xs text-muted">
                                                                                        <span><?php echo e($task['title'] ?? 'Tarea'); ?></span>
                                                                                        <span><?php echo $taskProgress; ?>%</span>
                                                                                    </div>
                                                                                    <div class="progress progress-sm">
                                                                                        <div class="progress-bar <?php echo $taskProgress >= 100 ? 'bg-success' : 'bg-primary'; ?>" role="progressbar" style="width: <?php echo min(100, $taskProgress); ?>%"></div>
                                                                                    </div>
                                                                                    <div class="fs-xs text-muted mt-1"><?php echo e($taskStart !== '' ? $taskStart : 'Sin inicio'); ?> → <?php echo e($taskEnd !== '' ? $taskEnd : 'Sin entrega'); ?></div>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="text-muted fs-xs">No hay tareas registradas para este proyecto.</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">No hay proyectos registrados.</div>
                                    <?php endif; ?>
                                </div>

                                <div class="tab-pane" id="portal-activities">
                                    <?php if (!empty($activities)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Proyecto</th>
                                                        <th>Actividad</th>
                                                        <th>Estado</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($activities as $activity): ?>
                                                        <tr>
                                                            <td><?php echo e($activity['project_name'] ?? '-'); ?></td>
                                                            <td><?php echo e($activity['title'] ?? '-'); ?></td>
                                                            <td>
                                                                <?php if (!empty($activity['completed'])): ?>
                                                                    <span class="badge bg-success-subtle text-success">Completada</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-secondary-subtle text-secondary">En progreso</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo e($activity['created_at'] ?? '-'); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">No hay actividades registradas.</div>
                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane" id="portal-payments">
                                    <?php if (!empty($payments)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Factura</th>
                                                        <th>Monto</th>
                                                        <th>Fecha pago</th>
                                                        <th>Método</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($payments as $payment): ?>
                                                        <tr>
                                                            <td>#<?php echo e($payment['invoice_number'] ?? $payment['invoice_id']); ?></td>
                                                            <td><?php echo e(format_currency((float)($payment['monto'] ?? 0))); ?></td>
                                                            <td><?php echo e($payment['fecha_pago'] ?? '-'); ?></td>
                                                            <td><?php echo e($payment['metodo'] ?? '-'); ?></td>
                                                            <td>
                                                                <span class="badge bg-info-subtle text-info"><?php echo e($payment['invoice_status'] ?? '-'); ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">No hay pagos registrados.</div>
                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane" id="portal-invoices">
                                    <?php if (!empty($pendingInvoices)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Número</th>
                                                        <th>Vence</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                        <th class="text-end">Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($pendingInvoices as $invoice): ?>
                                                        <tr>
                                                            <td>#<?php echo e($invoice['numero']); ?></td>
                                                            <td><?php echo e($invoice['fecha_vencimiento']); ?></td>
                                                            <td><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
                                                            <td><span class="badge bg-warning-subtle text-warning"><?php echo e($invoice['estado']); ?></span></td>
                                                            <td class="text-end">
                                                                <a href="index.php?route=clients/portal/invoice&id=<?php echo $invoice['id']; ?>&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>" class="btn btn-outline-primary btn-sm">Ver factura</a>
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
                                <div class="tab-pane" id="portal-profile">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="mb-1">Editar datos básicos</h5>
                                            <p class="text-muted mb-0">Mantén tu información actualizada para recibir notificaciones.</p>
                                        </div>
                                    </div>
                                    <form method="post" action="index.php?route=clients/portal/update" class="bg-light rounded p-3" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="token" value="<?php echo e($client['portal_token'] ?? ''); ?>">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Foto de perfil</label>
                                                <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                                <div class="form-text">Formatos permitidos: JPG, PNG o WEBP (máx 2MB).</div>
                                                <?php if (!empty($client['avatar_path'])): ?>
                                                    <div class="mt-2">
                                                        <img src="<?php echo e($client['avatar_path']); ?>" alt="Avatar cliente" class="rounded-3" style="width: 72px; height: 72px; object-fit: cover;">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Correo</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo e($client['email'] ?? ''); ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="text" name="phone" class="form-control" value="<?php echo e($client['phone'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Contacto</label>
                                                <input type="text" name="contact" class="form-control" value="<?php echo e($client['contact'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dirección</label>
                                                <input type="text" name="address" class="form-control" value="<?php echo e($client['address'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form>
                                    <div class="mt-4">
                                        <h6 class="fw-semibold">Soporte rápido</h6>
                                        <p class="text-muted mb-0">Si necesitas asistencia inmediata, contáctanos y te ayudaremos a resolverlo.</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="portal-support">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                        <div>
                                            <h5 class="mb-1">Soporte y tickets</h5>
                                            <p class="text-muted mb-0">Registra solicitudes y da seguimiento a cada caso.</p>
                                        </div>
                                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#portalNewTicket">
                                            <i class="ti ti-plus me-1"></i>Nuevo ticket
                                        </button>
                                    </div>
                                    <?php if (!empty($supportError)): ?>
                                        <div class="alert alert-danger"><?php echo e($supportError); ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($supportSuccess)): ?>
                                        <div class="alert alert-success"><?php echo e($supportSuccess); ?></div>
                                    <?php endif; ?>
                                    <div class="row g-3">
                                        <div class="col-lg-4">
                                            <div class="card border-0 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="collapse mb-3" id="portalNewTicket">
                                                        <div class="card card-body border">
                                                            <form method="post" action="index.php?route=clients/portal/tickets/create&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>#portal-support">
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
                                                    <h6 class="fw-semibold mb-3">Mis tickets</h6>
                                                    <?php if (!empty($supportTickets)): ?>
                                                        <div class="list-group list-group-flush">
                                                            <?php foreach ($supportTickets as $ticket): ?>
                                                                <?php $isActiveTicket = (int)$ticket['id'] === (int)($activeSupportTicketId ?? 0); ?>
                                                                <a href="index.php?route=clients/portal&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>&ticket=<?php echo (int)$ticket['id']; ?>#portal-support" class="list-group-item list-group-item-action <?php echo $isActiveTicket ? 'active' : ''; ?>">
                                                                    <div class="fw-semibold">#<?php echo (int)$ticket['id']; ?> · <?php echo e($ticket['subject'] ?? 'Ticket'); ?></div>
                                                                    <div class="text-muted fs-xs <?php echo $isActiveTicket ? 'text-white-50' : ''; ?>">
                                                                        Estado: <?php echo e(str_replace('_', ' ', $ticket['status'] ?? 'abierto')); ?>
                                                                    </div>
                                                                </a>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="text-muted fs-sm">Aún no has generado tickets de soporte.</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="card border-0 shadow-sm h-100">
                                                <div class="card-body d-flex flex-column">
                                                    <?php if (!empty($activeSupportTicket)): ?>
                                                        <div class="d-flex align-items-start justify-content-between border-bottom pb-3 mb-3">
                                                            <div>
                                                                <h6 class="fw-semibold mb-1">Ticket #<?php echo (int)$activeSupportTicket['id']; ?> · <?php echo e($activeSupportTicket['subject'] ?? ''); ?></h6>
                                                                <div class="text-muted fs-xs">Estado: <?php echo e(str_replace('_', ' ', $activeSupportTicket['status'] ?? 'abierto')); ?></div>
                                                            </div>
                                                            <span class="badge bg-info-subtle text-info text-uppercase"><?php echo e($activeSupportTicket['priority'] ?? 'media'); ?></span>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-auto mb-3" style="max-height: 420px;">
                                                            <?php if (!empty($supportMessages)): ?>
                                                                <?php foreach ($supportMessages as $message): ?>
                                                                    <?php
                                                                    $isClient = ($message['sender_type'] ?? '') === 'client';
                                                                    $bubbleClasses = $isClient ? 'bg-primary text-white ms-auto' : 'bg-light';
                                                                    ?>
                                                                    <div class="d-flex mb-3 <?php echo $isClient ? 'justify-content-end' : 'justify-content-start'; ?>">
                                                                        <?php if (!$isClient): ?>
                                                                            <?php if (!empty($message['sender_avatar'])): ?>
                                                                                <img src="<?php echo e($message['sender_avatar']); ?>" alt="Avatar" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover;">
                                                                            <?php else: ?>
                                                                                <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                                                                    <?php echo e(strtoupper(substr($message['sender_name'] ?? 'E', 0, 1))); ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                        <div class="p-3 rounded-3 <?php echo $bubbleClasses; ?>" style="max-width: 75%;">
                                                                            <div class="fw-semibold mb-1"><?php echo e($message['sender_name'] ?? ($isClient ? 'Tú' : 'Soporte')); ?></div>
                                                                            <div><?php echo nl2br(e($message['message'] ?? '')); ?></div>
                                                                            <?php if (!empty($message['created_at'])): ?>
                                                                                <div class="fs-xxs mt-2 <?php echo $isClient ? 'text-white-50' : 'text-muted'; ?>">
                                                                                    <?php echo e($message['created_at']); ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <?php if ($isClient): ?>
                                                                            <?php if (!empty($message['sender_avatar'])): ?>
                                                                                <img src="<?php echo e($message['sender_avatar']); ?>" alt="Avatar" class="rounded-circle ms-2" style="width: 36px; height: 36px; object-fit: cover;">
                                                                            <?php else: ?>
                                                                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center ms-2" style="width: 36px; height: 36px;">
                                                                                    <?php echo e(strtoupper(substr($message['sender_name'] ?? 'T', 0, 1))); ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <div class="text-muted">Sin mensajes aún.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <form method="post" action="index.php?route=clients/portal/tickets/message&token=<?php echo urlencode($client['portal_token'] ?? ''); ?>#portal-support">
                                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="ticket_id" value="<?php echo (int)($activeSupportTicketId ?? 0); ?>">
                                                            <div class="mb-2">
                                                                <textarea name="message" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                                                            </div>
                                                        </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const activatePortalTab = (target) => {
            if (!target) {
                return;
            }
            const tabTrigger = document.querySelector(`a[href="${target}"]`);
            if (!tabTrigger) {
                return;
            }
            tabTrigger.click();
        };

        window.addEventListener('load', () => {
            document.querySelectorAll('[data-portal-tab]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const target = link.getAttribute('data-portal-tab');
                    if (target) {
                        localStorage.setItem('portalActiveTab', target);
                        history.replaceState(null, '', target);
                    }
                    activatePortalTab(target);
                });
            });
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach((link) => {
                link.addEventListener('shown.bs.tab', () => {
                    const target = link.getAttribute('href');
                    if (target) {
                        localStorage.setItem('portalActiveTab', target);
                        history.replaceState(null, '', target);
                    }
                });
            });
            const storedTab = localStorage.getItem('portalActiveTab');
            const initialTab = window.location.hash || storedTab;
            if (initialTab) {
                activatePortalTab(initialTab);
            }

            document.querySelectorAll('#portal-support a[href*="#portal-support"]').forEach((link) => {
                link.addEventListener('click', () => {
                    localStorage.setItem('portalActiveTab', '#portal-support');
                });
            });

            document.querySelectorAll('#portal-support form').forEach((form) => {
                form.addEventListener('submit', () => {
                    localStorage.setItem('portalActiveTab', '#portal-support');
                });
            });

        });
    </script>
<?php endif; ?>
