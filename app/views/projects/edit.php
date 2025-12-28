<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=projects/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
            <div class="row">
                <div class="col-12">
                    <h5 class="form-section-title mt-0">Datos del proyecto</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="client_id" class="form-select" required data-mandante-source>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>"
                                <?php echo $client['id'] == $project['client_id'] ? 'selected' : ''; ?>
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
                    <input type="text" name="name" class="form-control" value="<?php echo e($project['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo e($project['description'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Estado y planificación</h5>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="cotizado" <?php echo ($project['status'] ?? '') === 'cotizado' ? 'selected' : ''; ?>>Cotizado</option>
                        <option value="en_curso" <?php echo ($project['status'] ?? '') === 'en_curso' ? 'selected' : ''; ?>>En curso</option>
                        <option value="en_pausa" <?php echo ($project['status'] ?? '') === 'en_pausa' ? 'selected' : ''; ?>>En pausa</option>
                        <option value="finalizado" <?php echo ($project['status'] ?? '') === 'finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e($project['start_date'] ?? ''); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha entrega</label>
                    <input type="date" name="delivery_date" class="form-control" value="<?php echo e($project['delivery_date'] ?? ''); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="value" class="form-control" value="<?php echo e($project['value'] ?? ''); ?>">
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
                    <input type="text" name="mandante_name" class="form-control" value="<?php echo e($project['mandante_name'] ?? ''); ?>" data-mandante-field="name">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - RUT</label>
                    <input type="text" name="mandante_rut" class="form-control" value="<?php echo e($project['mandante_rut'] ?? ''); ?>" data-mandante-field="rut">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Teléfono</label>
                    <input type="text" name="mandante_phone" class="form-control" value="<?php echo e($project['mandante_phone'] ?? ''); ?>" data-mandante-field="phone">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Correo</label>
                    <input type="email" name="mandante_email" class="form-control" value="<?php echo e($project['mandante_email'] ?? ''); ?>" data-mandante-field="email">
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Notas</h5>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($project['notes'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=projects" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Agregar tarea al proyecto</h5>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=projects/tasks/store" class="row g-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
            <div class="col-md-6">
                <label class="form-label">Título de la tarea</label>
                <input type="text" name="title" class="form-control" placeholder="Ej: Brief creativo" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Inicio</label>
                <input type="date" name="start_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Entrega</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Avance (%)</label>
                <input type="number" name="progress_percent" class="form-control" min="0" max="100" step="1" value="0" required>
            </div>
            <div class="col-md-9 d-flex align-items-end">
                <div class="text-muted fs-sm">
                    El avance total del proyecto se calcula sumando el porcentaje de cada tarea (máximo 100%).
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Agregar tarea</button>
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
