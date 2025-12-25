<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Cola de correos</h4>
        <a href="index.php?route=email-queue/compose" class="btn btn-primary">Nuevo correo</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Asunto</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Programado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emails as $email): ?>
                        <tr>
                            <td><?php echo e($email['client_name'] ?? ''); ?></td>
                            <td><?php echo e($email['subject']); ?></td>
                            <td><?php echo e($email['type']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $email['status'] === 'sent' ? 'success' : ($email['status'] === 'failed' ? 'danger' : 'warning'); ?>-subtle text-<?php echo $email['status'] === 'sent' ? 'success' : ($email['status'] === 'failed' ? 'danger' : 'warning'); ?>">
                                    <?php echo e($email['status']); ?>
                                </span>
                            </td>
                            <td><?php echo e($email['scheduled_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
