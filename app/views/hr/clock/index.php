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
                    <div class="fw-semibold mb-2">Reconocimiento facial</div>
                    <div id="face-clock" class="mb-3">
                        <video id="face-clock-video" width="320" height="240" autoplay muted class="border rounded"></video>
                        <div class="mt-2 d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary" id="face-start">Iniciar reconocimiento</button>
                            <span class="text-muted" id="face-clock-status">Esperando cámara</span>
                        </div>
                    </div>
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
<script src="https://unpkg.com/face-api.js@0.22.2/dist/face-api.min.js"></script>
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

    const faceVideo = document.getElementById('face-clock-video');
    const faceStart = document.getElementById('face-start');
    const faceStatus = document.getElementById('face-clock-status');
    const faceModelsUrl = 'https://justadudewhohacks.github.io/face-api.js/models';
    let faceDescriptors = [];

    async function loadFaceModels() {
        await faceapi.nets.tinyFaceDetector.loadFromUri(faceModelsUrl);
        await faceapi.nets.faceLandmark68Net.loadFromUri(faceModelsUrl);
        await faceapi.nets.faceRecognitionNet.loadFromUri(faceModelsUrl);
    }

    async function loadDescriptors() {
        const response = await fetch('index.php?route=hr/clock/faces');
        const rows = await response.json();
        faceDescriptors = rows
            .filter(row => row.face_descriptor)
            .map(row => ({
                id: row.id,
                name: `${row.first_name} ${row.last_name}`,
                descriptor: new Float32Array(JSON.parse(row.face_descriptor))
            }));
    }

    function findBestMatch(descriptor) {
        let best = { id: null, distance: 1 };
        faceDescriptors.forEach(item => {
            const distance = faceapi.euclideanDistance(descriptor, item.descriptor);
            if (distance < best.distance) {
                best = { id: item.id, distance };
            }
        });
        return best.distance < 0.6 ? best.id : null;
    }

    async function startFaceRecognition() {
        try {
            await loadFaceModels();
            await loadDescriptors();
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            faceVideo.srcObject = stream;
            faceStatus.textContent = 'Analizando rostro...';

            if (!faceDescriptors.length) {
                faceStatus.textContent = 'No hay rostros enrolados.';
                stream.getTracks().forEach(track => track.stop());
                return;
            }

            const interval = setInterval(async () => {
                const detection = await faceapi
                    .detectSingleFace(faceVideo, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!detection) {
                    return;
                }

                const matchId = findBestMatch(detection.descriptor);
                if (matchId) {
                    faceStatus.textContent = 'Rostro reconocido, registrando...';
                    clearInterval(interval);
                    stream.getTracks().forEach(track => track.stop());

                    const form = document.createElement('form');
                    form.method = 'post';
                    form.action = 'index.php?route=hr/clock/store';
                    form.innerHTML = `
                        <input type=\"hidden\" name=\"csrf_token\" value=\"<?php echo csrf_token(); ?>\">
                        <input type=\"hidden\" name=\"employee_id\" value=\"${matchId}\">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            }, 1200);
        } catch (error) {
            faceStatus.textContent = 'No se pudo iniciar reconocimiento facial.';
        }
    }

    faceStart?.addEventListener('click', startFaceRecognition);
</script>
