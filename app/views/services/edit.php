<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=services/update" id="service-edit-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo $service['id'] ?? ''; ?>">
            <div class="accordion" id="serviceEditAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="serviceEditHeadingInfo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#serviceEditInfo" aria-expanded="true" aria-controls="serviceEditInfo">
                            Cliente y servicio
                        </button>
                    </h2>
                    <div id="serviceEditInfo" class="accordion-collapse collapse show" aria-labelledby="serviceEditHeadingInfo" data-bs-parent="#serviceEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente</label>
                                    <select name="client_id" class="form-select" required>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?php echo $client['id']; ?>" <?php echo $client['id'] == ($service['client_id'] ?? null) ? 'selected' : ''; ?>><?php echo e($client['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de servicio</label>
                                    <select name="service_type" class="form-select" data-service-type>
                                        <option value="dominio" <?php echo ($service['service_type'] ?? '') === 'dominio' ? 'selected' : ''; ?>>Dominio</option>
                                        <option value="hosting" <?php echo ($service['service_type'] ?? '') === 'hosting' ? 'selected' : ''; ?>>Hosting</option>
                                        <option value="plan" <?php echo ($service['service_type'] ?? '') === 'plan' ? 'selected' : ''; ?>>Plan mensual</option>
                                        <option value="otro" <?php echo ($service['service_type'] ?? '') === 'otro' ? 'selected' : ''; ?>>Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre servicio</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo e($service['name'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Costo</label>
                                    <input type="number" step="0.01" name="cost" class="form-control" value="<?php echo e($service['cost'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Moneda</label>
                                    <select name="currency" class="form-select">
                                        <option value="CLP" <?php echo ($service['currency'] ?? 'CLP') === 'CLP' ? 'selected' : ''; ?>>CLP</option>
                                        <option value="USD" <?php echo ($service['currency'] ?? '') === 'USD' ? 'selected' : ''; ?>>USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="serviceEditHeadingCycle">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#serviceEditCycle" aria-expanded="false" aria-controls="serviceEditCycle">
                            Ciclo y fechas
                        </button>
                    </h2>
                    <div id="serviceEditCycle" class="accordion-collapse collapse" aria-labelledby="serviceEditHeadingCycle" data-bs-parent="#serviceEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Ciclo de cobro</label>
                                    <select name="billing_cycle" class="form-select" data-billing-cycle>
                                        <option value="mensual" <?php echo ($service['billing_cycle'] ?? '') === 'mensual' ? 'selected' : ''; ?>>Mensual</option>
                                        <option value="anual" <?php echo ($service['billing_cycle'] ?? '') === 'anual' ? 'selected' : ''; ?>>Anual</option>
                                        <option value="unico" <?php echo ($service['billing_cycle'] ?? '') === 'unico' ? 'selected' : ''; ?>>Único</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha inicio</label>
                                    <input type="date" name="start_date" class="form-control" value="<?php echo e($service['start_date'] ?? ''); ?>" data-start-date>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha vencimiento</label>
                                    <div class="input-group">
                                        <input type="date" name="due_date" class="form-control" value="<?php echo e($service['due_date'] ?? ''); ?>" data-due-date>
                                        <button class="btn btn-outline-secondary" type="button" data-calc-due>Calcular</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha eliminación</label>
                                    <input type="date" name="delete_date" class="form-control" value="<?php echo e($service['delete_date'] ?? ''); ?>" data-delete-date>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Días aviso 1</label>
                                    <input type="number" name="notice_days_1" class="form-control" value="<?php echo e($service['notice_days_1'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Días aviso 2</label>
                                    <input type="number" name="notice_days_2" class="form-control" value="<?php echo e($service['notice_days_2'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="serviceEditHeadingAutomation">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#serviceEditAutomation" aria-expanded="false" aria-controls="serviceEditAutomation">
                            Automatización
                        </button>
                    </h2>
                    <div id="serviceEditAutomation" class="accordion-collapse collapse" aria-labelledby="serviceEditHeadingAutomation" data-bs-parent="#serviceEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <select name="status" class="form-select">
                                        <option value="activo" <?php echo ($service['status'] ?? '') === 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="suspendido" <?php echo ($service['status'] ?? '') === 'suspendido' ? 'selected' : ''; ?>>Suspendido</option>
                                        <option value="cancelado" <?php echo ($service['status'] ?? '') === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="auto_invoice" id="auto_invoice" <?php echo !empty($service['auto_invoice']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="auto_invoice">Auto facturar</label>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="auto_email" id="auto_email" <?php echo !empty($service['auto_email']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="auto_email">Auto enviar correos</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="index.php?route=services" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const serviceBillingCycleSelect = document.querySelector('[data-billing-cycle]');
    const serviceStartDateInput = document.querySelector('[data-start-date]');
    const serviceDueDateInput = document.querySelector('[data-due-date]');
    const serviceCalcDueButton = document.querySelector('[data-calc-due]');
    const serviceDeleteDateInput = document.querySelector('[data-delete-date]');
    let serviceDueDateTouched = Boolean(serviceDueDateInput?.value);

    const computeServiceDueDate = () => {
        if (!serviceStartDateInput?.value || !serviceBillingCycleSelect) {
            return;
        }
        const startDate = new Date(serviceStartDateInput.value);
        if (Number.isNaN(startDate.getTime())) {
            return;
        }
        const cycle = serviceBillingCycleSelect.value;
        if (cycle === 'mensual') {
            startDate.setMonth(startDate.getMonth() + 1);
        } else if (cycle === 'anual') {
            startDate.setFullYear(startDate.getFullYear() + 1);
        } else {
            return;
        }
        const isoDate = startDate.toISOString().slice(0, 10);
        if (!serviceDueDateTouched || !serviceDueDateInput?.value) {
            serviceDueDateInput.value = isoDate;
        }
        if (serviceDeleteDateInput && !serviceDeleteDateInput.value) {
            serviceDeleteDateInput.value = isoDate;
        }
    };

    serviceDueDateInput?.addEventListener('input', () => {
        serviceDueDateTouched = true;
    });

    serviceBillingCycleSelect?.addEventListener('change', computeServiceDueDate);
    serviceStartDateInput?.addEventListener('change', computeServiceDueDate);
    serviceCalcDueButton?.addEventListener('click', () => {
        serviceDueDateTouched = false;
        computeServiceDueDate();
    });
</script>
