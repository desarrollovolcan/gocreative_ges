<?php include __DIR__ . '/../../../partials/html.php'; ?>

<head>
    <?php $title = $title ?? '[[NOMBRE_SISTEMA]]'; include __DIR__ . '/../../../partials/title-meta.php'; ?>
    <?php include __DIR__ . '/../../../partials/head-css.php'; ?>
</head>

<body>
    <div class="wrapper">
        <?php include __DIR__ . '/../partials/menu.php'; ?>

        <div class="content-page">
            <div class="container-fluid">
                <?php $pageTitle = $pageTitle ?? $title ?? ''; include __DIR__ . '/../../../partials/page-title.php'; ?>

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
</body>

</html>
