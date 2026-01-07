<?php include __DIR__ . '/../../../partials/html.php'; ?>

<head>
    <?php $title = $title ?? 'GoCreative Ges'; include __DIR__ . '/../../../partials/title-meta.php'; ?>
    <?php include __DIR__ . '/../../../partials/head-css.php'; ?>
</head>

<body>
    <div class="wrapper">
        <?php include __DIR__ . '/../partials/menu.php'; ?>

        <div class="content-page">
            <div class="container-fluid">
                <?php $pageTitle = $pageTitle ?? $title ?? ''; include __DIR__ . '/../../../partials/page-title.php'; ?>
                <?php
                $flashMessages = consume_flash();
                $flashClassMap = [
                    'success' => 'success',
                    'error' => 'danger',
                    'warning' => 'warning',
                    'info' => 'info',
                ];
                ?>
                <?php foreach ($flashMessages as $type => $messages): ?>
                    <?php $alertClass = $flashClassMap[$type] ?? 'info'; ?>
                    <?php foreach ((array)$messages as $message): ?>
                        <div class="alert alert-<?php echo e($alertClass); ?> alert-dismissible fade show" role="alert">
                            <?php echo e($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <?php
                $viewPath = __DIR__ . '/../' . $view . '.php';
                if (file_exists($viewPath)) {
                    include $viewPath;
                } else {
                    echo '<div class="alert alert-danger">Vista no encontrada.</div>';
                }
                ?>
            </div>
            <?php include __DIR__ . '/../../../partials/footer.php'; ?>
        </div>
    </div>

    <?php include __DIR__ . '/../../../partials/footer-scripts.php'; ?>
    <?php
    $reportTemplateByRoute = [
        'email_templates/create' => 'informeIcargaEspanol.php',
        'email_templates/edit' => 'informeIcargaEspanol.php',
        'purchases/create' => 'informeIcargaEspanol.php',
        'treasury/transaction-edit' => 'informeIcargaEspanol.php',
        'treasury/account-edit' => 'informeIcargaEspanol.php',
        'products/create' => 'informeIcargaEspanol.php',
        'products/edit' => 'informeIcargaEspanol.php',
        'taxes/period-edit' => 'informeIcargaEspanol.php',
        'taxes/withholding-edit' => 'informeIcargaEspanol.php',
        'roles/create' => 'informeIcargaEspanol.php',
        'roles/edit' => 'informeIcargaEspanol.php',
        'companies/create' => 'informeIcargaEspanol.php',
        'companies/edit' => 'informeIcargaEspanol.php',
        'services/create' => 'informeIcargaEspanol.php',
        'services/edit' => 'informeIcargaEspanol.php',
        'sales/create' => 'informeIcargaEspanol.php',
        'fixed-assets/create' => 'informeIcargaEspanol.php',
        'fixed-assets/edit' => 'informeIcargaEspanol.php',
        'quotes/create' => 'informeIcargaInvoice.php',
        'quotes/edit' => 'informeIcargaInvoice.php',
        'hr/payrolls/create' => 'informeIcargaEspanol.php',
        'hr/contracts/create' => 'informeIcargaEspanol.php',
        'hr/contracts/edit' => 'informeIcargaEspanol.php',
        'hr/attendance/create' => 'informeIcargaEspanol.php',
        'hr/employees/create' => 'informeIcargaEspanol.php',
        'hr/employees/edit' => 'informeIcargaEspanol.php',
        'tickets/create' => 'informeIcargaEspanol.php',
        'suppliers/create' => 'informeIcargaEspanol.php',
        'suppliers/edit' => 'informeIcargaEspanol.php',
        'users/create' => 'informeIcargaEspanol.php',
        'users/edit' => 'informeIcargaEspanol.php',
        'projects/create' => 'informeIcargaEspanol.php',
        'projects/edit' => 'informeIcargaEspanol.php',
        'inventory/movement-edit' => 'informeIcargaEspanol.php',
        'clients/create' => 'informeIcargaEspanol.php',
        'clients/edit' => 'informeIcargaEspanol.php',
        'accounting/journals-create' => 'informeIcargaEspanol.php',
        'accounting/chart-create' => 'informeIcargaEspanol.php',
        'accounting/chart-edit' => 'informeIcargaEspanol.php',
        'honorarios/create' => 'informeIcargaEspanol.php',
        'invoices/create' => 'informeIcargaInvoice.php',
        'invoices/edit' => 'informeIcargaInvoice.php',
    ];
    ?>
    <script>
        window.reportTemplateByRoute = <?php echo json_encode($reportTemplateByRoute); ?>;

        document.addEventListener('DOMContentLoaded', () => {
            const route = new URLSearchParams(window.location.search).get('route') || '';
            if (!route || !(route in window.reportTemplateByRoute)) {
                return;
            }

            const selectedTemplate = window.reportTemplateByRoute[route];

            document.querySelectorAll('form').forEach((form) => {
                if (form.dataset.reportsInjected) {
                    return;
                }

                const actionContainer = document.createElement('div');
                actionContainer.className = 'd-flex justify-content-end gap-2 mt-3';

                const downloadButton = document.createElement('a');
                downloadButton.className = 'btn btn-outline-primary';
                downloadButton.href = `index.php?route=reports/download&template=${encodeURIComponent(selectedTemplate)}&source=${encodeURIComponent(route)}`;
                downloadButton.textContent = 'Descargar PDF';

                actionContainer.appendChild(downloadButton);
                form.appendChild(actionContainer);
                form.dataset.reportsInjected = 'true';
            });
        });
    </script>
</body>

</html>
