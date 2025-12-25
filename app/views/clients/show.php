<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-2"><?php echo e($client['name'] ?? ''); ?></h5>
                <p class="mb-1"><strong>Email:</strong> <?php echo e($client['email'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Teléfono:</strong> <?php echo e($client['phone'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Contacto:</strong> <?php echo e($client['contact'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Mandante:</strong> <?php echo e($client['mandante_name'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Mandante RUT:</strong> <?php echo e($client['mandante_rut'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Mandante Teléfono:</strong> <?php echo e($client['mandante_phone'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Mandante Correo:</strong> <?php echo e($client['mandante_email'] ?? '-'); ?></p>
                <p class="mb-1"><strong>Dirección:</strong> <?php echo e($client['address'] ?? '-'); ?></p>
                <p class="mb-0"><strong>Estado:</strong> <?php echo e($client['status'] ?? '-'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Servicios asociados</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($services as $service): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo e($service['name']); ?>
                            <span class="badge bg-info-subtle text-info"><?php echo e($service['service_type']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Facturas</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($invoices as $invoice): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo e($invoice['numero']); ?>
                            <span class="badge bg-secondary-subtle text-secondary"><?php echo e($invoice['estado']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h4 class="card-title mb-0">Proyectos</h4></div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($projects as $project): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo e($project['name']); ?>
                            <span class="badge bg-light text-dark"><?php echo e($project['status']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h4 class="card-title mb-0">Historial de correos</h4></div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($emails as $email): ?>
                        <li class="list-group-item">
                            <strong><?php echo e($email['subject']); ?></strong>
                            <div class="text-muted fs-xs"><?php echo e($email['status']); ?> - <?php echo e($email['created_at']); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title mb-0">Pagos registrados</h4></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Método</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td>#<?php echo e($payment['invoice_id']); ?></td>
                            <td><?php echo e($payment['monto']); ?></td>
                            <td><?php echo e($payment['fecha_pago']); ?></td>
                            <td><?php echo e($payment['metodo']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
