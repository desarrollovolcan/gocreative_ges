<div class="dashboard-hero mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h3 class="text-white mb-1">Panel comercial</h3>
            <p class="text-white-50 mb-0">Indicadores actualizados de proyectos, servicios y facturación.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="index.php?route=crm/hub" class="btn btn-light btn-sm">Ir al CRM</a>
            <a href="index.php?route=projects/create" class="btn btn-outline-light btn-sm">Nuevo proyecto</a>
            <a href="index.php?route=invoices/create" class="btn btn-outline-light btn-sm">Nueva factura</a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xxl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Facturación mes</p>
                        <h3 class="stat-value"><?php echo e(format_currency((float)$monthBilling)); ?></h3>
                        <span class="stat-sub">Pagos del mes: <?php echo e(format_currency((float)$paymentsMonth)); ?></span>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="ti ti-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Facturas pendientes</p>
                        <h3 class="stat-value"><?php echo e(format_currency((float)$pending)); ?></h3>
                        <span class="stat-sub"><?php echo (int)$pendingCount; ?> pendientes</span>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="ti ti-alert-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Facturas vencidas</p>
                        <h3 class="stat-value"><?php echo e(format_currency((float)$overdue)); ?></h3>
                        <span class="stat-sub"><?php echo (int)$overdueCount; ?> vencidas</span>
                    </div>
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="ti ti-alert-octagon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label">Clientes activos</p>
                        <h3 class="stat-value"><?php echo (int)$clientsActive; ?></h3>
                        <span class="stat-sub"><?php echo (int)$projectsTotal; ?> proyectos activos</span>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
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
                <canvas id="revenueTrendChart" height="140"></canvas>
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
                <canvas id="ticketStatusChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
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
                <div class="dashboard-actions mt-3">
                    <a href="index.php?route=services" class="btn btn-outline-primary btn-sm">Ver servicios</a>
                    <a href="index.php?route=tickets" class="btn btn-outline-warning btn-sm">Service desk</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Estado de facturas</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col">
                        <p class="text-muted mb-1">Pagadas</p>
                        <h3 class="fw-semibold mb-0"><?php echo (int)$paidCount; ?></h3>
                    </div>
                    <div class="col">
                        <p class="text-muted mb-1">Pendientes</p>
                        <h3 class="fw-semibold mb-0"><?php echo (int)$pendingCount; ?></h3>
                    </div>
                    <div class="col">
                        <p class="text-muted mb-1">Vencidas</p>
                        <h3 class="fw-semibold mb-0"><?php echo (int)$overdueCount; ?></h3>
                    </div>
                </div>
                <div class="dashboard-actions mt-3">
                    <a href="index.php?route=invoices" class="btn btn-outline-success btn-sm">Ver facturas</a>
                    <a href="index.php?route=quotes" class="btn btn-outline-info btn-sm">Ver cotizaciones</a>
                </div>
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
                                        <td class="text-end"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
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
                                        <td class="text-end"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
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
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const revenueLabels = <?php echo json_encode($revenueLabels, JSON_UNESCAPED_UNICODE); ?>;
    const revenueTotals = <?php echo json_encode($revenueTotals, JSON_UNESCAPED_UNICODE); ?>;
    const ticketLabels = <?php echo json_encode(array_values($ticketStatusLabels), JSON_UNESCAPED_UNICODE); ?>;
    const ticketTotals = <?php echo json_encode($ticketTotals, JSON_UNESCAPED_UNICODE); ?>;

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
                        legend: { position: 'bottom' }
                    },
                    cutout: '65%'
                }
            });
        }
    }
</script>
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
                                        <td><?php echo e($service['due_date'] ?? ''); ?></td>
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
                                        <td class="text-end"><?php echo e(format_currency((float)($client['total'] ?? 0))); ?></td>
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
                                        <td class="text-end"><?php echo e(format_currency((float)($payment['monto'] ?? 0))); ?></td>
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
