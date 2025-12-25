<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=projects/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row">
                <div class="col-12">
                    <h5 class="form-section-title mt-0">Datos del proyecto</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="client_id" class="form-select" required data-mandante-source>
                        <option value="">Selecciona cliente</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>"
                                data-mandante-name="<?php echo e($client['mandante_name'] ?? ''); ?>"
                                data-mandante-rut="<?php echo e($client['mandante_rut'] ?? ''); ?>"
                                data-mandante-phone="<?php echo e($client['mandante_phone'] ?? ''); ?>"
                                data-mandante-email="<?php echo e($client['mandante_email'] ?? ''); ?>">
                                <?php echo e($client['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Estado y planificación</h5>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="cotizado">Cotizado</option>
                        <option value="en_curso">En curso</option>
                        <option value="en_pausa">En pausa</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha entrega</label>
                    <input type="date" name="delivery_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="value" class="form-control">
                </div>
                <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="form-section-title mb-0">Datos del mandante</h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-soft-primary btn-sm" data-mandante-fill>Actualizar desde cliente</button>
                        <button type="button" class="btn btn-light btn-sm" data-mandante-clear>Limpiar</button>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Nombre</label>
                    <input type="text" name="mandante_name" class="form-control" data-mandante-field="name">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - RUT</label>
                    <input type="text" name="mandante_rut" class="form-control" data-mandante-field="rut">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Teléfono</label>
                    <input type="text" name="mandante_phone" class="form-control" data-mandante-field="phone">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Correo</label>
                    <input type="email" name="mandante_email" class="form-control" data-mandante-field="email">
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Notas</h5>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=projects" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const clientSelect = document.querySelector('[data-mandante-source]');
    const mandanteFields = {
        name: document.querySelector('[data-mandante-field="name"]'),
        rut: document.querySelector('[data-mandante-field="rut"]'),
        phone: document.querySelector('[data-mandante-field="phone"]'),
        email: document.querySelector('[data-mandante-field="email"]'),
    };
    const mandanteFillButton = document.querySelector('[data-mandante-fill]');
    const mandanteClearButton = document.querySelector('[data-mandante-clear]');

    const getMandanteValues = () => {
        const option = clientSelect?.selectedOptions?.[0];
        if (!option) {
            return null;
        }
        return {
            name: option.dataset.mandanteName || '',
            rut: option.dataset.mandanteRut || '',
            phone: option.dataset.mandantePhone || '',
            email: option.dataset.mandanteEmail || '',
        };
    };

    const fillMandanteFromClient = (override = false) => {
        const values = getMandanteValues();
        if (!values) {
            return;
        }
        Object.entries(mandanteFields).forEach(([key, field]) => {
            if (field && (override || field.value.trim() === '')) {
                field.value = values[key];
            }
        });
    };

    clientSelect?.addEventListener('change', fillMandanteFromClient);
    mandanteFillButton?.addEventListener('click', () => fillMandanteFromClient(true));
    mandanteClearButton?.addEventListener('click', () => {
        Object.values(mandanteFields).forEach((field) => {
            if (field) {
                field.value = '';
            }
        });
    });
</script>
