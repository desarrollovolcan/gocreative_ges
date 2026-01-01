<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="card-title mb-1">Historial de actividades</h4>
            <p class="text-muted mb-0">Selecciona un cliente para revisar todo su historial reciente.</p>
        </div>
        <form class="d-flex gap-2 align-items-center" method="get" action="index.php">
            <input type="hidden" name="route" value="clients/history">
            <select name="id" class="form-select" style="min-width: 240px;" required>
                <option value="">Selecciona un cliente</option>
                <?php foreach ($clients as $item): ?>
                    <option value="<?php echo (int)$item['id']; ?>" <?php echo (int)$selectedClientId === (int)$item['id'] ? 'selected' : ''; ?>>
                        <?php echo e($item['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Ver historial</button>
        </form>
    </div>
</div>

<?php if ($client): ?>
    <div class="card mb-3">
        <div class="card-body d-flex flex-wrap gap-3 align-items-center justify-content-between">
            <div>
                <h5 class="mb-1"><?php echo e($client['name'] ?? ''); ?></h5>
                <p class="mb-0 text-muted">
                    <?php echo e($client['email'] ?? ''); ?>
                    <?php if (!empty($client['phone'])): ?>
                        · <?php echo e($client['phone']); ?>
                    <?php endif; ?>
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?route=clients/show&id=<?php echo (int)$client['id']; ?>" class="btn btn-soft-primary btn-sm">Ver cliente</a>
                <a href="index.php?route=clients/edit&id=<?php echo (int)$client['id']; ?>" class="btn btn-soft-secondary btn-sm">Editar</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($activities)): ?>
                <div class="text-center py-4 text-muted">Sin actividades recientes para este cliente.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Fecha</th>
                                <th>Actividad</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                                <?php
                                    $status = $activity['status'] ?? '';
                                    $statusColor = match (strtolower($status)) {
                                        'activo', 'abierto', 'pagado', 'en progreso' => 'success',
                                        'cerrado', 'vencido', 'cancelado' => 'danger',
                                        'pendiente', 'borrador' => 'warning',
                                        default => 'secondary',
                                    };
                                ?>
                                <tr>
                                    <td class="text-muted text-nowrap"><?php echo e(format_date(substr((string)($activity['date'] ?? ''), 0, 10))); ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="badge bg-light text-muted border"><?php echo e($activity['type'] ?? ''); ?></span>
                                                <span class="fw-semibold"><?php echo e($activity['title'] ?? ''); ?></span>
                                            </div>
                                            <?php if (!empty($activity['meta'])): ?>
                                                <small class="text-muted d-block mt-1"><?php echo e($activity['meta']); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php echo e($activity['client'] ?? ''); ?></td>
                                    <td><span class="badge bg-<?php echo $statusColor; ?>-subtle text-<?php echo $statusColor; ?>"><?php echo e($status !== '' ? $status : 'N/A'); ?></span></td>
                                    <td class="text-end">
                                        <?php if (!empty($activity['url'])): ?>
                                            <a href="<?php echo e($activity['url']); ?>" class="btn btn-soft-primary btn-sm">Ver</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <p class="text-muted mb-2">Selecciona un cliente para ver su historial.</p>
            <p class="mb-0"><i class="ti ti-history fs-1 text-muted"></i></p>
        </div>
    </div>
<?php endif; ?>
