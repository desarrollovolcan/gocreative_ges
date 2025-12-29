<div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                            <i class="ti ti-currency-dollar"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">$<?php echo number_format($monthBilling, 0, ',', '.'); ?></h3>
                        <p class="mb-0 text-muted">Facturación mes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                            <i class="ti ti-alert-triangle"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">$<?php echo number_format($pending, 0, ',', '.'); ?></h3>
                        <p class="mb-0 text-muted">Pendiente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-24">
                            <i class="ti ti-alert-octagon"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">$<?php echo number_format($overdue, 0, ',', '.'); ?></h3>
                        <p class="mb-0 text-muted">Vencido</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                            <i class="ti ti-users"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo (int)$clientsActive; ?></h3>
                        <p class="mb-0 text-muted">Clientes activos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                            <i class="ti ti-receipt"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo (int)$paidCount; ?></h3>
                        <p class="mb-0 text-muted">Facturas pagadas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                            <i class="ti ti-clock-hour-4"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo (int)$pendingCount; ?></h3>
                        <p class="mb-0 text-muted">Facturas pendientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-24">
                            <i class="ti ti-alert-circle"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo (int)$overdueCount; ?></h3>
                        <p class="mb-0 text-muted">Facturas vencidas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                            <i class="ti ti-cash"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">$<?php echo number_format($paymentsMonth, 0, ',', '.'); ?></h3>
                        <p class="mb-0 text-muted">Pagos del mes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Servicios activos</h4>
                <span class="badge bg-info-subtle text-info"><?php echo (int)$servicesActive; ?> activos</span>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col">
                        <p class="text-muted mb-1">Próximos 7 días</p>
                        <h3 class="fw-semibold mb-0"><?php echo (int)$upcoming7; ?></h3>
                    </div>
                    <div class="col">
                        <p class="text-muted mb-1">Próximos 15 días</p>
                        <h3 class="fw-semibold mb-0"><?php echo (int)$upcoming15; ?></h3>
                    </div>
                    <div class="col">
                        <p class="text-muted mb-1">Próximos 30 días</p>
                        <h3 class="fw-semibold mb-0"><?php echo (int)$upcoming30; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Resumen rápido</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-2">Recuerda revisar facturas vencidas y servicios por vencer.</div>
                <a href="index.php?route=services" class="btn btn-outline-primary btn-sm">Ver servicios</a>
                <a href="index.php?route=invoices" class="btn btn-outline-secondary btn-sm ms-2">Ver facturas</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Facturas recientes</h4>
                <a href="index.php?route=invoices" class="btn btn-outline-secondary btn-sm">Ver todas</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentInvoices)): ?>
                    <div class="text-muted">No hay facturas recientes.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Emisión</th>
                                    <th class="text-end">Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentInvoices as $invoice): ?>
                                    <tr>
                                        <td>
                                            <a href="index.php?route=invoices/show&id=<?php echo $invoice['id']; ?>" class="text-decoration-none">
                                                <?php echo e($invoice['numero'] ?? ''); ?>
                                            </a>
                                        </td>
                                        <td><?php echo e($invoice['client_name'] ?? ''); ?></td>
                                        <td><?php echo e($invoice['fecha_emision'] ?? ''); ?></td>
                                        <td class="text-end">$<?php echo number_format((float)($invoice['total'] ?? 0), 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo ($invoice['estado'] ?? '') === 'pagada' ? 'success' : (($invoice['estado'] ?? '') === 'vencida' ? 'danger' : 'warning'); ?>-subtle text-<?php echo ($invoice['estado'] ?? '') === 'pagada' ? 'success' : (($invoice['estado'] ?? '') === 'vencida' ? 'danger' : 'warning'); ?>">
                                                <?php echo e($invoice['estado'] ?? 'pendiente'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Facturas vencidas</h4>
                <a href="index.php?route=invoices" class="btn btn-outline-danger btn-sm">Revisar</a>
            </div>
            <div class="card-body">
                <?php if (empty($overdueInvoices)): ?>
                    <div class="text-muted">No hay facturas vencidas.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Vencimiento</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($overdueInvoices as $invoice): ?>
                                    <tr>
                                        <td>
                                            <a href="index.php?route=invoices/show&id=<?php echo $invoice['id']; ?>" class="text-decoration-none">
                                                <?php echo e($invoice['numero'] ?? ''); ?>
                                            </a>
                                        </td>
                                        <td><?php echo e($invoice['client_name'] ?? ''); ?></td>
                                        <td><?php echo e($invoice['fecha_vencimiento'] ?? ''); ?></td>
                                        <td class="text-end">$<?php echo number_format((float)($invoice['total'] ?? 0), 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Servicios por vencer</h4>
                <a href="index.php?route=services" class="btn btn-outline-primary btn-sm">Ver servicios</a>
            </div>
            <div class="card-body">
                <?php if (empty($upcomingServices)): ?>
                    <div class="text-muted">No hay servicios próximos a vencer.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Cliente</th>
                                    <th>Vence</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($upcomingServices as $service): ?>
                                    <tr>
                                        <td><?php echo e($service['name'] ?? ''); ?></td>
                                        <td><?php echo e($service['client_name'] ?? ''); ?></td>
                                        <td><?php echo e($service['fecha_vencimiento'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Clientes con mayor facturación</h4>
                <a href="index.php?route=clients" class="btn btn-outline-secondary btn-sm">Ver clientes</a>
            </div>
            <div class="card-body">
                <?php if (empty($topClients)): ?>
                    <div class="text-muted">No hay datos de facturación aún.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th class="text-end">Total facturado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topClients as $client): ?>
                                    <tr>
                                        <td><?php echo e($client['client_name'] ?? ''); ?></td>
                                        <td class="text-end">$<?php echo number_format((float)($client['total'] ?? 0), 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Últimos pagos registrados</h4>
                <a href="index.php?route=invoices" class="btn btn-outline-primary btn-sm">Ir a facturas</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentPayments)): ?>
                    <div class="text-muted">No hay pagos recientes.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Factura</th>
                                    <th>Fecha</th>
                                    <th>Método</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentPayments as $payment): ?>
                                    <tr>
                                        <td><?php echo e($payment['client_name'] ?? ''); ?></td>
                                        <td><?php echo e($payment['invoice_number'] ?? ''); ?></td>
                                        <td><?php echo e($payment['fecha_pago'] ?? ''); ?></td>
                                        <td><?php echo e($payment['metodo'] ?? ''); ?></td>
                                        <td class="text-end">$<?php echo number_format((float)($payment['monto'] ?? 0), 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
