<?php
$recepciones = $recepciones ?? [];
$totalRecepciones = count($recepciones);
$totalKg = 0.0;
$humedadAcumulada = 0.0;
$humedadCount = 0;
$recepcionesMes = 0;
$mesActual = date('Y-m');

foreach ($recepciones as $recepcion) {
    $totalKg += (float)($recepcion['kg_neto'] ?? 0);
    $humedad = $recepcion['humedad'] ?? null;
    if (is_numeric($humedad)) {
        $humedadAcumulada += (float)$humedad;
        $humedadCount++;
    }

    $fecha = $recepcion['fecha'] ?? '';
    if (is_string($fecha) && strpos($fecha, $mesActual) === 0) {
        $recepcionesMes++;
    }
}

$promedioHumedad = $humedadCount > 0 ? $humedadAcumulada / $humedadCount : 0;
?>

<div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                            <i class="ti ti-scale"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo number_format($totalKg, 2, ',', '.'); ?> kg</h3>
                        <p class="mb-0 text-muted">Materia prima recibida</p>
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
                            <i class="ti ti-package"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo (int)$totalRecepciones; ?></h3>
                        <p class="mb-0 text-muted">Recepciones registradas</p>
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
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                            <i class="ti ti-droplet"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo number_format($promedioHumedad, 2, ',', '.'); ?>%</h3>
                        <p class="mb-0 text-muted">Humedad promedio</p>
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
                            <i class="ti ti-calendar-month"></i>
                        </span>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-2 fw-normal"><?php echo (int)$recepcionesMes; ?></h3>
                        <p class="mb-0 text-muted">Recepciones del mes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Detalle de recepción de materia prima</h4>
                <span class="badge bg-primary-subtle text-primary">Total: <?php echo (int)$totalRecepciones; ?></span>
            </div>
            <div class="card-body">
                <?php if (empty($recepciones)): ?>
                    <div class="text-muted">Aún no hay recepciones cargadas.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Productor</th>
                                    <th>Lote</th>
                                    <th>Variedad</th>
                                    <th class="text-end">Kg netos</th>
                                    <th class="text-end">Humedad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recepciones as $recepcion): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars((string)($recepcion['fecha'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string)($recepcion['productor'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string)($recepcion['lote'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string)($recepcion['variedad'] ?? '')); ?></td>
                                        <td class="text-end"><?php echo number_format((float)($recepcion['kg_neto'] ?? 0), 2, ',', '.'); ?></td>
                                        <td class="text-end"><?php echo number_format((float)($recepcion['humedad'] ?? 0), 2, ',', '.'); ?>%</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <?php echo htmlspecialchars((string)($recepcion['estado'] ?? 'Pendiente')); ?>
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
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Resumen de materia prima</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1">Kg recibidos</p>
                        <h4 class="mb-0"><?php echo number_format($totalKg, 2, ',', '.'); ?> kg</h4>
                    </div>
                    <span class="badge bg-success-subtle text-success">Acumulado</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1">Promedio humedad</p>
                        <h4 class="mb-0"><?php echo number_format($promedioHumedad, 2, ',', '.'); ?>%</h4>
                    </div>
                    <span class="badge bg-info-subtle text-info">Calidad</span>
                </div>
                <div class="alert alert-info mb-0">
                    Usa este panel para monitorear la recepción de materia prima y priorizar lotes críticos.
                </div>
            </div>
        </div>
    </div>
</div>
