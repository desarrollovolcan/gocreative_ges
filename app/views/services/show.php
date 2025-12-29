<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0"><?php echo e($service['name']); ?></h4>
        <span class="badge bg-<?php echo $service['status'] === 'activo' ? 'success' : 'secondary'; ?>-subtle text-<?php echo $service['status'] === 'activo' ? 'success' : 'secondary'; ?>">
            <?php echo e($service['status']); ?>
        </span>
    </div>
    <div class="card-body">
        <p><strong>Cliente:</strong> <?php echo e($client['name'] ?? ''); ?></p>
        <p><strong>Tipo:</strong> <?php echo e($service['service_type']); ?></p>
        <p><strong>Costo:</strong> <?php echo e(format_currency((float)($service['cost'] ?? 0))); ?></p>
        <p><strong>Vencimiento:</strong> <?php echo e($service['due_date']); ?></p>
        <p><strong>Auto facturar:</strong> <?php echo $service['auto_invoice'] ? 'Sí' : 'No'; ?></p>
        <p><strong>Auto correo:</strong> <?php echo $service['auto_email'] ? 'Sí' : 'No'; ?></p>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title mb-0">Facturas generadas</h4></div>
    <div class="card-body">
        <ul class="list-group">
            <?php foreach ($invoices as $invoice): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo e($invoice['numero']); ?>
                    <span class="badge bg-light text-dark"><?php echo e($invoice['estado']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
