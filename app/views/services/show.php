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
        <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="index.php?route=clients/show&id=<?php echo (int)($client['id'] ?? 0); ?>" class="btn btn-outline-primary btn-sm">Ver cliente</a>
            <a href="index.php?route=invoices/create&service_id=<?php echo (int)$service['id']; ?>&client_id=<?php echo (int)($client['id'] ?? 0); ?>" class="btn btn-outline-success btn-sm">Crear factura</a>
            <a href="index.php?route=tickets/create&client_id=<?php echo (int)($client['id'] ?? 0); ?>" class="btn btn-outline-warning btn-sm">Abrir ticket</a>
        </div>
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
