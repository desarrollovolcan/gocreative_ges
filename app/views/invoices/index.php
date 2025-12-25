<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Facturas</h4>
        <div class="d-flex gap-2">
            <a href="index.php?route=invoices/export" class="btn btn-outline-secondary">Exportar CSV</a>
            <a href="index.php?route=invoices/create" class="btn btn-primary">Nueva factura</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Emisión</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?php echo e($invoice['numero']); ?></td>
                            <td><?php echo e($invoice['client_name']); ?></td>
                            <td><?php echo e($invoice['fecha_emision']); ?></td>
                            <td><?php echo e($invoice['fecha_vencimiento']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $invoice['estado'] === 'pagada' ? 'success' : ($invoice['estado'] === 'vencida' ? 'danger' : 'warning'); ?>-subtle text-<?php echo $invoice['estado'] === 'pagada' ? 'success' : ($invoice['estado'] === 'vencida' ? 'danger' : 'warning'); ?>">
                                    <?php echo e($invoice['estado']); ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="index.php?route=invoices/show&id=<?php echo $invoice['id']; ?>" class="btn btn-light btn-sm">Ver</a>
                                <form method="post" action="index.php?route=invoices/delete" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $invoice['id']; ?>">
                                    <button type="submit" class="btn btn-soft-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
