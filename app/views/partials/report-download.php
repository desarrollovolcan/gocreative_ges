<?php
$reportTemplate = $reportTemplate ?? '';
$reportSource = $reportSource ?? '';
?>
<?php if ($reportTemplate !== '' && $reportSource !== ''): ?>
    <a class="btn btn-outline-primary" href="index.php?route=reports/download&amp;template=<?php echo urlencode($reportTemplate); ?>&amp;source=<?php echo urlencode($reportSource); ?>">
        Descargar PDF
    </a>
<?php endif; ?>
