<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="card-title mb-1">Órdenes de venta</h4>
            <p class="text-muted mb-0">Controla órdenes confirmadas y en ejecución para cada cliente.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal">Nueva orden</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Cliente</th>
                        <th>Brief</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay órdenes de venta registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo e($order['order_number']); ?></td>
                                <td><?php echo e($order['client_name'] ?? ''); ?></td>
                                <td><?php echo e($order['brief_title'] ?? '-'); ?></td>
                                <td><?php echo e($order['order_date']); ?></td>
                                <td>
                                    <?php $status = $order['status'] ?? 'pendiente'; ?>
                                    <span class="badge bg-<?php echo $status === 'finalizada' ? 'success' : ($status === 'en_ejecucion' ? 'info' : ($status === 'confirmada' ? 'primary' : 'warning')); ?>-subtle text-<?php echo $status === 'finalizada' ? 'success' : ($status === 'en_ejecucion' ? 'info' : ($status === 'confirmada' ? 'primary' : 'warning')); ?>">
                                        <?php echo e(str_replace('_', ' ', $status)); ?>
                                    </span>
                                </td>
                                <td class="text-end"><?php echo e(format_currency((float)($order['total'] ?? 0))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="index.php?route=crm/orders/store">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Nueva orden de venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="order-client">Cliente</label>
                            <select class="form-select" id="order-client" name="client_id" required>
                                <option value="">Selecciona cliente</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?php echo (int)$client['id']; ?>"><?php echo e($client['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="order-brief">Brief asociado</label>
                            <select class="form-select" id="order-brief" name="brief_id">
                                <option value="">Sin brief</option>
                                <?php foreach ($briefs as $brief): ?>
                                    <option value="<?php echo (int)$brief['id']; ?>"><?php echo e($brief['title']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="order-number">Número de orden</label>
                            <input type="text" class="form-control" id="order-number" name="order_number" placeholder="Ej: OV-2025-001" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="order-date">Fecha</label>
                            <input type="date" class="form-control" id="order-date" name="order_date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="order-total">Total (CLP)</label>
                            <input type="number" class="form-control" id="order-total" name="total" min="0" step="0.01" placeholder="Ej: 1800000" inputmode="decimal" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="order-currency">Moneda</label>
                            <select class="form-select" id="order-currency" name="currency">
                                <option value="CLP" selected>CLP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="order-status">Estado</label>
                            <select class="form-select" id="order-status" name="status">
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="en_ejecucion">En ejecución</option>
                                <option value="finalizada">Finalizada</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="order-notes">Notas</label>
                            <textarea class="form-control" id="order-notes" name="notes" rows="3" placeholder="Condiciones comerciales, alcance y responsables"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-column flex-sm-row gap-2">
                    <button type="button" class="btn btn-light w-100 w-sm-auto" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary w-100 w-sm-auto">Guardar orden</button>
                </div>
            </form>
        </div>
    </div>
</div>
