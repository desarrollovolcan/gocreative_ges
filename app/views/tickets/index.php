<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo e($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Tickets de soporte</h4>
        <a href="index.php?route=tickets/create" class="btn btn-primary btn-sm">Nuevo ticket</a>
    </div>
    <div class="card-body">
        <?php if (!empty($tickets)): ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Actualizado</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td><?php echo (int)$ticket['id']; ?></td>
                                <td><?php echo e($ticket['client_name'] ?? ''); ?></td>
                                <td><?php echo e($ticket['subject'] ?? ''); ?></td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        <?php echo e(str_replace('_', ' ', $ticket['status'] ?? 'abierto')); ?>
                                    </span>
                                </td>
                                <td><?php echo e(ucfirst($ticket['priority'] ?? 'media')); ?></td>
                                <td><?php echo e($ticket['updated_at'] ?? ''); ?></td>
                                <td class="text-end">
                                    <a href="index.php?route=tickets/show&id=<?php echo (int)$ticket['id']; ?>" class="btn btn-light btn-sm">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-muted">No hay tickets registrados.</div>
        <?php endif; ?>
    </div>
</div>
