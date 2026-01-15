<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h4 class="card-title mb-0">Actividades SII</h4>
            <small class="text-muted">Catálogo oficial de actividades económicas.</small>
        </div>
        <span class="badge bg-soft-primary text-primary align-self-start align-self-md-center">
            <?php echo count($activities); ?> registros
        </span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th style="width: 140px;">Código</th>
                        <th>Actividad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($activities)): ?>
                        <tr>
                            <td colspan="2" class="text-muted text-center">No hay actividades disponibles.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($activities as $activity): ?>
                            <tr>
                                <td><?php echo e($activity['code'] ?? ''); ?></td>
                                <td><?php echo e($activity['name'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
