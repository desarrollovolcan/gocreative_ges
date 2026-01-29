<?php
$totalInvoicesCount = (int)$paidCount + (int)$pendingCount + (int)$overdueCount;
$collectionRate = $totalInvoicesCount > 0 ? (int)round(((int)$paidCount / $totalInvoicesCount) * 100) : 0;
$overdueRate = $totalInvoicesCount > 0 ? (int)round(((int)$overdueCount / $totalInvoicesCount) * 100) : 0;
$servicePressure = (int)$servicesActive > 0 ? min(100, (int)round(((int)$upcoming30 / (int)$servicesActive) * 100)) : 0;
?>

<div class="dashboard-compact">
    <div class="dashboard-hero dashboard-hero-light mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h3 class="mb-1">Panel de producción</h3>
                <p class="mb-2">Costos, ganancias y ventas de productos producidos.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-primary-subtle text-primary">Unidades producidas: <?php echo (int)$producedUnits; ?></span>
                    <span class="badge bg-success-subtle text-success">Ventas producidas: <?php echo e(format_currency((float)$producedSales)); ?></span>
                    <span class="badge bg-info-subtle text-info">Ganancia producción: <?php echo e(format_currency((float)$productionProfit)); ?></span>
                </div>
            </div>
            <div class="d-flex flex-wrap flex-sm-nowrap align-items-center gap-2">
                <a href="index.php?route=production" class="btn btn-primary btn-sm">Ir a producción</a>
                <a href="index.php?route=production/create" class="btn btn-outline-primary btn-sm">Nueva orden</a>
                <a href="index.php?route=production/stock" class="btn btn-outline-primary btn-sm">Stock producido</a>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-4 g-2">
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Costo producción</p>
                            <h3 class="stat-value"><?php echo e(format_currency((float)$productionCost)); ?></h3>
                            <span class="stat-sub">Total insumos + gastos</span>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="ti ti-stack-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Ventas productos producidos</p>
                            <h3 class="stat-value"><?php echo e(format_currency((float)$producedSales)); ?></h3>
                            <span class="stat-sub">Ventas asociadas a producción</span>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="ti ti-cash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Ganancia producción</p>
                            <h3 class="stat-value"><?php echo e(format_currency((float)$productionProfit)); ?></h3>
                            <span class="stat-sub">Ventas - costos</span>
                        </div>
                        <div class="stat-icon bg-danger-subtle text-danger">
                            <i class="ti ti-chart-bar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Unidades producidas</p>
                            <h3 class="stat-value"><?php echo (int)$producedUnits; ?></h3>
                            <span class="stat-sub">Producción acumulada</span>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="ti ti-package"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-3 g-2 mt-2">
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Asientos contables</p>
                            <h3 class="stat-value"><?php echo (int)$accountingJournals; ?></h3>
                            <span class="stat-sub">Libro diario actualizado</span>
                        </div>
                        <div class="stat-icon bg-secondary-subtle text-secondary">
                            <i class="ti ti-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Períodos tributarios</p>
                            <h3 class="stat-value"><?php echo (int)$taxPeriods; ?></h3>
                            <span class="stat-sub">Impuestos y retenciones</span>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="ti ti-file-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Honorarios pendientes</p>
                            <h3 class="stat-value"><?php echo (int)$honorariosPending; ?></h3>
                            <span class="stat-sub">Boletas por pagar</span>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="ti ti-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Activos fijos</p>
                            <h3 class="stat-value"><?php echo (int)$fixedAssets; ?></h3>
                            <span class="stat-sub">Control patrimonial</span>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="ti ti-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Cuentas bancarias</p>
                            <h3 class="stat-value"><?php echo (int)$bankAccounts; ?></h3>
                            <span class="stat-sub">Tesorería activa</span>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="ti ti-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label">Movimientos inventario</p>
                            <h3 class="stat-value"><?php echo (int)$inventoryMovesMonth; ?></h3>
                            <span class="stat-sub">Últimos 30 días</span>
                        </div>
                        <div class="stat-icon bg-danger-subtle text-danger">
                            <i class="ti ti-layers"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h6 class="mb-1">Costo por producto producido</h6>
                <p class="text-muted mb-0 small">Detalle de costos unitarios y unidades producidas.</p>
            </div>
            <a href="index.php?route=production/stock" class="btn btn-outline-primary btn-sm">Ver stock producido</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-end">Unidades producidas</th>
                            <th class="text-end">Costo unitario</th>
                            <th class="text-end">Stock actual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($producedProducts)): ?>
                            <tr>
                                <td colspan="4" class="text-muted text-center">Sin producción registrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($producedProducts as $item): ?>
                                <tr>
                                    <td><?php echo e($item['name'] ?? ''); ?></td>
                                    <td class="text-end"><?php echo (int)($item['produced_quantity'] ?? 0); ?></td>
                                    <td class="text-end"><?php echo e(format_currency((float)($item['cost'] ?? 0))); ?></td>
                                    <td class="text-end"><?php echo (int)($item['stock'] ?? 0); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-xxl-8">
            <div class="card h-100">
                <div class="card-body py-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div>
                            <h6 class="mb-1">Alertas clave</h6>
                            <p class="text-muted mb-0 small">Visualiza rápido los focos críticos del ciclo comercial.</p>
                        </div>
                        <span class="badge bg-secondary-subtle text-secondary">Actualizado en tiempo real</span>
                    </div>
                    <div class="alert-grid">
                        <div class="alert-tile">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="alert-icon text-danger bg-danger-subtle"><i class="ti ti-alert-octagon"></i></span>
                                    <div>
                                        <p class="alert-label mb-0">Facturas vencidas</p>
                                        <small class="text-muted">Impacto en cobranza</small>
                                    </div>
                                </div>
                                <a href="index.php?route=invoices" class="text-decoration-none small text-primary">Revisar</a>
                            </div>
                            <div class="d-flex align-items-baseline justify-content-between">
                                <h4 class="mb-0"><?php echo (int)$overdueCount; ?></h4>
                                <span class="text-danger fw-semibold"><?php echo e(format_currency((float)$overdue)); ?></span>
                            </div>
                        </div>
                        <div class="alert-tile">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="alert-icon text-warning bg-warning-subtle"><i class="ti ti-clock"></i></span>
                                    <div>
                                        <p class="alert-label mb-0">Servicios por vencer</p>
                                        <small class="text-muted">Próximos 30 días</small>
                                    </div>
                                </div>
                                <a href="index.php?route=services" class="text-decoration-none small text-primary">Ver</a>
                            </div>
                            <div class="d-flex align-items-baseline justify-content-between">
                                <h4 class="mb-0"><?php echo (int)$upcoming30; ?></h4>
                                <span class="text-muted small">7d: <?php echo (int)$upcoming7; ?> · 15d: <?php echo (int)$upcoming15; ?></span>
                            </div>
                        </div>
                        <div class="alert-tile">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="alert-icon text-info bg-info-subtle"><i class="ti ti-ticket"></i></span>
                                    <div>
                                        <p class="alert-label mb-0">Tickets abiertos</p>
                                        <small class="text-muted">Service desk</small>
                                    </div>
                                </div>
                                <a href="index.php?route=tickets" class="text-decoration-none small text-primary">Ir</a>
                            </div>
                            <div class="d-flex align-items-baseline justify-content-between">
                                <h4 class="mb-0"><?php echo (int)$ticketsOpen; ?></h4>
                                <span class="text-muted small">Seguimiento requerido</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1">Salud de cartera</h6>
                            <p class="text-muted mb-0 small">Cobranza y riesgos resumidos.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary"><?php echo $totalInvoicesCount; ?> facturas</span>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Cobranza realizada</span>
                            <span class="fw-semibold"><?php echo $collectionRate; ?>%</span>
                        </div>
                        <div class="progress progress-thin">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $collectionRate; ?>%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Riesgo por vencimiento</span>
                            <span class="fw-semibold"><?php echo $overdueRate; ?>%</span>
                        </div>
                        <div class="progress progress-thin">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $overdueRate; ?>%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Servicios en radar (30 días)</span>
                            <span class="fw-semibold"><?php echo $servicePressure; ?>%</span>
                        </div>
                        <div class="progress progress-thin">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $servicePressure; ?>%"></div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-success-subtle text-success">Pagadas: <?php echo (int)$paidCount; ?></span>
                        <span class="badge bg-warning-subtle text-warning">Pendientes: <?php echo (int)$pendingCount; ?></span>
                        <span class="badge bg-danger-subtle text-danger">Vencidas: <?php echo (int)$overdueCount; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Facturación reciente</h4>
                        <small class="text-muted">Últimos 6 meses de ingresos registrados.</small>
                    </div>
                    <a href="index.php?route=invoices" class="btn btn-outline-primary btn-sm">Ver facturas</a>
                </div>
                <div class="card-body">
                    <div class="dashboard-chart">
                        <canvas id="revenueTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0">Estado de tickets</h4>
                    <small class="text-muted">Tickets abiertos y en progreso.</small>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="stat-label">Tickets abiertos</p>
                            <h3 class="stat-value mb-0"><?php echo (int)$ticketsOpen; ?></h3>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="ti ti-ticket"></i>
                        </div>
                    </div>
                    <div class="dashboard-chart dashboard-chart-sm">
                        <canvas id="ticketStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h4 class="card-title mb-0">Facturas y cobranzas</h4>
                        <small class="text-muted">Movimientos recientes y vencimientos.</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary-subtle text-primary"><?php echo e(format_currency((float)$monthBilling)); ?> mes</span>
                        <span class="badge bg-warning-subtle text-warning"><?php echo (int)$pendingCount; ?> pendientes</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Distribución de estados</span>
                            <a href="index.php?route=invoices" class="text-primary text-decoration-none small">Detalle</a>
                        </div>
                        <div class="dashboard-chart dashboard-chart-xs">
                            <canvas id="invoiceStatusChart"></canvas>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-fill small bg-light rounded-3 p-1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab-recent-invoices" data-bs-toggle="tab" href="#recent-invoices" role="tab" aria-controls="recent-invoices" aria-selected="true">Recientes</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-overdue-invoices" data-bs-toggle="tab" href="#overdue-invoices" role="tab" aria-controls="overdue-invoices" aria-selected="false">Vencidas</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="recent-invoices" role="tabpanel" aria-labelledby="tab-recent-invoices">
                            <?php if (empty($recentInvoices)): ?>
                                <div class="text-muted">No hay facturas recientes.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-hover align-middle table-compact">
                                        <thead>
                                            <tr>
                                                <th>Número</th>
                                                <th>Cliente</th>
                                                <th>Emisión</th>
                                                <th class="text-end">Total</th>
                                                <th>Estado</th>
                                                <th class="text-end">Acciones</th>
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
                                                    <td class="text-end"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
                                                    <td>
                                                        <span class="badge bg-<?php echo ($invoice['estado'] ?? '') === 'pagada' ? 'success' : (($invoice['estado'] ?? '') === 'vencida' ? 'danger' : 'warning'); ?>-subtle text-<?php echo ($invoice['estado'] ?? '') === 'pagada' ? 'success' : (($invoice['estado'] ?? '') === 'vencida' ? 'danger' : 'warning'); ?>">
                                                            <?php echo e($invoice['estado'] ?? 'pendiente'); ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <form method="post" action="index.php?route=invoices/delete" onsubmit="return confirm('¿Eliminar esta factura?');">
                                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="id" value="<?php echo (int)$invoice['id']; ?>">
                                                            <button type="submit" class="btn btn-sm btn-soft-danger">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="overdue-invoices" role="tabpanel" aria-labelledby="tab-overdue-invoices">
                            <?php if (empty($overdueInvoices)): ?>
                                <div class="text-muted">No hay facturas vencidas.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-hover align-middle table-compact">
                                        <thead>
                                            <tr>
                                                <th>Número</th>
                                                <th>Cliente</th>
                                                <th>Vencimiento</th>
                                                <th class="text-end">Total</th>
                                                <th class="text-end">Acciones</th>
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
                                                    <td class="text-end"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
                                                    <td class="text-end">
                                                        <form method="post" action="index.php?route=invoices/delete" onsubmit="return confirm('¿Eliminar esta factura?');">
                                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="id" value="<?php echo (int)$invoice['id']; ?>">
                                                            <button type="submit" class="btn btn-sm btn-soft-danger">Eliminar</button>
                                                        </form>
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
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h4 class="card-title mb-0">Relación con clientes</h4>
                        <small class="text-muted">Servicios próximos y cuentas clave.</small>
                    </div>
                    <span class="badge bg-info-subtle text-info"><?php echo (int)$servicesActive; ?> servicios activos</span>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-fill small bg-light rounded-3 p-1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab-upcoming-services" data-bs-toggle="tab" href="#upcoming-services" role="tab" aria-controls="upcoming-services" aria-selected="true">Servicios por vencer</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-top-clients" data-bs-toggle="tab" href="#top-clients" role="tab" aria-controls="top-clients" aria-selected="false">Clientes top</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="upcoming-services" role="tabpanel" aria-labelledby="tab-upcoming-services">
                            <?php if (empty($upcomingServices)): ?>
                                <div class="text-muted">No hay servicios próximos a vencer.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-hover align-middle table-compact">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Cliente</th>
                                                <th>Vence</th>
                                                <th class="text-end">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($upcomingServices as $service): ?>
                                                <tr>
                                                    <td><?php echo e($service['name'] ?? ''); ?></td>
                                                    <td><?php echo e($service['client_name'] ?? ''); ?></td>
                                                    <td><?php echo e($service['due_date'] ?? ''); ?></td>
                                                    <td class="text-end">
                                                        <form method="post" action="index.php?route=services/delete" onsubmit="return confirm('¿Eliminar este servicio?');">
                                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="id" value="<?php echo (int)$service['id']; ?>">
                                                            <button type="submit" class="btn btn-sm btn-soft-danger">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="top-clients" role="tabpanel" aria-labelledby="tab-top-clients">
                            <?php if (empty($topClients)): ?>
                                <div class="text-muted">No hay datos de facturación aún.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-hover align-middle table-compact">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th class="text-end">Total facturado</th>
                                                <th class="text-end">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($topClients as $client): ?>
                                                <tr>
                                                    <td><?php echo e($client['client_name'] ?? ''); ?></td>
                                                    <td class="text-end"><?php echo e(format_currency((float)($client['total'] ?? 0))); ?></td>
                                                    <td class="text-end">
                                                        <form method="post" action="index.php?route=clients/delete" onsubmit="return confirm('¿Eliminar este cliente?');">
                                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="id" value="<?php echo (int)($client['client_id'] ?? 0); ?>">
                                                            <button type="submit" class="btn btn-sm btn-soft-danger">Eliminar</button>
                                                        </form>
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
            </div>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Últimos pagos registrados</h4>
                        <small class="text-muted">Consolida la caja sin salir del panel.</small>
                    </div>
                    <span class="badge bg-success-subtle text-success"><?php echo e(format_currency((float)$paymentsMonth)); ?> en el mes</span>
                </div>
                <div class="card-body">
                    <?php if (empty($recentPayments)): ?>
                        <div class="text-muted">No hay pagos recientes.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover align-middle table-compact">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Método</th>
                                        <th class="text-end">Monto</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentPayments as $payment): ?>
                                        <tr>
                                            <td><?php echo e($payment['client_name'] ?? ''); ?></td>
                                            <td><?php echo e($payment['invoice_number'] ?? ''); ?></td>
                                            <td><?php echo e($payment['fecha_pago'] ?? ''); ?></td>
                                            <td><?php echo e($payment['metodo'] ?? ''); ?></td>
                                            <td class="text-end"><?php echo e(format_currency((float)($payment['monto'] ?? 0))); ?></td>
                                            <td class="text-end">
                                                <form method="post" action="index.php?route=invoices/payments/delete" onsubmit="return confirm('¿Eliminar este pago?');">
                                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="payment_id" value="<?php echo (int)$payment['id']; ?>">
                                                    <input type="hidden" name="invoice_id" value="<?php echo (int)($payment['invoice_id'] ?? 0); ?>">
                                                    <button type="submit" class="btn btn-sm btn-soft-danger">Eliminar</button>
                                                </form>
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
    </div>
