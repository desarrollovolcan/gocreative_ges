<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Cotización <?php echo e($quote['numero']); ?></h4>
        <a href="index.php?route=quotes" class="btn btn-light btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Cliente:</strong> <?php echo e($client['name'] ?? ''); ?></p>
                <p><strong>Emisión:</strong> <?php echo e($quote['fecha_emision']); ?></p>
                <p><strong>Estado:</strong> <?php echo e($quote['estado']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Subtotal:</strong> <?php echo e(format_currency((float)($quote['subtotal'] ?? 0))); ?></p>
                <p><strong>Impuestos:</strong> <?php echo e(format_currency((float)($quote['impuestos'] ?? 0))); ?></p>
                <p><strong>Total:</strong> <?php echo e(format_currency((float)($quote['total'] ?? 0))); ?></p>
            </div>
        </div>
        <?php if (!empty($quote['notas'])): ?>
            <p><strong>Notas:</strong> <?php echo e($quote['notas']); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Items</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo e($item['descripcion']); ?></td>
                            <td><?php echo e($item['cantidad']); ?></td>
                            <td><?php echo e(format_currency((float)($item['precio_unitario'] ?? 0))); ?></td>
                            <td><?php echo e(format_currency((float)($item['total'] ?? 0))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
