<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Boletas de honorarios</h4>
    <a href="index.php?route=honorarios/create" class="btn btn-primary">Nueva boleta</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>RUT</th>
                        <th>Documento</th>
                        <th>Fecha</th>
                        <th>Bruto</th>
                        <th>Retención</th>
                        <th>Neto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr>
                            <td><?php echo e($doc['provider_name']); ?></td>
                            <td><?php echo e($doc['provider_rut']); ?></td>
                            <td><?php echo e($doc['document_number']); ?></td>
                            <td><?php echo e(format_date($doc['issue_date'] ?? null)); ?></td>
                            <td><?php echo e(format_currency((float)($doc['gross_amount'] ?? 0))); ?></td>
                            <td><?php echo e(format_currency((float)($doc['retention_amount'] ?? 0))); ?></td>
                            <td><?php echo e(format_currency((float)($doc['net_amount'] ?? 0))); ?></td>
                            <td class="text-capitalize"><?php echo e($doc['status'] ?? 'pendiente'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($documents)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay boletas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
