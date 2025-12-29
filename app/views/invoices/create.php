<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=invoices/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="client_id" class="form-select" required>
                        <option value="">Selecciona cliente</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>" <?php echo (int)($selectedClientId ?? 0) === (int)$client['id'] ? 'selected' : ''; ?>>
                                <?php echo e($client['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Servicio origen</label>
                    <select name="service_id" class="form-select">
                        <option value="">Sin servicio</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?php echo $service['id']; ?>"><?php echo e($service['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Proyecto origen</label>
                    <select name="project_id" class="form-select">
                        <option value="">Sin proyecto</option>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?php echo $project['id']; ?>"
                                data-project-name="<?php echo e($project['name'] ?? ''); ?>"
                                data-project-value="<?php echo e($project['value'] ?? 0); ?>"
                                <?php echo (int)($selectedProjectId ?? 0) === (int)$project['id'] ? 'selected' : ''; ?>>
                                <?php echo e($project['name']); ?> (<?php echo e($project['client_name']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Moneda</label>
                    <select name="currency_display" class="form-select" data-currency-display>
                        <option value="CLP" <?php echo ($invoiceDefaults['currency'] ?? 'CLP') === 'CLP' ? 'selected' : ''; ?>>CLP</option>
                        <option value="USD" <?php echo ($invoiceDefaults['currency'] ?? '') === 'USD' ? 'selected' : ''; ?>>USD</option>
                        <option value="EUR" <?php echo ($invoiceDefaults['currency'] ?? '') === 'EUR' ? 'selected' : ''; ?>>EUR</option>
                    </select>
                    <small class="text-muted">Referencia visual, no afecta el cálculo.</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control" value="<?php echo e($number); ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha emisión</label>
                    <input type="date" name="fecha_emision" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha vencimiento</label>
                    <input type="date" name="fecha_vencimiento" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="pendiente">Pendiente</option>
                        <option value="pagada">Pagada</option>
                        <option value="vencida">Vencida</option>
                        <option value="anulada">Anulada</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Subtotal</label>
                    <input type="number" step="0.01" name="subtotal" class="form-control" value="0" data-subtotal>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Impuestos</label>
                    <input type="number" step="0.01" name="impuestos" class="form-control" value="0" data-impuestos readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" value="0" data-total readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Impuesto (%)</label>
                    <input type="number" step="0.01" name="tax_rate" class="form-control" value="<?php echo e($invoiceDefaults['tax_rate'] ?? 0); ?>" data-tax-rate>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="apply_tax_display" id="apply_tax_display" <?php echo !empty($invoiceDefaults['apply_tax']) ? 'checked' : ''; ?> data-apply-tax>
                        <label class="form-check-label" for="apply_tax_display">Aplicar impuesto</label>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notas" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Items de factura</h5>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-add-item>Agregar item</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-2 fw-semibold text-muted small">
                        <div class="col-md-5">Descripción</div>
                        <div class="col-md-2">Cantidad</div>
                        <div class="col-md-2">Precio unitario</div>
                        <div class="col-md-3">Total</div>
                    </div>
                    <div class="row g-2 mb-2" data-item-row>
                        <div class="col-md-5">
                            <input type="text" name="items[0][descripcion]" class="form-control" placeholder="Descripción" data-item-description>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][cantidad]" class="form-control" value="1" data-item-qty>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][precio_unitario]" class="form-control" value="0" data-item-price>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="items[0][total]" class="form-control" value="0" data-item-total readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=invoices" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const subtotalInput = document.querySelector('[data-subtotal]');
    const impuestosInput = document.querySelector('[data-impuestos]');
    const totalInput = document.querySelector('[data-total]');
    const taxRateInput = document.querySelector('[data-tax-rate]');
    const applyTaxCheckbox = document.querySelector('[data-apply-tax]');
    const addItemButton = document.querySelector('[data-add-item]');
    const projectSelect = document.querySelector('select[name="project_id"]');

    const formatNumber = (value) => Math.round((Number(value) + Number.EPSILON) * 100) / 100;

    const updateItemTotal = (row) => {
        const qty = Number(row.querySelector('[data-item-qty]')?.value || 0);
        const price = Number(row.querySelector('[data-item-price]')?.value || 0);
        const totalField = row.querySelector('[data-item-total]');
        if (totalField) {
            totalField.value = formatNumber(qty * price).toFixed(2);
        }
    };

    const updateTotals = () => {
        const subtotal = Number(subtotalInput?.value || 0);
        const rate = Number(taxRateInput?.value || 0);
        const applyTax = !!applyTaxCheckbox?.checked;
        const impuestos = applyTax ? formatNumber(subtotal * (rate / 100)) : 0;
        if (impuestosInput) {
            impuestosInput.value = impuestos.toFixed(2);
        }
        if (totalInput) {
            totalInput.value = formatNumber(subtotal + impuestos).toFixed(2);
        }
    };

    const updateFromItems = () => {
        const rows = document.querySelectorAll('[data-item-row]');
        let subtotal = 0;
        rows.forEach((row) => {
            updateItemTotal(row);
            subtotal += Number(row.querySelector('[data-item-total]')?.value || 0);
        });
        if (subtotalInput) {
            subtotalInput.value = formatNumber(subtotal).toFixed(2);
        }
        updateTotals();
    };

    document.addEventListener('input', (event) => {
        if (event.target?.matches('[data-item-qty], [data-item-price]')) {
            updateFromItems();
        }
    });

    addItemButton?.addEventListener('click', () => {
        const rows = document.querySelectorAll('[data-item-row]');
        const index = rows.length;
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2';
        row.setAttribute('data-item-row', 'true');
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="items[${index}][descripcion]" class="form-control" placeholder="Descripción" data-item-description>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${index}][cantidad]" class="form-control" value="1" data-item-qty>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${index}][precio_unitario]" class="form-control" value="0" data-item-price>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${index}][total]" class="form-control" value="0" data-item-total readonly>
            </div>
        `;
        rows[rows.length - 1]?.after(row);
    });
    subtotalInput?.addEventListener('input', updateTotals);
    taxRateInput?.addEventListener('input', updateTotals);
    applyTaxCheckbox?.addEventListener('change', updateTotals);

    projectSelect?.addEventListener('change', () => {
        const selected = projectSelect.selectedOptions?.[0];
        if (!selected) {
            return;
        }
        const projectName = selected.dataset.projectName || '';
        const projectValue = Number(selected.dataset.projectValue || 0);
        const firstRow = document.querySelector('[data-item-row]');
        if (firstRow) {
            const descriptionInput = firstRow.querySelector('[data-item-description]');
            const priceInput = firstRow.querySelector('[data-item-price]');
            if (descriptionInput && descriptionInput.value.trim() === '') {
                descriptionInput.value = projectName;
            }
            if (priceInput) {
                priceInput.value = formatNumber(projectValue).toFixed(2);
            }
            updateFromItems();
        }
    });

    updateFromItems();
</script>
