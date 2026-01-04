<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Activos fijos</h4>
    <a href="index.php?route=fixed-assets/create" class="btn btn-primary">Nuevo activo</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Activo</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                        <th>Valor</th>
                        <th>Depreciación acumulada</th>
                        <th>Valor libro</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td><?php echo e($asset['name']); ?></td>
                            <td><?php echo e($asset['category']); ?></td>
                            <td><?php echo e(format_date($asset['acquisition_date'] ?? null)); ?></td>
                            <td><?php echo e(format_currency((float)($asset['acquisition_value'] ?? 0))); ?></td>
                            <td><?php echo e(format_currency((float)($asset['accumulated_depreciation'] ?? 0))); ?></td>
                            <td><?php echo e(format_currency((float)($asset['book_value'] ?? 0))); ?></td>
                            <td class="text-capitalize"><?php echo e($asset['status'] ?? 'activo'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($assets)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay activos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
