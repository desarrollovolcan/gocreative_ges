<?php include __DIR__ . '/../../../partials/html.php'; ?>

<head>
    <?php $title = $title ?? 'Portal Cliente'; include __DIR__ . '/../../../partials/title-meta.php'; ?>
    <?php include __DIR__ . '/../../../partials/head-css.php'; ?>
</head>

<body class="bg-body-tertiary">
    <?php $containerClass = !empty($hidePortalHeader) ? 'container-fluid p-0' : 'container-fluid py-4'; ?>
    <div class="<?php echo e($containerClass); ?>">
        <?php if (empty($hidePortalHeader)): ?>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div class="d-flex align-items-center gap-3">
                    <img src="assets/images/logo.png" alt="logo" style="height: 36px;">
                    <div>
                        <h4 class="mb-0"><?php echo e($pageTitle ?? 'Portal Cliente'); ?></h4>
                        <p class="text-muted mb-0">Información de actividades y pagos</p>
                    </div>
                </div>
                <?php if (!empty($client)): ?>
                    <div class="text-md-end">
                        <div class="text-muted fs-sm">Cliente</div>
                        <div class="fw-semibold"><?php echo e($client['name'] ?? ''); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        $viewPath = __DIR__ . '/../' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo '<div class="alert alert-danger">Vista no encontrada.</div>';
        }
        ?>
    </div>

    <?php include __DIR__ . '/../../../partials/footer-scripts.php'; ?>
</body>

</html>
