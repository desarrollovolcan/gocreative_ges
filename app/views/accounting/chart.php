<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Plan de cuentas</h4>
    <a href="index.php?route=accounting/chart/create" class="btn btn-primary">Nueva cuenta</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Nivel</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?php echo e($account['code']); ?></td>
                            <td><?php echo e($account['name']); ?></td>
                            <td class="text-capitalize"><?php echo e($account['type']); ?></td>
                            <td><?php echo (int)($account['level'] ?? 1); ?></td>
                            <td><?php echo !empty($account['is_active']) ? 'Activa' : 'Inactiva'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($accounts)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay cuentas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
