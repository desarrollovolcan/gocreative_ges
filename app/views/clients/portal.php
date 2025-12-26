<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo e($error); ?></div>
<?php else: ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo e($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <article class="card overflow-hidden mb-0 border-0 shadow-sm">
                    <div class="position-relative card-side-img overflow-hidden" style="min-height: 220px; background-image: url(assets/images/profile-bg.jpg);">
                        <div class="p-4 card-img-overlay rounded-start-0 auth-overlay d-flex align-items-center justify-content-between flex-column flex-md-row text-center text-md-start">
                            <div>
                                <h3 class="text-white mb-1 fw-bold"><?php echo e($client['name'] ?? 'Portal Cliente'); ?></h3>
                                <p class="text-white mb-0">Tu información y estado de cuenta en un solo lugar</p>
                            </div>
                            <div class="d-flex gap-2 mt-3 mt-md-0">
                                <div class="text-center">
                                    <div class="text-white fw-semibold fs-4"><?php echo count($pendingInvoices ?? []); ?></div>
                                    <div class="text-white-50 fs-xs">Pendientes</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-white fw-semibold fs-4"><?php echo count($payments ?? []); ?></div>
                                    <div class="text-white-50 fs-xs">Pagos</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-white fw-semibold fs-4"><?php echo count($activities ?? []); ?></div>
                                    <div class="text-white-50 fs-xs">Actividades</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="px-3 mt-n4">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-top-sticky shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-3 position-relative">
                                    <div class="avatar-lg bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ti ti-building fs-28"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-0 d-flex align-items-center">
                                        <span class="link-reset"><?php echo e($client['name'] ?? ''); ?></span>
                                    </h5>
                                    <p class="text-muted mb-2">Rut: <?php echo e($client['rut'] ?? '-'); ?></p>
                                    <span class="badge text-bg-light badge-label">Cliente activo</span>
                                </div>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                        <i class="ti ti-mail fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Correo</div>
                                        <div class="fw-semibold"><?php echo e($client['email'] ?? '-'); ?></div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                        <i class="ti ti-phone fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Teléfono</div>
                                        <div class="fw-semibold"><?php echo e($client['phone'] ?? '-'); ?></div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                        <i class="ti ti-user fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Contacto</div>
                                        <div class="fw-semibold"><?php echo e($client['contact'] ?? '-'); ?></div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 d-flex align-items-center gap-2">
                                    <div class="avatar-sm text-bg-light bg-opacity-75 d-flex align-items-center justify-content-center rounded-circle">
                                        <i class="ti ti-map-pin fs-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fs-xs">Dirección</div>
                                        <div class="fw-semibold"><?php echo e($client['address'] ?? '-'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="card-title mb-3 mt-4">Resumen financiero</h4>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted fs-xs">Pendientes</div>
                                        <div class="fw-semibold"><?php echo count($pendingInvoices ?? []); ?></div>
                                        <div class="text-muted fs-xs">$<?php echo number_format($pendingTotal ?? 0, 0, ',', '.'); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted fs-xs">Pagos</div>
                                        <div class="fw-semibold"><?php echo count($payments ?? []); ?></div>
                                        <div class="text-muted fs-xs">$<?php echo number_format($paidTotal ?? 0, 0, ',', '.'); ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header card-tabs d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="card-title">Portal Cliente</h4>
                            </div>
                            <ul class="nav nav-tabs card-header-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="#portal-activities" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        <span class="fw-bold">Actividades</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-payments" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="fw-bold">Pagos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-invoices" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="fw-bold">Facturas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#portal-profile" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="fw-bold">Perfil</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="portal-activities">
                                    <?php if (!empty($activities)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
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
                                <div class="tab-pane" id="portal-payments">
                                    <?php if (!empty($payments)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
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
                                <div class="tab-pane" id="portal-invoices">
                                    <?php if (!empty($pendingInvoices)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Número</th>
                                                        <th>Vence</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($pendingInvoices as $invoice): ?>
                                                        <tr>
                                                            <td>#<?php echo e($invoice['numero']); ?></td>
                                                            <td><?php echo e($invoice['fecha_vencimiento']); ?></td>
                                                            <td>$<?php echo e($invoice['total']); ?></td>
                                                            <td><span class="badge bg-warning-subtle text-warning"><?php echo e($invoice['estado']); ?></span></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted">No hay facturas pendientes.</div>
                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane" id="portal-profile">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="mb-1">Editar datos básicos</h5>
                                            <p class="text-muted mb-0">Mantén tu información actualizada para recibir notificaciones.</p>
                                        </div>
                                    </div>
                                    <form method="post" action="index.php?route=clients/portal/update" class="bg-light rounded p-3">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="token" value="<?php echo e($client['portal_token'] ?? ''); ?>">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Correo</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo e($client['email'] ?? ''); ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="text" name="phone" class="form-control" value="<?php echo e($client['phone'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Contacto</label>
                                                <input type="text" name="contact" class="form-control" value="<?php echo e($client['contact'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dirección</label>
                                                <input type="text" name="address" class="form-control" value="<?php echo e($client['address'] ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form>
                                    <div class="mt-4">
                                        <h6 class="fw-semibold">Soporte rápido</h6>
                                        <p class="text-muted mb-0">Si necesitas asistencia inmediata, contáctanos y te ayudaremos a resolverlo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
