<?php $isPos = $isPos ?? false; ?>
<?php if ($isPos): ?>
    <style>
        .pos-compact .card-header,
        .pos-compact .card-body {
            padding: 0.75rem 1rem;
        }
        .pos-compact .list-group-item {
            padding: 0.5rem 0.75rem;
            width: 100%;
        }
        .pos-compact .table-sm> :not(caption)>*>* {
            padding: 0.4rem 0.5rem;
        }
        .pos-compact .tab-pane {
            width: 100%;
        }
        .pos-compact .tab-content {
            width: 100%;
        }
        .pos-compact .card.h-100 {
            height: 100%;
        }
        .pos-compact .pos-equal-col {
            display: flex;
        }
        .pos-compact .pos-equal-col > .card {
            flex: 1 1 auto;
            height: 100%;
        }
        .pos-compact .tab-pane .list-group-item-action > span:first-child {
            display: inline-flex;
            align-items: flex-start;
            gap: 6px;
            width: 100%;
            text-align: left;
        }
        .pos-compact .tab-pane .list-group-item-action .badge {
            flex-shrink: 0;
        }
    </style>
    <div class="row mb-3 pos-compact">
        <div class="col-12">
            <div class="card" style="min-height: 120px;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Caja POS</h5>
                    <?php if (!empty($posSession)): ?>
                        <span class="badge bg-success">Abierta</span>
                    <?php endif; ?>
                </div>
                <div class="card-body py-3">
                    <?php if (!empty($posSession)): ?>
                        <div class="d-flex flex-wrap align-items-center gap-4">
                            <div>
                                <div class="text-muted small">Apertura</div>
                                <div class="fw-semibold"><?php echo format_currency((float)($posSession['opening_amount'] ?? 0)); ?></div>
                            </div>
                            <div>
                                <div class="text-muted small">Recaudado</div>
                                <div class="fw-semibold"><?php echo format_currency(array_sum($sessionTotals)); ?></div>
                            </div>
                            <?php if (!empty($sessionTotals)): ?>
                                <div class="d-flex flex-wrap gap-2 small">
                                    <?php foreach ($sessionTotals as $method => $total): ?>
                                        <span class="d-inline-flex align-items-center gap-1 badge bg-light text-body border">
                                            <?php echo e(ucfirst($method)); ?>: <?php echo format_currency((float)$total); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post" action="index.php?route=pos/close" class="d-flex align-items-center gap-2 ms-auto flex-wrap flex-sm-nowrap">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <input type="number" step="0.01" min="0" name="closing_amount" class="form-control" placeholder="Monto cierre" required style="min-width: 140px;">
                                <button class="btn btn-danger text-nowrap">Cerrar caja</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <form method="post" action="index.php?route=pos/open" class="d-flex flex-wrap align-items-center gap-3">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <div>
                                <label class="form-label mb-1">Monto inicial</label>
                                <input type="number" name="opening_amount" step="0.01" min="0" class="form-control" required>
                            </div>
                            <button class="btn btn-primary">Abrir caja</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row align-items-stretch gy-3 pos-compact">
    <div class="col-12 col-xl-8 pos-equal-col">
        <div class="card h-100">
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
                        <div class="col-12">
                            <label class="form-label">Productos / Servicios</label>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle" id="sale-items-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 45%;">Item</th>
                                            <th style="width: 15%;">Cantidad</th>
                                            <th style="width: 20%;">Precio</th>
                                            <th class="text-end" style="width: 15%;">Subtotal</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="sale-items-body"></tbody>
                                </table>
                            </div>
                        </div>
                        <template id="sale-item-template">
                            <tr class="item-row">
                                <input type="hidden" name="item_type[]" value="product" class="item-type">
                                <input type="hidden" name="product_id[]" value="" class="product-id">
                                <input type="hidden" name="service_id[]" value="" class="service-id">
                                <td class="item-name fw-semibold text-wrap"></td>
                                <td><input type="number" name="quantity[]" class="form-control form-control-sm quantity-input" min="1" value="1"></td>
                                <td><input type="number" name="unit_price[]" class="form-control form-control-sm price-input" step="0.01" min="0" value="0"></td>
                                <td class="text-end item-subtotal fw-semibold">0</td>
                                <td><button type="button" class="btn btn-link text-danger p-0 remove-row" aria-label="Eliminar">✕</button></td>
                            </tr>
                        </template>
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
    <div class="col-12 col-xl-4 pos-equal-col">
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
            <div class="card-body p-0 d-flex flex-column">
                <div class="tab-content flex-grow-1 d-flex">
                    <div class="tab-pane fade show active d-flex flex-column w-100" id="pane-products" role="tabpanel" aria-labelledby="tab-products">
                        <div class="p-2">
                            <input type="text" class="form-control form-control-sm w-100" id="search-products" placeholder="Buscar producto">
                        </div>
                        <div class="list-group list-group-flush flex-grow-1 overflow-auto w-100">
                            <?php foreach ($products as $product): ?>
                                <button type="button"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center add-product w-100"
                                        data-product-id="<?php echo (int)$product['id']; ?>"
                                        data-price="<?php echo e((float)($product['price'] ?? 0)); ?>"
                                        data-name="<?php echo e(strtolower($product['name'] ?? '')); ?>"
                                        data-label="<?php echo e($product['name']); ?>">
                                    <span class="flex-grow-1">
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
                    <div class="tab-pane fade d-flex flex-column w-100" id="pane-services" role="tabpanel" aria-labelledby="tab-services">
                        <div class="p-2">
                            <input type="text" class="form-control form-control-sm w-100" id="search-services" placeholder="Buscar servicio">
                        </div>
                        <div class="list-group list-group-flush flex-grow-1 overflow-auto w-100">
                            <?php foreach ($services as $service): ?>
                                <button type="button"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center add-service w-100"
                                        data-service-id="<?php echo (int)$service['id']; ?>"
                                        data-price="<?php echo e((float)($service['cost'] ?? 0)); ?>"
                                        data-name="<?php echo e(strtolower($service['name'] ?? '')); ?>"
                                        data-label="<?php echo e($service['name']); ?>">
                                    <span class="flex-grow-1"><?php echo e($service['name']); ?></span>
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
<?php if ($isPos): ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Historial de ventas (sesión activa)</h5>
                        <small class="text-muted">Ventas recientes vinculadas a la caja abierta.</small>
                    </div>
                    <a href="index.php?route=sales" class="btn btn-soft-secondary btn-sm">Ver todas</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentSessionSales)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentSessionSales as $sale): ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo e($sale['numero']); ?></td>
                                            <td><?php echo e($sale['client_name'] ?? 'Consumidor final'); ?></td>
                                            <td><?php echo e(date('d/m/Y', strtotime((string)$sale['sale_date']))); ?></td>
                                            <td class="text-end"><?php echo format_currency((float)($sale['total'] ?? 0)); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-body border text-capitalize"><?php echo e(str_replace('_', ' ', $sale['status'] ?? '')); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-inline-flex align-items-center gap-1">
                                                    <a href="index.php?route=sales/show&id=<?php echo (int)($sale['id'] ?? 0); ?>" class="btn btn-soft-primary btn-sm" title="Ver">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="index.php?route=sales/show&id=<?php echo (int)($sale['id'] ?? 0); ?>" class="btn btn-soft-secondary btn-sm" title="Editar">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                    <form action="index.php?route=sales/delete" method="post" class="d-inline">
                                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                        <input type="hidden" name="sale_id" value="<?php echo (int)($sale['id'] ?? 0); ?>">
                                                        <input type="hidden" name="origin" value="pos">
                                                        <button type="submit" class="btn btn-soft-danger btn-sm" onclick="return confirm('¿Eliminar esta venta?');" title="Eliminar">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">Aún no hay ventas registradas en esta sesión.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    (function() {
        const tableBody = document.getElementById('sale-items-body');
        const rowTemplate = document.getElementById('sale-item-template');
        const subtotalDisplay = document.getElementById('sale-subtotal');
        const totalDisplay = document.getElementById('sale-total');
        const taxInput = document.getElementById('sale-tax');
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

        function addRow({ type, productId = '', serviceId = '', price = 0, name = '' }) {
            if (!rowTemplate?.content) return null;
            const clone = rowTemplate.content.cloneNode(true);
            const row = clone.querySelector('.item-row');
            row.querySelector('.item-type').value = type;
            row.querySelector('.product-id').value = productId;
            row.querySelector('.service-id').value = serviceId;
            row.querySelector('.price-input').value = price;
            row.querySelector('.item-name').innerText = name || 'Item';
            row.querySelector('.quantity-input').value = 1;
            tableBody.appendChild(clone);
            recalc();
            return row;
        }

        tableBody.addEventListener('input', (event) => {
            if (event.target.classList.contains('quantity-input') || event.target.classList.contains('price-input')) {
                recalc();
            }
        });

        tableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-row')) {
                event.target.closest('.item-row')?.remove();
                recalc();
            }
        });

        taxInput?.addEventListener('input', recalc);
        holdButton?.addEventListener('click', () => {
            if (statusSelect) {
                statusSelect.value = 'en_espera';
            }
        });
        productSelectors.forEach((button) => {
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                const price = button.dataset.price || 0;
                const name = button.dataset.label || button.innerText.trim();
                addRow({
                    type: 'product',
                    productId,
                    serviceId: '',
                    price,
                    name,
                });
            });
        });
        serviceSelectors.forEach((button) => {
            button.addEventListener('click', () => {
                const serviceId = button.dataset.serviceId;
                const price = button.dataset.price || 0;
                const name = button.dataset.label || button.innerText.trim();
                addRow({
                    type: 'service',
                    productId: '',
                    serviceId,
                    price,
                    name,
                });
            });
        });
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
