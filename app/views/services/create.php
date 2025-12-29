<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=services/store" id="service-create-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="accordion" id="serviceCreateAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="serviceCreateHeadingInfo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#serviceCreateInfo" aria-expanded="true" aria-controls="serviceCreateInfo">
                            Cliente y servicio
                        </button>
                    </h2>
                    <div id="serviceCreateInfo" class="accordion-collapse collapse show" aria-labelledby="serviceCreateHeadingInfo" data-bs-parent="#serviceCreateAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente</label>
                                    <select name="client_id" class="form-select" required>
                                        <option value="">Selecciona cliente</option>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?php echo $client['id']; ?>"><?php echo e($client['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de servicio</label>
                                    <select name="service_type" class="form-select" data-service-type>
                                        <option value="dominio">Dominio</option>
                                        <option value="hosting">Hosting</option>
                                        <option value="plan">Plan mensual</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre servicio</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Costo</label>
                                    <input type="number" step="0.01" name="cost" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Moneda</label>
                                    <select name="currency" class="form-select">
                                        <option value="CLP">CLP</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="serviceCreateHeadingCycle">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#serviceCreateCycle" aria-expanded="false" aria-controls="serviceCreateCycle">
                            Ciclo y fechas
                        </button>
                    </h2>
                    <div id="serviceCreateCycle" class="accordion-collapse collapse" aria-labelledby="serviceCreateHeadingCycle" data-bs-parent="#serviceCreateAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Ciclo de cobro</label>
                                    <select name="billing_cycle" class="form-select" data-billing-cycle>
                                        <option value="mensual">Mensual</option>
                                        <option value="anual">Anual</option>
                                        <option value="unico">Único</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha inicio</label>
                                    <input type="date" name="start_date" class="form-control" data-start-date>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha vencimiento</label>
                                    <div class="input-group">
                                        <input type="date" name="due_date" class="form-control" data-due-date>
                                        <button class="btn btn-outline-secondary" type="button" data-calc-due>Calcular</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha eliminación</label>
                                    <input type="date" name="delete_date" class="form-control" data-delete-date>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Días aviso 1</label>
                                    <input type="number" name="notice_days_1" class="form-control" value="15">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Días aviso 2</label>
                                    <input type="number" name="notice_days_2" class="form-control" value="5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="serviceCreateHeadingAutomation">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#serviceCreateAutomation" aria-expanded="false" aria-controls="serviceCreateAutomation">
                            Automatización
                        </button>
                    </h2>
                    <div id="serviceCreateAutomation" class="accordion-collapse collapse" aria-labelledby="serviceCreateHeadingAutomation" data-bs-parent="#serviceCreateAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <select name="status" class="form-select">
                                        <option value="activo">Activo</option>
                                        <option value="suspendido">Suspendido</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="auto_invoice" id="auto_invoice" checked>
                                        <label class="form-check-label" for="auto_invoice">Auto facturar</label>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="auto_email" id="auto_email" checked>
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
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const billingCycleSelect = document.querySelector('[data-billing-cycle]');
    const startDateInput = document.querySelector('[data-start-date]');
    const dueDateInput = document.querySelector('[data-due-date]');
    const calcDueButton = document.querySelector('[data-calc-due]');
    const deleteDateInput = document.querySelector('[data-delete-date]');
    let dueDateTouched = false;

    const computeDueDate = () => {
        if (!startDateInput?.value || !billingCycleSelect) {
            return;
        }
        const startDate = new Date(startDateInput.value);
        if (Number.isNaN(startDate.getTime())) {
            return;
        }
        const cycle = billingCycleSelect.value;
        if (cycle === 'mensual') {
            startDate.setMonth(startDate.getMonth() + 1);
        } else if (cycle === 'anual') {
            startDate.setFullYear(startDate.getFullYear() + 1);
        } else {
            return;
        }
        const isoDate = startDate.toISOString().slice(0, 10);
        if (!dueDateTouched || !dueDateInput?.value) {
            dueDateInput.value = isoDate;
        }
        if (deleteDateInput && !deleteDateInput.value) {
            deleteDateInput.value = isoDate;
        }
    };

    dueDateInput?.addEventListener('input', () => {
        dueDateTouched = true;
    });

    billingCycleSelect?.addEventListener('change', computeDueDate);
    startDateInput?.addEventListener('change', computeDueDate);
    calcDueButton?.addEventListener('click', () => {
        dueDateTouched = false;
        computeDueDate();
    });
</script>
