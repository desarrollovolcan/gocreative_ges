<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h4 class="card-title mb-0">Comunas y ciudades</h4>
            <small class="text-muted">Listado oficial de comunas, ciudades y regiones de Chile.</small>
        </div>
        <span class="badge bg-soft-primary text-primary align-self-start align-self-md-center">
            <?php echo count($communes); ?> registros
        </span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Comuna</th>
                        <th>Ciudad</th>
                        <th>Región</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($communes)): ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center">No hay comunas disponibles.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($communes as $commune): ?>
                            <tr>
                                <td><?php echo e($commune['commune'] ?? ''); ?></td>
                                <td><?php echo e($commune['city'] ?? ''); ?></td>
                                <td><?php echo e($commune['region'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
