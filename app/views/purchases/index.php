<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Compras registradas</h4>
        <a href="index.php?route=purchases/create" class="btn btn-primary">Registrar compra</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Referencia</th>
                        <th>Proveedor</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchases as $purchase): ?>
                        <?php
                        $status = $purchase['status'] ?? 'pendiente';
                        $statusColor = match ($status) {
                            'completada', 'recibida' => 'success',
                            'pendiente' => 'warning',
                            default => 'secondary',
                        };
                        ?>
                        <tr>
                            <td class="text-muted"><?php echo render_id_badge($purchase['id'] ?? null, 'Compra'); ?></td>
                            <td><?php echo e($purchase['reference'] ?? '-'); ?></td>
                            <td><?php echo e($purchase['supplier_name'] ?? ''); ?></td>
                            <td><?php echo e(format_date($purchase['purchase_date'] ?? null)); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $statusColor; ?>-subtle text-<?php echo $statusColor; ?>">
                                    <?php echo e($status); ?>
                                </span>
                            </td>
                            <td class="text-end"><?php echo e(format_currency((float)($purchase['total'] ?? 0))); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=purchases/show&id=<?php echo (int)$purchase['id']; ?>" class="btn btn-soft-primary btn-sm">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
