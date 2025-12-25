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
