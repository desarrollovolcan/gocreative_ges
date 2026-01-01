<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="card-title mb-1">Historial de cliente</h4>
            <p class="text-muted mb-0">Revisa servicios, proyectos, renovaciones, tickets e ingresos del cliente.</p>
        </div>
        <a href="index.php?route=clients/show&id=<?php echo (int)$client['id']; ?>" class="btn btn-light">Volver al cliente</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Servicios</h5>
                <a href="index.php?route=services/create&client_id=<?php echo (int)$client['id']; ?>" class="btn btn-sm btn-primary">Nuevo</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Vence</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($services)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-3">Sin servicios.</td></tr>
                            <?php else: ?>
                                <?php foreach ($services as $service): ?>
                                    <?php
                                        $status = $service['status'] ?? 'activo';
                                        $statusColor = match ($status) {
                                            'activo' => 'success',
                                            'vencido' => 'danger',
                                            'renovado' => 'primary',
                                            default => 'secondary',
                                        };
                                    ?>
                                    <tr>
                                        <td class="text-muted">#<?php echo (int)($service['id'] ?? 0); ?></td>
                                        <td><?php echo e($service['name'] ?? ''); ?></td>
                                        <td><?php echo e($service['service_type'] ?? ''); ?></td>
                                        <td><?php echo e(format_date($service['due_date'] ?? '')); ?></td>
                                        <td><span class="badge bg-<?php echo $statusColor; ?>-subtle text-<?php echo $statusColor; ?>"><?php echo e($status); ?></span></td>
                                        <td class="text-end">
                                            <a href="index.php?route=services/show&id=<?php echo (int)$service['id']; ?>" class="btn btn-soft-primary btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Proyectos</h5>
                <a href="index.php?route=projects/create&client_id=<?php echo (int)$client['id']; ?>" class="btn btn-sm btn-primary">Nuevo</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Entrega</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($projects)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Sin proyectos.</td></tr>
                            <?php else: ?>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td class="text-muted">#<?php echo (int)($project['id'] ?? 0); ?></td>
                                        <td><?php echo e($project['name'] ?? ''); ?></td>
                                        <td><?php echo e($project['status'] ?? ''); ?></td>
                                        <td><?php echo e(format_date($project['due_date'] ?? '')); ?></td>
                                        <td class="text-end">
                                            <a href="index.php?route=projects/show&id=<?php echo (int)$project['id']; ?>" class="btn btn-soft-primary btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Renovaciones</h5>
                <a href="index.php?route=crm/renewals" class="btn btn-sm btn-primary">Ir a renovaciones</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="text-end">Monto</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($renewals)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Sin renovaciones.</td></tr>
                            <?php else: ?>
                                <?php foreach ($renewals as $renewal): ?>
                                    <tr>
                                        <td class="text-muted">#<?php echo (int)($renewal['id'] ?? 0); ?></td>
                                        <td><?php echo e(format_date($renewal['renewal_date'] ?? '')); ?></td>
                                        <td><?php echo e(str_replace('_', ' ', $renewal['status'] ?? '')); ?></td>
                                        <td class="text-end"><?php echo e(format_currency((float)($renewal['amount'] ?? 0))); ?></td>
                                        <td class="text-end">
                                            <a href="index.php?route=crm/renewals" class="btn btn-soft-primary btn-sm">Abrir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tickets</h5>
                <a href="index.php?route=tickets/create&client_id=<?php echo (int)$client['id']; ?>" class="btn btn-sm btn-primary">Nuevo</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Asunto</th>
                                <th>Estado</th>
                                <th>Prioridad</th>
                                <th class="text-end">Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tickets)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Sin tickets.</td></tr>
                            <?php else: ?>
                                <?php foreach ($tickets as $ticket): ?>
                                    <tr>
                                        <td class="text-muted">#<?php echo (int)($ticket['id'] ?? 0); ?></td>
                                        <td><?php echo e($ticket['subject'] ?? ''); ?></td>
                                        <td><?php echo e($ticket['status'] ?? ''); ?></td>
                                        <td><?php echo e($ticket['priority'] ?? ''); ?></td>
                                        <td class="text-end"><?php echo e(format_date(substr($ticket['created_at'] ?? '', 0, 10))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Facturas</h5>
                <a href="index.php?route=invoices/create&client_id=<?php echo (int)$client['id']; ?>" class="btn btn-sm btn-primary">Nueva</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Estado</th>
                                <th class="text-end">Total</th>
                                <th>Emisión</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($invoices)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-3">Sin facturas.</td></tr>
                            <?php else: ?>
                                <?php foreach ($invoices as $invoice): ?>
                                    <tr>
                                        <td class="text-muted">#<?php echo (int)($invoice['id'] ?? 0); ?></td>
                                        <td><?php echo e($invoice['estado'] ?? ''); ?></td>
                                        <td class="text-end"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
                                        <td><?php echo e(format_date($invoice['fecha_emision'] ?? '')); ?></td>
                                        <td class="text-end">
                                            <a href="index.php?route=invoices/show&id=<?php echo (int)$invoice['id']; ?>" class="btn btn-soft-primary btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
