<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Cotizaciones</h4>
        <a href="index.php?route=quotes/create" class="btn btn-primary">Nueva cotización</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Emisión</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quotes as $quote): ?>
                        <tr>
                            <td><?php echo e($quote['numero']); ?></td>
                            <td><?php echo e($quote['client_name']); ?></td>
                            <td><?php echo e($quote['fecha_emision']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $quote['estado'] === 'aceptada' ? 'success' : ($quote['estado'] === 'rechazada' ? 'danger' : 'warning'); ?>-subtle text-<?php echo $quote['estado'] === 'aceptada' ? 'success' : ($quote['estado'] === 'rechazada' ? 'danger' : 'warning'); ?>">
                                    <?php echo e($quote['estado']); ?>
                                </span>
                            </td>
                            <td class="text-end"><?php echo e(format_currency((float)($quote['total'] ?? 0))); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=quotes/show&id=<?php echo $quote['id']; ?>" class="btn btn-light btn-sm">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
