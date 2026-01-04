<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Reloj control QR</h4>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="border rounded p-3">
                    <div class="fw-semibold mb-2">Cámara QR</div>
                    <div id="qr-reader" style="width: 100%;"></div>
                    <div class="text-muted mt-2">Permite acceso a la cámara para escanear el QR de la credencial.</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border rounded p-3">
                    <div class="fw-semibold mb-2">Ingreso manual</div>
                    <form method="post" action="index.php?route=hr/clock/store">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <label class="form-label">Código QR</label>
                        <input type="text" name="qr_token" id="qr-token" class="form-control" placeholder="Escanea o pega el código" required>
                        <div class="mt-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Registrar entrada/salida</button>
                            <a href="index.php?route=hr/attendance" class="btn btn-light">Ver asistencia</a>
                        </div>
                    </form>
                </div>
                <div class="alert alert-info mt-3">
                    Cada escaneo registra entrada o salida según la última marcación del día.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const qrTokenInput = document.getElementById('qr-token');
    if (window.Html5Qrcode) {
        const qrCodeReader = new Html5Qrcode('qr-reader');
        const config = { fps: 10, qrbox: 250 };
        const form = qrTokenInput.closest('form');
        qrCodeReader.start(
            { facingMode: 'environment' },
            config,
            (decodedText) => {
                qrTokenInput.value = decodedText;
                qrCodeReader.stop().catch(() => {});
                if (form) {
                    form.submit();
                }
            },
            () => {}
        ).catch(() => {});
    }
</script>
