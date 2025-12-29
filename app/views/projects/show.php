<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0"><?php echo e($project['name']); ?></h4>
    </div>
    <div class="card-body">
        <p class="text-muted"><?php echo e($project['description']); ?></p>
        <div class="row">
            <div class="col-md-4"><strong>Estado:</strong> <?php echo e($project['status']); ?></div>
            <div class="col-md-4"><strong>Inicio:</strong> <?php echo e($project['start_date']); ?></div>
            <div class="col-md-4"><strong>Entrega:</strong> <?php echo e($project['delivery_date']); ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><strong>Mandante:</strong> <?php echo e($project['mandante_name'] ?? '-'); ?></div>
            <div class="col-md-6"><strong>Mandante RUT:</strong> <?php echo e($project['mandante_rut'] ?? '-'); ?></div>
            <div class="col-md-6"><strong>Mandante Teléfono:</strong> <?php echo e($project['mandante_phone'] ?? '-'); ?></div>
            <div class="col-md-6"><strong>Mandante Correo:</strong> <?php echo e($project['mandante_email'] ?? '-'); ?></div>
        </div>
    </div>
</div>

<?php
$tasksTotal = count($checklist ?? []);
$tasksProgress = array_sum(array_map(static fn(array $task) => (int)($task['progress_percent'] ?? 0), $checklist ?? []));
$overallProgress = (int)min(100, round($tasksProgress));
$completedTasks = count(array_filter($checklist ?? [], static fn(array $task) => (int)($task['progress_percent'] ?? 0) >= 100));
$remainingProgress = max(0, 100 - $overallProgress);
?>

<div class="card" id="tareas">
    <div class="card-header"><h4 class="card-title mb-0">Control de avances</h4></div>
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="p-3 rounded bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="text-muted fs-xs">Avance general</div>
                            <div class="fw-semibold fs-4"><?php echo $overallProgress; ?>%</div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary">Tareas: <?php echo $completedTasks; ?>/<?php echo $tasksTotal; ?></span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $overallProgress; ?>%"></div>
                    </div>
                    <div class="d-flex justify-content-between fs-xs text-muted mt-2">
                        <span>Progreso acumulado</span>
                        <span>Restante <?php echo $remainingProgress; ?>%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form method="post" action="index.php?route=projects/tasks/store" class="row g-2 align-items-end">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="project_id" value="<?php echo (int)$project['id']; ?>">
                    <div class="col-12">
                        <label class="form-label">Nueva tarea</label>
                        <input type="text" name="title" class="form-control" placeholder="Ej: Diseño de interfaz" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Inicio</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Entrega</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Avance (%)</label>
                        <input type="number" name="progress_percent" class="form-control" min="0" max="100" step="1" value="0" required>
                    </div>
                    <div class="col-12 d-grid">
                        <button type="submit" class="btn btn-primary">Agregar tarea</button>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">El avance total del proyecto se calcula sumando los porcentajes de cada tarea (máximo 100%).</small>
                    </div>
                </form>
            </div>
        </div>

        <h5 class="mb-3">Tareas del proyecto</h5>
        <?php if (!empty($checklist)): ?>
            <ul class="list-group">
                <?php foreach ($checklist as $task): ?>
                    <?php
                    $taskProgress = (int)($task['progress_percent'] ?? 0);
                    $taskStartDate = $task['start_date'] ?? '';
                    $taskEndDate = $task['end_date'] ?? '';
                    ?>
                    <li class="list-group-item">
                        <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center">
                            <div class="flex-grow-1">
                                <form method="post" action="index.php?route=projects/tasks/update" class="row g-2 align-items-center">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="project_id" value="<?php echo (int)$project['id']; ?>">
                                    <input type="hidden" name="task_id" value="<?php echo (int)$task['id']; ?>">
                                    <div class="col-lg-4">
                                        <input type="text" name="title" class="form-control" value="<?php echo e($task['title']); ?>" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="date" name="start_date" class="form-control" value="<?php echo e($taskStartDate); ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="date" name="end_date" class="form-control" value="<?php echo e($taskEndDate); ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="number" name="progress_percent" class="form-control" min="0" max="100" step="1" value="<?php echo $taskProgress; ?>" required>
                                    </div>
                                    <div class="col-lg-12 d-grid">
                                        <button type="submit" class="btn btn-soft-primary btn-sm">Guardar</button>
                                    </div>
                                </form>
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between fs-xs text-muted">
                                        <span>Avance actual</span>
                                        <span><?php echo $taskProgress; ?>%</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar <?php echo $taskProgress >= 100 ? 'bg-success' : 'bg-warning'; ?>" role="progressbar" style="width: <?php echo min(100, $taskProgress); ?>%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between fs-xs text-muted mt-2">
                                        <span>Inicio: <?php echo e($taskStartDate !== '' ? $taskStartDate : 'Por definir'); ?></span>
                                        <span>Entrega: <?php echo e($taskEndDate !== '' ? $taskEndDate : 'Por definir'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-lg-end">
                                <span class="badge bg-<?php echo $taskProgress >= 100 ? 'success' : 'secondary'; ?>-subtle text-<?php echo $taskProgress >= 100 ? 'success' : 'secondary'; ?>">
                                    <?php echo $taskProgress >= 100 ? 'Completada' : 'En progreso'; ?>
                                </span>
                                <form method="post" action="index.php?route=projects/tasks/delete" class="mt-2">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="project_id" value="<?php echo (int)$project['id']; ?>">
                                    <input type="hidden" name="task_id" value="<?php echo (int)$task['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-muted">Aún no hay tareas registradas para este proyecto.</div>
        <?php endif; ?>
    </div>
</div>
