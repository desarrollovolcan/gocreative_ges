<?php
$reportTemplate = $reportTemplate ?? '';
$reportSource = $reportSource ?? '';
?>
<?php if ($reportTemplate !== '' && $reportSource !== ''): ?>
    <button type="submit"
            class="btn btn-outline-primary"
            formaction="index.php?route=reports/download&amp;template=<?php echo urlencode($reportTemplate); ?>&amp;source=<?php echo urlencode($reportSource); ?>"
            formmethod="post"
            formtarget="_blank">
        Descargar PDF
    </button>
<?php endif; ?>
