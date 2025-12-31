<?php
$environment = $flowConfig['environment'] ?? '';
$apiKey = $flowConfig['api_key'] ?? '';
$secretKey = $flowConfig['secret_key'] ?? '';
$maskedApiKey = $apiKey !== '' ? substr($apiKey, 0, 4) . str_repeat('*', max(0, strlen($apiKey) - 8)) . substr($apiKey, -4) : '';
$maskedSecretKey = $secretKey !== '' ? substr($secretKey, 0, 4) . str_repeat('*', max(0, strlen($secretKey) - 8)) . substr($secretKey, -4) : '';
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Configuración Flow</h4>
        <a href="index.php?route=maintainers/online-payments" class="btn btn-outline-primary btn-sm">Editar configuración</a>
    </div>
    <div class="card-body">
        <?php if (empty($flowConfig)): ?>
            <div class="alert alert-warning mb-0">No hay configuración Flow registrada. Completa los datos para habilitar pagos en línea.</div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="text-muted small">Ambiente</div>
                    <div class="fw-semibold"><?php echo e($environment !== '' ? ucfirst($environment) : 'No definido'); ?></div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="text-muted small">API Key</div>
                    <div class="fw-semibold"><?php echo e($maskedApiKey !== '' ? $maskedApiKey : 'No definido'); ?></div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="text-muted small">Secret Key</div>
                    <div class="fw-semibold"><?php echo e($maskedSecretKey !== '' ? $maskedSecretKey : 'No definido'); ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">URL Base API</div>
                    <div class="fw-semibold"><?php echo e($flowConfig['base_url'] ?? 'No definido'); ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">URL retorno</div>
                    <div class="fw-semibold"><?php echo e($flowConfig['return_url'] ?? 'No definido'); ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">URL confirmación</div>
                    <div class="fw-semibold"><?php echo e($flowConfig['confirmation_url'] ?? 'No definido'); ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Botones de pago</h4>
        <span class="text-muted">Comparte estos enlaces con tus clientes</span>
    </div>
    <div class="card-body">
        <?php if (empty($invoices)): ?>
            <div class="text-muted">No hay facturas con saldo pendiente.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-centered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Factura</th>
                            <th>Cliente</th>
                            <th>Emisión</th>
                            <th>Vencimiento</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Pendiente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <?php
                            $status = $invoice['estado'] ?? 'pendiente';
                            $badgeClass = $status === 'pagada' ? 'success' : ($status === 'vencida' ? 'danger' : 'warning');
                            $detailUrl = 'index.php?route=invoices/details&id=' . (int)$invoice['id'];
                            ?>
                            <tr>
                                <td>#<?php echo e($invoice['numero'] ?? ''); ?></td>
                                <td><?php echo e($invoice['client_name'] ?? ''); ?></td>
                                <td><?php echo e($invoice['fecha_emision'] ?? ''); ?></td>
                                <td><?php echo e($invoice['fecha_vencimiento'] ?? ''); ?></td>
                                <td class="text-end"><?php echo e(format_currency((float)($invoice['total'] ?? 0))); ?></td>
                                <td class="text-end"><?php echo e(format_currency((float)($invoice['pending_total'] ?? 0))); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $badgeClass; ?>-subtle text-<?php echo $badgeClass; ?>">
                                        <?php echo e(ucfirst($status)); ?>
                                    </span>
                                </td>
                                <td class="d-flex flex-wrap gap-2">
                                    <a class="btn btn-soft-primary btn-sm" href="<?php echo e($detailUrl); ?>" target="_blank">Ver factura</a>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-copy-link="<?php echo e($detailUrl); ?>">
                                        Copiar link
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.querySelectorAll('[data-copy-link]').forEach((button) => {
        button.addEventListener('click', async () => {
            const link = button.getAttribute('data-copy-link') || '';
            if (!link) {
                return;
            }
            try {
                await navigator.clipboard.writeText(window.location.origin + '/' + link);
                button.textContent = 'Copiado';
                setTimeout(() => {
                    button.textContent = 'Copiar link';
                }, 1500);
            } catch (error) {
                console.error('No se pudo copiar el enlace.', error);
            }
        });
    });
</script>
