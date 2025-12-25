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
                        <th>Días faltantes</th>
                        <th>Programado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emails as $email): ?>
                        <?php
                        $scheduledAt = new DateTime($email['scheduled_at']);
                        $now = new DateTime();
                        $daysDiff = (int)$now->diff($scheduledAt)->format('%r%a');
                        $daysLabel = $daysDiff <= 0 ? 'Vencido' : $daysDiff . ' días';
                        if ($daysDiff <= 0) {
                            $daysBadge = 'danger';
                        } elseif ($daysDiff <= 15) {
                            $daysBadge = 'warning';
                        } else {
                            $daysBadge = 'secondary';
                        }
                        ?>
                        <tr>
                            <td><?php echo e($email['client_name'] ?? ''); ?></td>
                            <td><?php echo e($email['subject']); ?></td>
                            <td><?php echo e($email['type']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $email['status'] === 'sent' ? 'success' : ($email['status'] === 'failed' ? 'danger' : 'warning'); ?>-subtle text-<?php echo $email['status'] === 'sent' ? 'success' : ($email['status'] === 'failed' ? 'danger' : 'warning'); ?>">
                                    <?php echo e($email['status']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $daysBadge; ?>-subtle text-<?php echo $daysBadge; ?>">
                                    <?php echo e($daysLabel); ?>
                                </span>
                            </td>
                            <td><?php echo e($email['scheduled_at']); ?></td>
                            <td>
                                <?php if ($email['status'] !== 'sent'): ?>
                                    <form method="post" action="index.php?route=email-queue/send" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" value="<?php echo (int)$email['id']; ?>">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Enviar ahora</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Enviado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
