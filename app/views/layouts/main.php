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
    $reportTemplates = [];
    $reportsDir = __DIR__ . '/../../../documento';
    if (is_dir($reportsDir)) {
        $templatePaths = glob($reportsDir . '/*.php') ?: [];
        foreach ($templatePaths as $templatePath) {
            $filename = basename($templatePath);
            $baseName = pathinfo($filename, PATHINFO_FILENAME);
            $label = preg_replace('/^informe/i', 'Informe ', $baseName);
            $label = preg_replace('/([a-z])([A-Z])/', '$1 $2', $label);
            $label = str_replace('_', ' ', $label);
            $label = trim($label);
            $reportTemplates[] = [
                'file' => $filename,
                'label' => $label,
                'url' => 'documento/' . $filename,
            ];
        }
        usort(
            $reportTemplates,
            static fn(array $a, array $b): int => strcasecmp($a['label'], $b['label'])
        );
    }
    ?>
    <script>
        window.reportTemplates = <?php echo json_encode($reportTemplates); ?>;

        document.addEventListener('DOMContentLoaded', () => {
            const templates = window.reportTemplates || [];
            if (!templates.length) {
                return;
            }

            const route = new URLSearchParams(window.location.search).get('route') || '';
            if (!route || !/(?:^|\\/)create$|(?:^|\\/)edit$/.test(route)) {
                return;
            }

            const findTemplate = (file) => templates.find((template) => template.file === file);
            const defaultTemplate = findTemplate('informeIcargaEspanol.php') ?? templates[0];
            const invoiceTemplate = findTemplate('informeIcargaInvoice.php') ?? defaultTemplate;
            const selectedTemplate = /^(invoices|quotes)(?:\\/|$)/.test(route)
                ? invoiceTemplate
                : defaultTemplate;

            if (!selectedTemplate) {
                return;
            }

            document.querySelectorAll('form').forEach((form) => {
                if (form.dataset.reportsInjected) {
                    return;
                }

                const actionContainer = document.createElement('div');
                actionContainer.className = 'd-flex justify-content-end gap-2 mt-3';

                const reportButton = document.createElement('a');
                reportButton.className = 'btn btn-outline-primary';
                reportButton.href = selectedTemplate.url;
                reportButton.target = '_blank';
                reportButton.rel = 'noopener';
                reportButton.textContent = 'Informe';

                actionContainer.appendChild(reportButton);
                form.appendChild(actionContainer);
                form.dataset.reportsInjected = 'true';
            });
        });
    </script>
</body>

</html>
