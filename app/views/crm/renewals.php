<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="card-title mb-1">Renovaciones</h4>
            <p class="text-muted mb-0">Anticipa renovaciones y mantén el control de servicios activos.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#renewalModal" data-mode="create">Nueva renovación</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Fecha renovación</th>
                        <th>Estado</th>
                        <th class="text-end">Monto</th>
                        <th class="text-end">Recordatorio</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($renewals)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay renovaciones registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($renewals as $renewal): ?>
                            <tr>
                                <td class="text-muted">#<?php echo (int)$renewal['id']; ?></td>
                                <td><?php echo e($renewal['client_name'] ?? ''); ?></td>
                                <td><?php echo e($renewal['service_name'] ?? '-'); ?></td>
                                <td><?php echo e(format_date($renewal['renewal_date'])); ?></td>
                                <td>
                                    <?php $status = $renewal['status'] ?? 'pendiente'; ?>
                                    <span class="badge bg-<?php echo $status === 'renovado' ? 'success' : ($status === 'no_renovado' ? 'danger' : ($status === 'en_negociacion' ? 'warning' : 'info')); ?>-subtle text-<?php echo $status === 'renovado' ? 'success' : ($status === 'no_renovado' ? 'danger' : ($status === 'en_negociacion' ? 'warning' : 'info')); ?>">
                                        <?php echo e(str_replace('_', ' ', $status)); ?>
                                    </span>
                                </td>
                                <td class="text-end"><?php echo e(format_currency((float)($renewal['amount'] ?? 0))); ?></td>
                                <td class="text-end"><?php echo (int)($renewal['reminder_days'] ?? 0); ?> días</td>
                                <td class="text-end">
                                    <?php if (($renewal['status'] ?? '') !== 'renovado'): ?>
                                        <form method="post" action="index.php?route=crm/renewals/approve" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="id" value="<?php echo (int)$renewal['id']; ?>">
                                            <button type="submit" class="btn btn-soft-success btn-sm" onclick="return confirm('¿Aprobar esta renovación?');">Aprobar</button>
                                        </form>
                                    <?php endif; ?>
                                    <button
                                        type="button"
                                        class="btn btn-soft-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#renewalModal"
                                        data-mode="edit"
                                        data-id="<?php echo (int)$renewal['id']; ?>"
                                        data-date="<?php echo e($renewal['renewal_date']); ?>"
                                        data-status="<?php echo e($renewal['status']); ?>"
                                        data-amount="<?php echo e($renewal['amount']); ?>"
                                        data-currency="<?php echo e($renewal['currency']); ?>"
                                        data-reminder="<?php echo e($renewal['reminder_days']); ?>"
                                        data-notes="<?php echo e($renewal['notes']); ?>"
                                        data-client-id="<?php echo (int)$renewal['client_id']; ?>"
                                        data-service-id="<?php echo (int)($renewal['service_id'] ?? 0); ?>"
                                    >
                                        Editar
                                    </button>
                                    <?php if (($renewal['status'] ?? '') === 'renovado'): ?>
                                        <form method="post" action="index.php?route=crm/renewals/send-email" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="id" value="<?php echo (int)$renewal['id']; ?>">
                                            <button type="submit" class="btn btn-soft-info btn-sm" onclick="return confirm('¿Enviar correo de renovación exitosa?');">Enviar correo</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="post" action="index.php?route=crm/renewals/delete" class="d-inline" onsubmit="return confirm('¿Eliminar esta renovación?');">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" value="<?php echo (int)$renewal['id']; ?>">
                                        <button type="submit" class="btn btn-soft-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="renewalModal" tabindex="-1" aria-labelledby="renewalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="index.php?route=crm/renewals/store" id="renewal-form">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" id="renewal-id">
                <div class="modal-header">
                    <h5 class="modal-title" id="renewalModalLabel" data-renewal-modal-title>Nueva renovación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="renewal-client">Cliente</label>
                            <select class="form-select" id="renewal-client" name="client_id" data-client-select required>
                                <option value="">Selecciona cliente</option>
                                <?php foreach ($clients as $client): ?>
                                    <?php
                                    $contactName = $client['contact'] ?: $client['name'];
                                    ?>
                                    <option value="<?php echo (int)$client['id']; ?>"
                                        data-contact-name="<?php echo e($contactName); ?>"
                                        data-contact-email="<?php echo e($client['email'] ?? ''); ?>"
                                        data-contact-phone="<?php echo e($client['phone'] ?? ''); ?>"
                                        data-address="<?php echo e($client['address'] ?? ''); ?>"
                                        data-rut="<?php echo e($client['rut'] ?? ''); ?>"
                                        data-billing-email="<?php echo e($client['billing_email'] ?? ''); ?>">
                                        <?php echo e($client['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="renewal-service">Servicio</label>
                            <select class="form-select" id="renewal-service" name="service_id">
                                <option value="">Selecciona servicio</option>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?php echo (int)$service['id']; ?>"><?php echo e($service['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="renewal-date">Fecha renovación</label>
                            <input type="date" class="form-control" id="renewal-date" name="renewal_date" value="<?php echo date('Y-m-d'); ?>" data-default-date="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="renewal-amount">Monto (CLP)</label>
                            <input type="number" class="form-control" id="renewal-amount" name="amount" min="0" step="0.01" placeholder="Ej: 450000" inputmode="decimal" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="renewal-currency">Moneda</label>
                            <select class="form-select" id="renewal-currency" name="currency">
                                <option value="CLP" selected>CLP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="renewal-status">Estado</label>
                            <select class="form-select" id="renewal-status" name="status">
                                <option value="pendiente">Pendiente</option>
                                <option value="en_negociacion">En negociación</option>
                                <option value="renovado">Renovado</option>
                                <option value="no_renovado">No renovado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="renewal-reminder">Recordatorio (días)</label>
                            <input type="number" class="form-control" id="renewal-reminder" name="reminder_days" min="1" value="15">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="renewal-contact-name">Contacto cliente</label>
                            <input type="text" class="form-control" id="renewal-contact-name" name="contact_name" data-client-field="contact_name" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="renewal-contact-email">Correo contacto</label>
                            <input type="email" class="form-control" id="renewal-contact-email" name="contact_email" data-client-field="contact_email" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="renewal-contact-phone">Teléfono contacto</label>
                            <input type="text" class="form-control" id="renewal-contact-phone" name="contact_phone" data-client-field="contact_phone" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="renewal-notes">Notas</label>
                            <textarea class="form-control" id="renewal-notes" name="notes" rows="3" placeholder="Responsables, acuerdos y próximos pasos"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-column flex-sm-row gap-2">
                    <button type="button" class="btn btn-light w-100 w-sm-auto" data-bs-dismiss="modal">Cancelar</button>
                    <form method="post" action="index.php?route=crm/renewals/send-email" class="w-100 w-sm-auto d-none" id="renewal-email-form">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" id="renewal-email-id">
                        <button type="submit" class="btn btn-soft-info w-100">Enviar correo</button>
                    </form>
                    <button type="submit" class="btn btn-primary w-100 w-sm-auto" data-renewal-submit>Guardar renovación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/pages/crm-modal-forms.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('renewalModal');
    var form = document.getElementById('renewal-form');
    if (!modal || !form) return;

    var titleEl = modal.querySelector('[data-renewal-modal-title]');
    var submitBtn = modal.querySelector('[data-renewal-submit]');
    var clientSelect = document.getElementById('renewal-client');
    var serviceSelect = document.getElementById('renewal-service');
    var dateInput = document.getElementById('renewal-date');
    var statusSelect = document.getElementById('renewal-status');
    var amountInput = document.getElementById('renewal-amount');
    var currencySelect = document.getElementById('renewal-currency');
    var reminderInput = document.getElementById('renewal-reminder');
    var notesInput = document.getElementById('renewal-notes');
    var idInput = document.getElementById('renewal-id');
    var emailForm = document.getElementById('renewal-email-form');
    var emailIdInput = document.getElementById('renewal-email-id');

    var defaultDate = dateInput ? dateInput.getAttribute('data-default-date') : '';
    var updateEmailButtonVisibility = function (status, hasId) {
        if (!emailForm) return;
        if (status === 'renovado' && hasId) {
            emailForm.classList.remove('d-none');
        } else {
            emailForm.classList.add('d-none');
        }
    };

    var resetForm = function () {
        if (!form) return;
        form.reset();
        if (dateInput && defaultDate) {
            dateInput.value = defaultDate;
        }
        if (form.action) {
            form.action = 'index.php?route=crm/renewals/store';
        }
        if (idInput) {
            idInput.value = '';
        }
        if (emailIdInput) {
            emailIdInput.value = '';
        }
        if (titleEl) {
            titleEl.textContent = 'Nueva renovación';
        }
        if (submitBtn) {
            submitBtn.textContent = 'Guardar renovación';
        }
        if (emailForm) {
            emailForm.classList.add('d-none');
        }
    };

    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var mode = button ? button.getAttribute('data-mode') : 'create';

        if (!button || mode === 'create') {
            resetForm();
            return;
        }

        var id = button.getAttribute('data-id') || '';
        var date = button.getAttribute('data-date') || '';
        var status = button.getAttribute('data-status') || 'pendiente';
        var amount = button.getAttribute('data-amount') || '';
        var currency = button.getAttribute('data-currency') || 'CLP';
        var reminder = button.getAttribute('data-reminder') || '15';
        var notes = button.getAttribute('data-notes') || '';
        var clientId = button.getAttribute('data-client-id') || '';
        var serviceId = button.getAttribute('data-service-id') || '';

        if (form.action) {
            form.action = 'index.php?route=crm/renewals/update';
        }
        if (idInput) {
            idInput.value = id;
        }
        if (emailIdInput) {
            emailIdInput.value = id;
        }
        if (titleEl) {
            titleEl.textContent = 'Editar renovación';
        }
        if (submitBtn) {
            submitBtn.textContent = 'Actualizar renovación';
        }

        if (clientSelect) {
            clientSelect.value = clientId;
            clientSelect.dispatchEvent(new Event('change'));
        }
        if (serviceSelect) {
            serviceSelect.value = serviceId;
        }
        if (dateInput) {
            dateInput.value = date;
        }
        if (statusSelect) {
            statusSelect.value = status;
        }
        if (amountInput) {
            amountInput.value = amount;
        }
        if (currencySelect) {
            currencySelect.value = currency;
        }
        if (reminderInput) {
            reminderInput.value = reminder;
        }
        if (notesInput) {
            notesInput.value = notes;
        }
        if (emailForm) {
            updateEmailButtonVisibility(status, !!id);
        }
    });

    modal.addEventListener('hidden.bs.modal', function () {
        resetForm();
    });

    if (statusSelect) {
        statusSelect.addEventListener('change', function () {
            var status = statusSelect.value || 'pendiente';
            var hasId = !!(idInput && idInput.value);
            updateEmailButtonVisibility(status, hasId);
        });
    }
});
</script>