</div>

<?php
$revenueTrend = array_reverse($revenueTrend ?? []);
$revenueLabels = [];
$revenueTotals = [];
foreach ($revenueTrend as $row) {
    $revenueLabels[] = $row['period'] ?? '';
    $revenueTotals[] = (float)($row['total'] ?? 0);
}
$ticketStatusMap = [];
foreach ($ticketStatusSummary as $statusRow) {
    $ticketStatusMap[$statusRow['status'] ?? ''] = (int)($statusRow['total'] ?? 0);
}
$ticketStatusLabels = ['abierto' => 'Abierto', 'en_progreso' => 'En progreso', 'pendiente' => 'Pendiente', 'resuelto' => 'Resuelto', 'cerrado' => 'Cerrado'];
$ticketTotals = [];
foreach (array_keys($ticketStatusLabels) as $key) {
    $ticketTotals[] = $ticketStatusMap[$key] ?? 0;
}
$invoiceStatusMap = [];
foreach ($invoiceStatusSummary as $statusRow) {
    $invoiceStatusMap[$statusRow['status'] ?? ''] = (int)($statusRow['total'] ?? 0);
}
$invoiceStatusLabels = ['pendiente' => 'Pendiente', 'pagada' => 'Pagada', 'vencida' => 'Vencida', 'anulada' => 'Anulada'];
$invoiceTotals = [];
foreach (array_keys($invoiceStatusLabels) as $key) {
    $invoiceTotals[] = $invoiceStatusMap[$key] ?? 0;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const revenueLabels = <?php echo json_encode($revenueLabels, JSON_UNESCAPED_UNICODE); ?>;
    const revenueTotals = <?php echo json_encode($revenueTotals, JSON_UNESCAPED_UNICODE); ?>;
    const ticketLabels = <?php echo json_encode(array_values($ticketStatusLabels), JSON_UNESCAPED_UNICODE); ?>;
    const ticketTotals = <?php echo json_encode($ticketTotals, JSON_UNESCAPED_UNICODE); ?>;
    const invoiceLabels = <?php echo json_encode(array_values($invoiceStatusLabels), JSON_UNESCAPED_UNICODE); ?>;
    const invoiceTotals = <?php echo json_encode($invoiceTotals, JSON_UNESCAPED_UNICODE); ?>;

    if (window.Chart) {
        const revenueCtx = document.getElementById('revenueTrendChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Facturación',
                        data: revenueTotals,
                        borderColor: '#5a4de1',
                        backgroundColor: 'rgba(90, 77, 225, 0.18)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#5a4de1',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { color: 'rgba(148, 163, 184, 0.25)' } }
                    }
                }
            });
        }

        const ticketCtx = document.getElementById('ticketStatusChart');
        if (ticketCtx) {
            new Chart(ticketCtx, {
                type: 'doughnut',
                data: {
                    labels: ticketLabels,
                    datasets: [{
                        data: ticketTotals,
                        backgroundColor: ['#5a4de1', '#4aa3ff', '#f3a257', '#22b59a', '#94a3b8'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 10, boxHeight: 10 } }
                    },
                    cutout: '65%'
                }
            });
        }

        const invoiceCtx = document.getElementById('invoiceStatusChart');
        if (invoiceCtx) {
            new Chart(invoiceCtx, {
                type: 'bar',
                data: {
                    labels: invoiceLabels,
                    datasets: [{
                        label: 'Facturas',
                        data: invoiceTotals,
                        backgroundColor: ['#f3a257', '#22b59a', '#f06c6c', '#94a3b8'],
                        borderRadius: 8,
                        maxBarThickness: 28
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { color: 'rgba(148, 163, 184, 0.25)' }, beginAtZero: true }
                    }
                }
            });
        }
    }
</script>
