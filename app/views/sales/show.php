<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Venta <?php echo e($sale['numero'] ?? '#'); ?></h4>
                    <span class="text-muted">Canal: <?php echo e(strtoupper($sale['channel'] ?? 'venta')); ?></span>
                </div>
                <a href="index.php?route=sales" class="btn btn-soft-secondary btn-sm">Volver</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Cliente:</strong> <?php echo e($sale['client_name'] ?? 'Consumidor final'); ?></p>
                        <p class="mb-1"><strong>Fecha:</strong> <?php echo e(format_date($sale['sale_date'] ?? null)); ?></p>
                        <p class="mb-1"><strong>Estado:</strong>
                            <?php
                            $status = $sale['status'] ?? 'pagado';
                            $statusColor = match ($status) {
                                'pagado' => 'success',
                                'pendiente' => 'warning',
                                'borrador' => 'secondary',
                                default => 'info',
                            };
                            ?>
                            <span class="badge bg-<?php echo $statusColor; ?>-subtle text-<?php echo $statusColor; ?>"><?php echo e($status); ?></span>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Subtotal:</strong> <?php echo e(format_currency((float)($sale['subtotal'] ?? 0))); ?></p>
                        <p class="mb-1"><strong>Impuestos:</strong> <?php echo e(format_currency((float)($sale['tax'] ?? 0))); ?></p>
                        <p class="mb-1"><strong>Total:</strong> <?php echo e(format_currency((float)($sale['total'] ?? 0))); ?></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th class="text-end">Precio unitario</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?php echo e($item['product_name'] ?? 'Producto eliminado'); ?></td>
                                    <td><?php echo (int)($item['quantity'] ?? 0); ?></td>
                                    <td class="text-end"><?php echo e(format_currency((float)($item['unit_price'] ?? 0))); ?></td>
                                    <td class="text-end"><?php echo e(format_currency((float)($item['subtotal'] ?? 0))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($sale['notes'])): ?>
                    <div class="alert alert-info mt-3 mb-0">
                        <strong>Notas:</strong> <?php echo nl2br(e($sale['notes'] ?? '')); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
