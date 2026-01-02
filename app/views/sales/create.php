<?php $isPos = $isPos ?? false; ?>
<?php if ($isPos): ?>
    <style>
        .pos-compact {
            padding: 0.5rem;
        }
        .pos-compact .card {
            border: 1px solid #e7eaf0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border-radius: 12px;
            overflow: hidden;
        }
        .pos-compact .card-header,
        .pos-compact .card-body {
            padding: 0.8rem 1rem;
        }
        .pos-compact .list-group-item {
            padding: 0.65rem 0.85rem;
            border: none;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .pos-compact .list-group-item-action:hover {
            background: #f1f4ff;
            transform: translateY(-1px);
        }
        .pos-compact .table-sm> :not(caption)>*>* {
            padding: 0.45rem 0.6rem;
        }
        .pos-compact .tab-pane,
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
        .pos-hero {
            background: #ffffff;
            color: #1f2a3d;
        }
        .pos-hero .card-body {
            padding: 0.95rem 1.1rem;
        }
        .pos-hero .metric-pill {
            background: #f7f9fc;
            border-radius: 10px;
            padding: 0.55rem 0.85rem;
            min-width: 150px;
        }
        .pos-hero .metric-pill small {
            color: #6b7280;
        }
        .pos-summary {
            border-radius: 14px;
            background: #fdfefe;
            border: 1px solid #edf0f5;
            padding: 1rem;
        }
        .pos-summary .summary-row + .summary-row {
            border-top: 1px dashed #e3e7ef;
            padding-top: 0.65rem;
            margin-top: 0.65rem;
        }
        .pos-badge-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 6px;
        }
        .pos-actions {
            gap: 0.5rem;
        }
        .pos-glass {
            background: #f7f9fc;
            border: 1px solid #e7eaf0;
        }
    </style>
    <div class="row mb-3 pos-compact">
        <div class="col-12">
            <div class="card pos-hero">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center gap-4 justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="pos-badge-dot" style="background:#00b386;"></span>
                                <h5 class="mb-0 fw-semibold">Caja POS</h5>
                                <?php if (!empty($posSession)): ?>
                                    <span class="badge bg-light text-body border">Sesión abierta</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-body border">Sin abrir</span>
                                <?php endif; ?>
                            </div>
                            <p class="mb-0 small text-muted">Opera, monitorea y cierra tu caja con un header minimalista.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2 pos-actions">
                            <a href="index.php?route=products" class="btn btn-outline-secondary btn-sm text-nowrap">Inventario</a>
                            <a href="index.php?route=sales" class="btn btn-outline-secondary btn-sm text-nowrap">Historial</a>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-2">
                        <div class="metric-pill">
                            <small>Apertura</small>
                            <div class="h5 mb-0 fw-semibold"><?php echo format_currency((float)($posSession['opening_amount'] ?? 0)); ?></div>
                        </div>
                        <div class="metric-pill">
                            <small>Recaudado</small>
                            <div class="h5 mb-0 fw-semibold"><?php echo format_currency(array_sum($sessionTotals)); ?></div>
                        </div>
                        <div class="metric-pill">
                            <small>Métodos</small>
                            <div class="d-flex flex-wrap gap-1">
                                <?php if (!empty($sessionTotals)): ?>
                                    <?php foreach ($sessionTotals as $method => $total): ?>
                                        <span class="badge bg-light text-dark border-0"><?php echo e(ucfirst($method)); ?> <?php echo format_currency((float)$total); ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-white-50 small">Sin cobros aún</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <?php if (!empty($posSession)): ?>
                                <form method="post" action="index.php?route=pos/close" class="d-flex align-items-center gap-2 flex-wrap flex-sm-nowrap pos-glass p-2 rounded-3">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="number" step="0.01" min="0" name="closing_amount" class="form-control form-control-sm" placeholder="Monto cierre" required style="min-width: 160px;">
                                    <button class="btn btn-outline-danger btn-sm text-nowrap">Cerrar caja</button>
                                </form>
                            <?php else: ?>
                                <form method="post" action="index.php?route=pos/open" class="d-flex flex-wrap align-items-center gap-2 pos-glass p-2 rounded-3">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <div>
                                        <label class="form-label mb-1 small text-muted">Monto inicial</label>
                                        <input type="number" name="opening_amount" step="0.01" min="0" class="form-control form-control-sm" required>
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-auto">Abrir caja</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row align-items-stretch gy-3 pos-compact">
    <div class="col-12 col-xl-8 pos-equal-col">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="card-title mb-0"><?php echo $isPos ? 'Punto de venta' : 'Nueva venta'; ?></h4>
                    <small class="text-muted">Construye el ticket, ajusta precios y define el pago en un solo lugar.</small>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-light text-body border">Modo rápido</span>
                    <span class="badge bg-light text-primary border"><?php echo date('d M Y'); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if ($isPos && (empty($posReady) || empty($posSession))): ?>
                    <div class="alert alert-warning">Abre una caja para habilitar el punto de venta. Si ves este mensaje, verifica que las migraciones de BD estén aplicadas.</div>
                <?php endif; ?>
                <form method="post" action="index.php?route=sales/store" id="sale-form">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="channel" value="<?php echo $isPos ? 'pos' : 'venta'; ?>">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente</label>
                                    <select name="client_id" class="form-select">
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
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <label class="form-label mb-0">Productos / Servicios</label>
                                    <p class="text-muted mb-0 small">Arranca con los atajos rápidos de la derecha para llenar el ticket.</p>
                                </div>
                                <span class="badge bg-light text-secondary border">Editor interactivo</span>
                            </div>
                            <div class="table-responsive rounded-3 border bg-light">
                                <table class="table table-sm align-middle mb-0" id="sale-items-table">
                                    <thead class="table-light">
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
                            <textarea name="notes" class="form-control" rows="4" placeholder="Detalles adicionales o instrucciones"></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="pos-summary">
                                <div class="d-flex justify-content-between align-items-center summary-row">
                                    <span class="text-muted">Subtotal</span>
                                    <strong id="sale-subtotal"><?php echo format_currency(0); ?></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center summary-row">
                                    <span class="text-muted">Impuestos</span>
                                    <input type="number" name="tax" id="sale-tax" class="form-control form-control-sm w-auto" style="width: 160px;" step="0.01" min="0" value="0">
                                </div>
                                <div class="d-flex justify-content-between align-items-center summary-row">
                                    <span class="text-muted">Forma de pago</span>
                                    <select name="payment_method" class="form-select form-select-sm w-auto" style="width: 180px;">
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between align-items-center summary-row">
                                    <span class="fw-semibold">Total a cobrar</span>
                                    <span class="h5 mb-0" id="sale-total"><?php echo format_currency(0); ?></span>
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
