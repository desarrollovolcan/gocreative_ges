<?php $isPos = $isPos ?? false; ?>
<?php if ($isPos): ?>
    <div class="row mb-3">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Caja POS</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($posSession)): ?>
                        <p class="mb-1"><strong>Estado:</strong> Abierta</p>
                        <p class="mb-1"><strong>Apertura:</strong> <?php echo format_currency((float)($posSession['opening_amount'] ?? 0)); ?></p>
                        <p class="mb-1"><strong>Recaudado:</strong> <?php echo format_currency(array_sum($sessionTotals)); ?></p>
                        <?php if (!empty($sessionTotals)): ?>
                            <ul class="list-unstyled small">
                                <?php foreach ($sessionTotals as $method => $total): ?>
                                    <li><?php echo e(ucfirst($method)); ?>: <?php echo format_currency((float)$total); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <form method="post" action="index.php?route=pos/close" class="d-flex gap-2">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <input type="number" step="0.01" min="0" name="closing_amount" class="form-control" placeholder="Monto cierre" required>
                            <button class="btn btn-danger">Cerrar caja</button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="index.php?route=pos/open">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <div class="mb-2">
                                <label class="form-label">Monto inicial</label>
                                <input type="number" name="opening_amount" step="0.01" min="0" class="form-control" required>
                            </div>
                            <button class="btn btn-primary w-100">Abrir caja</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0"><?php echo $isPos ? 'Punto de venta' : 'Nueva venta'; ?></h4>
                    <?php if ($isPos): ?>
                        <small class="text-muted">Registra ventas rápidas en el punto de venta.</small>
                    <?php endif; ?>
                </div>
                <a href="index.php?route=products" class="btn btn-soft-secondary btn-sm">Ver inventario</a>
            </div>
            <div class="card-body">
                <?php if ($isPos && (empty($posReady) || empty($posSession))): ?>
                    <div class="alert alert-warning">Abre una caja para habilitar el punto de venta. Si ves este mensaje, verifica que las migraciones de BD estén aplicadas.</div>
                <?php endif; ?>
                <form method="post" action="index.php?route=sales/store" id="sale-form">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="channel" value="<?php echo $isPos ? 'pos' : 'venta'; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <select name="client_id" class="form-select" <?php echo $isPos ? '' : ''; ?>>
                                <option value="">Consumidor final</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?php echo (int)$client['id']; ?>"><?php echo e($client['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="sale_date" class="form-control" value="<?php echo e($today); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                <option value="pagado" selected>Pagado</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="borrador">Borrador</option>
                                <option value="en_espera">En espera</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Buscar por código/sku</label>
                            <input type="text" id="sku-search" class="form-control" placeholder="Escribe el código del producto" list="sku-options">
                            <datalist id="sku-options">
                                <?php foreach ($products as $product): ?>
                                    <?php if (!empty($product['sku'])): ?>
                                        <option value="<?php echo e($product['sku']); ?>"><?php echo e($product['name']); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Productos / Servicios</label>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle" id="sale-items-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Item</th>
                                            <th style="width: 15%;">Cantidad</th>
                                            <th style="width: 20%;">Precio</th>
                                            <th class="text-end" style="width: 20%;">Subtotal</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item-row">
                                            <input type="hidden" name="item_type[]" value="product" class="item-type">
                                            <input type="hidden" name="service_id[]" value="" class="service-id">
                                            <td>
                                                <select name="product_id[]" class="form-select form-select-sm product-select">
                                                    <option value="">Selecciona</option>
                                                    <?php foreach ($products as $product): ?>
                                                        <option value="<?php echo (int)$product['id']; ?>" data-price="<?php echo e((float)($product['price'] ?? 0)); ?>" data-stock="<?php echo (int)($product['stock'] ?? 0); ?>" data-sku="<?php echo e($product['sku'] ?? ''); ?>">
                                                            <?php echo e($product['name']); ?> (Stock: <?php echo (int)($product['stock'] ?? 0); ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td><input type="number" name="quantity[]" class="form-control form-control-sm quantity-input" min="1" value="1"></td>
                                            <td><input type="number" name="unit_price[]" class="form-control form-control-sm price-input" step="0.01" min="0" value="0"></td>
                                            <td class="text-end item-subtotal fw-semibold">0</td>
                                            <td><button type="button" class="btn btn-link text-danger p-0 remove-row">✕</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-sale-item">Agregar producto</button>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Notas</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Detalles adicionales o instrucciones"></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column align-items-end gap-2">
                                <div class="d-flex justify-content-between w-100">
                                    <span>Subtotal</span>
                                    <strong id="sale-subtotal"><?php echo format_currency(0); ?></strong>
                                </div>
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <span>Impuestos</span>
                                    <input type="number" name="tax" id="sale-tax" class="form-control form-control-sm w-auto" style="width: 140px;" step="0.01" min="0" value="0">
                                </div>
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <span>Forma de pago</span>
                                    <select name="payment_method" class="form-select form-select-sm w-auto" style="width: 160px;">
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between w-100">
                                    <span>Total</span>
                                    <strong id="sale-total"><?php echo format_currency(0); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary" <?php echo ($isPos && (empty($posSession) || empty($posReady))) ? 'disabled' : ''; ?>><?php echo $isPos ? 'Cobrar venta' : 'Guardar venta'; ?></button>
                            <button type="button" class="btn btn-outline-secondary" id="mark-hold" <?php echo ($isPos && (empty($posSession) || empty($posReady))) ? 'disabled' : ''; ?>>Marcar en espera</button>
                            <a href="index.php?route=<?php echo $isPos ? 'pos' : 'sales'; ?>" class="btn btn-light ms-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-products" data-bs-toggle="tab" data-bs-target="#pane-products" type="button" role="tab">Productos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-services" data-bs-toggle="tab" data-bs-target="#pane-services" type="button" role="tab">Servicios</button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pane-products" role="tabpanel" aria-labelledby="tab-products">
                        <div class="p-2">
                            <input type="text" class="form-control form-control-sm mb-2" id="search-products" placeholder="Buscar producto">
                        </div>
                        <div class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
                            <?php foreach ($products as $product): ?>
                                <button type="button"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center add-product"
                                        data-product-id="<?php echo (int)$product['id']; ?>"
                                        data-price="<?php echo e((float)($product['price'] ?? 0)); ?>"
                                        data-name="<?php echo e(strtolower($product['name'] ?? '')); ?>">
                                    <span>
                                        <?php echo e($product['name']); ?>
                                        <?php if (!empty($product['sku'])): ?>
                                            <small class="text-muted ms-1">(#<?php echo e($product['sku']); ?>)</small>
                                        <?php endif; ?>
                                    </span>
                                    <span class="badge bg-light text-body"><?php echo format_currency((float)($product['price'] ?? 0)); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pane-services" role="tabpanel" aria-labelledby="tab-services">
                        <div class="p-2">
                            <input type="text" class="form-control form-control-sm mb-2" id="search-services" placeholder="Buscar servicio">
                        </div>
                        <div class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
                            <?php foreach ($services as $service): ?>
                                <button type="button"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center add-service"
                                        data-service-id="<?php echo (int)$service['id']; ?>"
                                        data-price="<?php echo e((float)($service['cost'] ?? 0)); ?>"
                                        data-name="<?php echo e(strtolower($service['name'] ?? '')); ?>">
                                    <span><?php echo e($service['name']); ?></span>
                                    <span class="badge bg-light text-body"><?php echo format_currency((float)($service['cost'] ?? 0)); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const tableBody = document.querySelector('#sale-items-table tbody');
        const addButton = document.getElementById('add-sale-item');
        const subtotalDisplay = document.getElementById('sale-subtotal');
        const totalDisplay = document.getElementById('sale-total');
        const taxInput = document.getElementById('sale-tax');
        const skuInput = document.getElementById('sku-search');
        const statusSelect = document.querySelector('select[name=\"status\"]');
        const holdButton = document.getElementById('mark-hold');
        const productSelectors = document.querySelectorAll('.add-product');
        const serviceSelectors = document.querySelectorAll('.add-service');
        const searchProducts = document.getElementById('search-products');
        const searchServices = document.getElementById('search-services');

        function formatCurrency(amount) {
            return new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP', minimumFractionDigits: 0 }).format(amount || 0);
        }

        function recalc() {
            let subtotal = 0;
            tableBody.querySelectorAll('.item-row').forEach((row) => {
                const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const total = qty * price;
                subtotal += total;
                row.querySelector('.item-subtotal').innerText = formatCurrency(total);
            });
            subtotalDisplay.innerText = formatCurrency(subtotal);
            const tax = parseFloat(taxInput.value) || 0;
            totalDisplay.innerText = formatCurrency(subtotal + tax);
        }

        function addRow() {
            const template = tableBody.querySelector('.item-row');
            const clone = template.cloneNode(true);
            clone.querySelectorAll('input').forEach((input) => {
                input.value = input.classList.contains('quantity-input') ? '1' : '0';
            });
            clone.querySelector('.product-select').selectedIndex = 0;
            clone.querySelector('.item-type').value = 'product';
            clone.querySelector('.service-id').value = '';
            clone.querySelector('.item-subtotal').innerText = formatCurrency(0);
            tableBody.appendChild(clone);
            return clone;
        }

        tableBody.addEventListener('change', (event) => {
            if (event.target.classList.contains('product-select')) {
                const selected = event.target.selectedOptions[0];
                const price = selected?.dataset.price || 0;
                const row = event.target.closest('.item-row');
                row.querySelector('.price-input').value = price;
            }
            recalc();
        });

        tableBody.addEventListener('input', (event) => {
            if (event.target.classList.contains('quantity-input') || event.target.classList.contains('price-input')) {
                recalc();
            }
        });

        tableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-row')) {
                const rows = tableBody.querySelectorAll('.item-row');
                if (rows.length > 1) {
                    event.target.closest('.item-row').remove();
                    recalc();
                }
            }
        });

        addButton?.addEventListener('click', addRow);
        taxInput?.addEventListener('input', recalc);
        skuInput?.addEventListener('change', () => {
            const skuValue = skuInput.value.trim();
            if (!skuValue) return;
            const firstRow = tableBody.querySelector('.item-row');
            const select = firstRow.querySelector('.product-select');
            let matched = false;
            select.querySelectorAll('option').forEach((option) => {
                if ((option.dataset.sku || '').toLowerCase() === skuValue.toLowerCase()) {
                    option.selected = true;
                    const price = option.dataset.price || 0;
                    firstRow.querySelector('.price-input').value = price;
                    matched = true;
                }
            });
            if (matched) {
                recalc();
            }
        });
        holdButton?.addEventListener('click', () => {
            if (statusSelect) {
                statusSelect.value = 'en_espera';
            }
        });
        productSelectors.forEach((button) => {
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                const price = button.dataset.price || 0;
                let targetRow = tableBody.querySelector('.item-row');
                const select = targetRow.querySelector('.product-select');
                const hasSelection = select.value;
                if (hasSelection) {
                    targetRow = addRow();
                }
                const rowSelect = targetRow.querySelector('.product-select');
                rowSelect.value = productId;
                targetRow.querySelector('.item-type').value = 'product';
                targetRow.querySelector('.service-id').value = '';
                targetRow.querySelector('.price-input').value = price;
                recalc();
            });
        });
        const serviceSelectors = document.querySelectorAll('.add-service');
        serviceSelectors.forEach((button) => {
            button.addEventListener('click', () => {
                const serviceId = button.dataset.serviceId;
                const price = button.dataset.price || 0;
                let targetRow = tableBody.querySelector('.item-row');
                const select = targetRow.querySelector('.product-select');
                const hasSelection = select.value || targetRow.querySelector('.service-id').value;
                if (hasSelection) {
                    targetRow = addRow();
                }
                targetRow.querySelector('.product-select').value = '';
                targetRow.querySelector('.service-id').value = serviceId;
                targetRow.querySelector('.item-type').value = 'service';
                targetRow.querySelector('.price-input').value = price;
                recalc();
            });
        });
        const searchProducts = document.getElementById('search-products');
        const searchServices = document.getElementById('search-services');
        function filterList(input, elements) {
            const term = (input?.value || '').toLowerCase();
            elements.forEach((el) => {
                const name = (el.dataset.name || '').toLowerCase();
                el.style.display = name.includes(term) ? '' : 'none';
            });
        }
        searchProducts?.addEventListener('input', () => filterList(searchProducts, productSelectors));
        searchServices?.addEventListener('input', () => filterList(searchServices, serviceSelectors));
        recalc();
    })();
</script>
