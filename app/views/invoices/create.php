<div class="card">
    <div class="card-body">
        <?php if (!empty($selectedProjectId) && ($projectInvoiceCount ?? 0) > 0): ?>
            <div class="alert alert-warning">
                Este proyecto ya tiene <?php echo (int)$projectInvoiceCount; ?> factura(s) asociada(s). Revisa antes de crear una nueva.
            </div>
        <?php endif; ?>
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
                    <label class="form-label">Servicio a facturar</label>
                    <select name="service_id" class="form-select" data-service-select data-prefill-id="<?php echo (int)($selectedServiceId ?? 0); ?>">
                        <option value="">Sin servicio</option>
                        <?php foreach ($billableServices as $service): ?>
                            <option value="<?php echo $service['id']; ?>"
                                data-client-id="<?php echo $service['client_id']; ?>"
                                data-service-name="<?php echo e($service['name'] ?? ''); ?>"
                                data-service-cost="<?php echo e($service['cost'] ?? 0); ?>"
                                data-service-due="<?php echo e($service['due_date'] ?? ''); ?>"
                                <?php echo (int)($selectedServiceId ?? 0) === (int)$service['id'] ? 'selected' : ''; ?>>
                                <?php echo e($service['name']); ?> (<?php echo e($service['client_name']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Solo se muestran servicios sin factura.</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Proyecto origen</label>
                    <select name="project_id" class="form-select" data-project-select data-prefill-id="<?php echo (int)($selectedProjectId ?? 0); ?>">
                        <option value="">Sin proyecto</option>
                        <?php foreach ($billableProjects as $project): ?>
                            <option value="<?php echo $project['id']; ?>"
                                data-client-id="<?php echo $project['client_id'] ?? ''; ?>"
                                data-project-name="<?php echo e($project['name'] ?? ''); ?>"
                                data-project-value="<?php echo e($project['value'] ?? 0); ?>"
                                data-project-delivery="<?php echo e($project['delivery_date'] ?? ''); ?>"
                                <?php echo (int)($selectedProjectId ?? 0) === (int)$project['id'] ? 'selected' : ''; ?>>
                                <?php echo e($project['name']); ?> (<?php echo e($project['client_name']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Proyectos finalizados sin facturas previas.</small>
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
                    <div class="mt-2">
                        <span class="badge" data-due-indicator>Sin fecha</span>
                    </div>
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
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notas" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <h5 class="card-title mb-0">Items de factura</h5>
                        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 text-nowrap">
                            <button type="button" class="btn btn-outline-secondary btn-sm py-1 px-2" data-add-manual-item>Agregar item manual</button>
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select form-select-sm py-1" data-service-item-select>
                                    <option value="">Selecciona servicio</option>
                                    <?php foreach ($catalogServices as $service): ?>
                                        <option value="<?php echo $service['id']; ?>" data-service-price="<?php echo e($service['cost'] ?? 0); ?>">
                                            <?php echo e($service['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2" data-add-service-item>Agregar servicio</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-2 fw-semibold text-muted small">
                        <div class="col-md-3">Descripción</div>
                        <div class="col-md-2">Cantidad</div>
                        <div class="col-md-2">Precio unitario</div>
                        <div class="col-md-2">Impuesto %</div>
                        <div class="col-md-2">Impuesto $</div>
                        <div class="col-md-1">Total</div>
                    </div>
                    <div class="row g-2 mb-2" data-item-row>
                        <div class="col-md-3">
                            <input type="text" name="items[0][descripcion]" class="form-control" placeholder="Descripción" data-item-description>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][cantidad]" class="form-control" value="1" data-item-qty>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][precio_unitario]" class="form-control" value="0" data-item-price>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][impuesto_pct]" class="form-control" value="<?php echo e($invoiceDefaults['tax_rate'] ?? 0); ?>" data-item-tax-rate>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][impuesto_monto]" class="form-control" value="0" data-item-tax readonly>
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="items[0][total]" class="form-control" value="0" data-item-total readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
                <div class="col-md-2 mb-3">
                    <label class="form-label">Subtotal</label>
                    <input type="number" step="0.01" name="subtotal" class="form-control" value="0" data-subtotal readonly>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Impuestos</label>
                    <input type="number" step="0.01" name="impuestos" class="form-control" value="0" data-impuestos readonly>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" value="0" data-total readonly>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=invoices" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="billablePickerModal" tabindex="-1" aria-labelledby="billablePickerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billablePickerLabel">Selecciona elementos a facturar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">Se muestran servicios sin facturar y proyectos finalizados sin factura para el cliente seleccionado.</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6 class="d-flex justify-content-between align-items-center">
                            Servicios
                            <span class="badge bg-primary" data-count-services>0</span>
                        </h6>
                        <div class="list-group small" data-picker-services></div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="d-flex justify-content-between align-items-center">
                            Proyectos
                            <span class="badge bg-primary" data-count-projects>0</span>
                        </h6>
                        <div class="list-group small" data-picker-projects></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const subtotalInput = document.querySelector('[data-subtotal]');
    const impuestosInput = document.querySelector('[data-impuestos]');
    const totalInput = document.querySelector('[data-total]');
    const taxRateInput = document.querySelector('[data-tax-rate]');
    const applyTaxCheckbox = document.querySelector('[data-apply-tax]');
    const addManualItemButton = document.querySelector('[data-add-manual-item]');
    const addServiceItemButton = document.querySelector('[data-add-service-item]');
    const serviceItemSelect = document.querySelector('[data-service-item-select]');
    const projectSelect = document.querySelector('[data-project-select]');
    const clientSelect = document.querySelector('select[name="client_id"]');
    const serviceSelect = document.querySelector('[data-service-select]');
    const dueDateInput = document.querySelector('input[name="fecha_vencimiento"]');
    const dueIndicator = document.querySelector('[data-due-indicator]');
    const billableServices = <?php echo json_encode($billableServices ?? []); ?>;
    const billableProjects = <?php echo json_encode($billableProjects ?? []); ?>;
    const prefillService = <?php echo json_encode($prefillService ?? null); ?>;
    const billableModalElement = document.getElementById('billablePickerModal');
    const billableModal = billableModalElement ? new bootstrap.Modal(billableModalElement) : null;
    const pickerServices = document.querySelector('[data-picker-services]');
    const pickerProjects = document.querySelector('[data-picker-projects]');
    const badgeServices = document.querySelector('[data-count-services]');
    const badgeProjects = document.querySelector('[data-count-projects]');

    const formatNumber = (value) => Math.round((Number(value) + Number.EPSILON) * 100) / 100;

    const updateItemTotal = (row) => {
        const qty = Number(row.querySelector('[data-item-qty]')?.value || 0);
        const price = Number(row.querySelector('[data-item-price]')?.value || 0);
        const totalField = row.querySelector('[data-item-total]');
        const taxRateField = row.querySelector('[data-item-tax-rate]');
        const taxField = row.querySelector('[data-item-tax]');
        const taxRate = Number(taxRateField?.value || 0);
        const applyTax = !!applyTaxCheckbox?.checked;
        const rowSubtotal = formatNumber(qty * price);
        if (totalField) {
            totalField.value = rowSubtotal.toFixed(2);
        }
        if (taxField) {
            const taxAmount = applyTax ? formatNumber(rowSubtotal * (taxRate / 100)) : 0;
            taxField.value = taxAmount.toFixed(2);
        }
    };

    const updateTotals = () => {
        const subtotal = Number(subtotalInput?.value || 0);
        const impuestos = Number(impuestosInput?.value || 0);
        if (totalInput) {
            totalInput.value = formatNumber(subtotal + impuestos).toFixed(2);
        }
    };

    const updateFromItems = () => {
        const rows = document.querySelectorAll('[data-item-row]');
        let subtotal = 0;
        let taxes = 0;
        rows.forEach((row) => {
            updateItemTotal(row);
            subtotal += Number(row.querySelector('[data-item-total]')?.value || 0);
            taxes += Number(row.querySelector('[data-item-tax]')?.value || 0);
        });
        if (subtotalInput) {
            subtotalInput.value = formatNumber(subtotal).toFixed(2);
        }
        if (impuestosInput) {
            impuestosInput.value = formatNumber(taxes).toFixed(2);
        }
        updateTotals();
    };

    document.addEventListener('input', (event) => {
        if (event.target?.matches('[data-item-qty], [data-item-price], [data-item-tax-rate]')) {
            updateFromItems();
        }
    });

    const addItemRow = ({ description = '', price = 0 } = {}) => {
        const rows = document.querySelectorAll('[data-item-row]');
        const index = rows.length;
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2';
        row.setAttribute('data-item-row', 'true');
        const defaultTaxRate = Number(taxRateInput?.value || 0);
        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="items[${index}][descripcion]" class="form-control" placeholder="Descripción" data-item-description value="${description}">
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${index}][cantidad]" class="form-control" value="1" data-item-qty>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${index}][precio_unitario]" class="form-control" value="${formatNumber(price).toFixed(2)}" data-item-price>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${index}][impuesto_pct]" class="form-control" value="${defaultTaxRate}" data-item-tax-rate>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${index}][impuesto_monto]" class="form-control" value="0" data-item-tax readonly>
            </div>
            <div class="col-md-1">
                <input type="number" name="items[${index}][total]" class="form-control" value="0" data-item-total readonly>
            </div>
        `;
        rows[rows.length - 1]?.after(row);
        updateFromItems();
    };

    addManualItemButton?.addEventListener('click', () => {
        addItemRow();
    });

    addServiceItemButton?.addEventListener('click', () => {
        const selected = serviceItemSelect?.selectedOptions?.[0];
        if (!selected || !selected.value) {
            return;
        }
        addItemRow({
            description: selected.textContent?.trim() || '',
            price: Number(selected.dataset.servicePrice || 0),
        });
        serviceItemSelect.value = '';
    });

    const applyLineFromData = ({ description = '', price = 0, qtyReadOnly = false }) => {
        const firstRow = document.querySelector('[data-item-row]');
        if (!firstRow) {
            return;
        }
        const descriptionInput = firstRow.querySelector('[data-item-description]');
        const priceInput = firstRow.querySelector('[data-item-price]');
        const qtyInput = firstRow.querySelector('[data-item-qty]');
        const taxRateInputRow = firstRow.querySelector('[data-item-tax-rate]');
        if (descriptionInput) {
            descriptionInput.value = description;
        }
        if (priceInput) {
            priceInput.value = formatNumber(price).toFixed(2);
        }
        if (qtyInput) {
            qtyInput.value = '1';
            qtyInput.readOnly = qtyReadOnly;
        }
        if (taxRateInputRow) {
            taxRateInputRow.value = taxRateInput?.value || '0';
        }
        updateFromItems();
    };

    const fillFromProject = () => {
        const selected = projectSelect?.selectedOptions?.[0];
        if (!selected || !selected.value) {
            return;
        }
        const projectName = selected.dataset.projectName || '';
        const projectValue = Number(selected.dataset.projectValue || 0);
        const projectClientId = selected.dataset.clientId || '';
        const projectDelivery = selected.dataset.projectDelivery || '';
        applyLineFromData({ description: projectName, price: projectValue, qtyReadOnly: true });
        if (clientSelect && projectClientId) {
            clientSelect.value = projectClientId;
        }
        if (dueDateInput && projectDelivery) {
            dueDateInput.value = projectDelivery;
            updateDueIndicator();
        }
    };

    projectSelect?.addEventListener('change', fillFromProject);

    const fillFromService = () => {
        const selected = serviceSelect?.selectedOptions?.[0];
        if (!selected || !selected.value) {
            return;
        }
        const serviceName = selected.dataset.serviceName || '';
        const serviceCost = Number(selected.dataset.serviceCost || 0);
        const serviceClientId = selected.dataset.clientId || '';
        const serviceDue = selected.dataset.serviceDue || '';
        applyLineFromData({ description: serviceName, price: serviceCost, qtyReadOnly: true });
        if (clientSelect && serviceClientId) {
            clientSelect.value = serviceClientId;
        }
        if (dueDateInput && serviceDue) {
            dueDateInput.value = serviceDue;
            updateDueIndicator();
        }
    };

    serviceSelect?.addEventListener('change', fillFromService);

    taxRateInput?.addEventListener('input', () => {
        document.querySelectorAll('[data-item-tax-rate]').forEach((input) => {
            input.value = taxRateInput.value;
        });
        updateFromItems();
    });

    applyTaxCheckbox?.addEventListener('change', () => {
        updateFromItems();
    });

    const filterOptionsByClient = (select, items, labelKey, valueKey) => {
        if (!select) {
            return;
        }
        const clientId = Number(clientSelect?.value || 0);
        select.innerHTML = '<option value="">Sin ' + labelKey + '</option>';
        items.forEach((item) => {
            if (clientId > 0 && Number(item.client_id) !== clientId) {
                return;
            }
            const option = document.createElement('option');
            option.value = item[valueKey];
            if (item.client_id) {
                option.dataset.clientId = item.client_id;
            }
            if (item.name) {
                option.dataset.projectName = item.name;
                option.dataset.serviceName = item.name;
            }
            if (item.value) {
                option.dataset.projectValue = item.value;
            }
            if (item.delivery_date) {
                option.dataset.projectDelivery = item.delivery_date;
            }
            if (item.cost) {
                option.dataset.serviceCost = item.cost;
            }
            if (item.due_date) {
                option.dataset.serviceDue = item.due_date;
            }
            if (item.client_name) {
                option.textContent = `${item.name} (${item.client_name})`;
            } else {
                option.textContent = item.name;
            }
            if (Number(valueKey === 'id' ? item.id : item[valueKey]) === Number(select.dataset.prefillId || 0)) {
                option.selected = true;
            }
            select.appendChild(option);
        });
    };

    clientSelect?.addEventListener('change', () => {
        filterOptionsByClient(serviceSelect, billableServices, 'servicio', 'id');
        filterOptionsByClient(projectSelect, billableProjects, 'proyecto', 'id');
    });

    const updateDueIndicator = () => {
        if (!dueDateInput || !dueIndicator) {
            return;
        }
        const dueDate = new Date(dueDateInput.value);
        if (Number.isNaN(dueDate.getTime())) {
            dueIndicator.textContent = 'Sin fecha';
            dueIndicator.className = 'badge';
            return;
        }
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        dueDate.setHours(0, 0, 0, 0);
        const diffDays = Math.round((dueDate - today) / (1000 * 60 * 60 * 24));
        if (diffDays < 0) {
            dueIndicator.textContent = `Vencida hace ${Math.abs(diffDays)} días`;
            dueIndicator.className = 'badge bg-danger';
            return;
        }
        if (diffDays <= 10) {
            dueIndicator.textContent = `Vence en ${diffDays} días`;
            dueIndicator.className = 'badge bg-warning text-dark';
            return;
        }
        dueIndicator.textContent = `Vence en ${diffDays} días`;
        dueIndicator.className = 'badge bg-success';
    };

    dueDateInput?.addEventListener('change', updateDueIndicator);

    filterOptionsByClient(serviceSelect, billableServices, 'servicio', 'id');
    filterOptionsByClient(projectSelect, billableProjects, 'proyecto', 'id');

    if (prefillService) {
        serviceSelect.dataset.prefillId = prefillService.id ?? '';
        filterOptionsByClient(serviceSelect, billableServices, 'servicio', 'id');
        serviceSelect.value = prefillService.id ?? '';
        fillFromService();
    }
    <?php if (!empty($selectedProjectId)): ?>
    fillFromProject();
    <?php endif; ?>

    updateFromItems();
    updateDueIndicator();

    const renderPickerList = (container, items, type) => {
        if (!container) return;
        container.innerHTML = '';
        if (!items.length) {
            container.innerHTML = '<div class="text-muted px-2 py-1">Sin ' + type + ' disponibles.</div>';
            return;
        }
        items.forEach((item) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-start';
            button.dataset.itemId = item.id;
            button.dataset.itemType = type;
            button.innerHTML = `
                <div>
                    <div class="fw-semibold">${item.name}</div>
                    <div class="text-muted small">${item.client_name ?? ''}</div>
                </div>
                <div class="text-end small text-muted">
                    ${item.value ? 'Monto: ' + formatNumber(item.value) : ''}
                    ${item.cost ? 'Monto: ' + formatNumber(item.cost) : ''}
                    ${item.delivery_date ? '<div>Entrega: ' + item.delivery_date + '</div>' : ''}
                    ${item.due_date ? '<div>Vence: ' + item.due_date + '</div>' : ''}
                </div>
            `;
            button.addEventListener('click', () => {
                if (type === 'servicios') {
                    serviceSelect.value = item.id;
                    fillFromService();
                } else {
                    projectSelect.value = item.id;
                    fillFromProject();
                }
                billableModal?.hide();
            });
            container.appendChild(button);
        });
    };

    const filteredItems = (items) => {
        const clientId = Number(clientSelect?.value || 0);
        return clientId > 0 ? items.filter((item) => Number(item.client_id) === clientId) : items;
    };

    const openPickerForClient = () => {
        if (!billableModal) return;
        const servicesByClient = filteredItems(billableServices);
        const projectsByClient = filteredItems(billableProjects);
        renderPickerList(pickerServices, servicesByClient, 'servicios');
        renderPickerList(pickerProjects, projectsByClient, 'proyectos');
        if (badgeServices) badgeServices.textContent = servicesByClient.length;
        if (badgeProjects) badgeProjects.textContent = projectsByClient.length;
        if (servicesByClient.length || projectsByClient.length) {
            billableModal.show();
        }
    };

    clientSelect?.addEventListener('change', openPickerForClient);
</script>
