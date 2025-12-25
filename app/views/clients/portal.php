<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo e($error); ?></div>
<?php else: ?>
    <div class="row g-4 mb-4">
        <div class="col-xl-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="avatar-lg bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ti ti-briefcase fs-24"></i>
                        </div>
                        <div>
                            <h5 class="mb-1"><?php echo e($client['name'] ?? ''); ?></h5>
                            <div class="text-muted">Rut: <?php echo e($client['rut'] ?? '-'); ?></div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Correo</span>
                            <span class="fw-medium"><?php echo e($client['email'] ?? '-'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Teléfono</span>
                            <span class="fw-medium"><?php echo e($client['phone'] ?? '-'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Mandante</span>
                            <span class="fw-medium"><?php echo e($client['mandante_name'] ?? '-'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Facturas pendientes</h6>
                    <?php if (!empty($pendingInvoices)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($pendingInvoices as $invoice): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold">#<?php echo e($invoice['numero']); ?></div>
                                            <div class="text-muted fs-xs">Vence: <?php echo e($invoice['fecha_vencimiento']); ?></div>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-semibold">$<?php echo e($invoice['total']); ?></div>
                                            <span class="badge bg-warning-subtle text-warning"><?php echo e($invoice['estado']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">No hay facturas pendientes.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Actividades recientes</h5>
                    <span class="badge bg-primary-subtle text-primary"><?php echo count($activities ?? []); ?> actividades</span>
                </div>
                <div class="card-body">
                    <?php if (!empty($activities)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Proyecto</th>
                                        <th>Actividad</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($activities as $activity): ?>
                                        <tr>
                                            <td><?php echo e($activity['project_name'] ?? '-'); ?></td>
                                            <td><?php echo e($activity['title'] ?? '-'); ?></td>
                                            <td>
                                                <?php if (!empty($activity['completed'])): ?>
                                                    <span class="badge bg-success-subtle text-success">Completada</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary-subtle text-secondary">En progreso</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($activity['created_at'] ?? '-'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">No hay actividades registradas.</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Pagos registrados</h5>
                    <span class="badge bg-success-subtle text-success"><?php echo count($payments ?? []); ?> pagos</span>
                </div>
                <div class="card-body">
                    <?php if (!empty($payments)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Factura</th>
                                        <th>Monto</th>
                                        <th>Fecha pago</th>
                                        <th>Método</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <td>#<?php echo e($payment['invoice_number'] ?? $payment['invoice_id']); ?></td>
                                            <td>$<?php echo e($payment['monto'] ?? ''); ?></td>
                                            <td><?php echo e($payment['fecha_pago'] ?? '-'); ?></td>
                                            <td><?php echo e($payment['metodo'] ?? '-'); ?></td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info"><?php echo e($payment['invoice_status'] ?? '-'); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">No hay pagos registrados.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
