<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Compra #<?php echo (int)($purchase['id'] ?? 0); ?></h4>
                    <span class="text-muted">Referencia: <?php echo e($purchase['reference'] ?? '-'); ?></span>
                </div>
                <a href="index.php?route=purchases" class="btn btn-soft-secondary btn-sm">Volver</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Proveedor:</strong> <?php echo e($purchase['supplier_name'] ?? ''); ?></p>
                        <p class="mb-1"><strong>Fecha:</strong> <?php echo e(format_date($purchase['purchase_date'] ?? null)); ?></p>
                        <p class="mb-1"><strong>Estado:</strong>
                            <?php
                            $status = $purchase['status'] ?? 'pendiente';
                            $statusColor = match ($status) {
                                'completada', 'recibida' => 'success',
                                'pendiente' => 'warning',
                                default => 'secondary',
                            };
                            ?>
                            <span class="badge bg-<?php echo $statusColor; ?>-subtle text-<?php echo $statusColor; ?>"><?php echo e($status); ?></span>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Subtotal:</strong> <?php echo e(format_currency((float)($purchase['subtotal'] ?? 0))); ?></p>
                        <p class="mb-1"><strong>Impuestos:</strong> <?php echo e(format_currency((float)($purchase['tax'] ?? 0))); ?></p>
                        <p class="mb-1"><strong>Total:</strong> <?php echo e(format_currency((float)($purchase['total'] ?? 0))); ?></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th class="text-end">Costo unitario</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?php echo e($item['product_name'] ?? 'Producto eliminado'); ?></td>
                                    <td><?php echo (int)($item['quantity'] ?? 0); ?></td>
                                    <td class="text-end"><?php echo e(format_currency((float)($item['unit_cost'] ?? 0))); ?></td>
                                    <td class="text-end"><?php echo e(format_currency((float)($item['subtotal'] ?? 0))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($purchase['notes'])): ?>
                    <div class="alert alert-info mt-3 mb-0">
                        <strong>Notas:</strong> <?php echo nl2br(e($purchase['notes'] ?? '')); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
