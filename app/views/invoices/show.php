<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Factura <?php echo e($invoice['numero']); ?></h4>
        <div class="d-flex gap-2 align-items-center">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()">Imprimir</button>
            <span class="badge bg-<?php echo $invoice['estado'] === 'pagada' ? 'success' : ($invoice['estado'] === 'vencida' ? 'danger' : 'warning'); ?>-subtle text-<?php echo $invoice['estado'] === 'pagada' ? 'success' : ($invoice['estado'] === 'vencida' ? 'danger' : 'warning'); ?>">
                <?php echo e($invoice['estado']); ?>
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Cliente:</strong> <?php echo e($client['name'] ?? ''); ?></p>
                <p><strong>Emisión:</strong> <?php echo e($invoice['fecha_emision']); ?></p>
                <p><strong>Vencimiento:</strong> <?php echo e($invoice['fecha_vencimiento']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Subtotal:</strong> <?php echo e($invoice['subtotal']); ?></p>
                <p><strong>Impuestos:</strong> <?php echo e($invoice['impuestos']); ?></p>
                <p><strong>Total:</strong> <?php echo e($invoice['total']); ?></p>
                <p><strong>Total pagado:</strong> <?php echo e($paidTotal ?? 0); ?></p>
                <p><strong>Saldo pendiente:</strong> <?php echo e($pendingTotal ?? 0); ?></p>
            </div>
        </div>
        <p><strong>Notas:</strong> <?php echo e($invoice['notas']); ?></p>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title mb-0">Items</h4></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo e($item['descripcion']); ?></td>
                            <td><?php echo e($item['cantidad']); ?></td>
                            <td><?php echo e($item['precio_unitario']); ?></td>
                            <td><?php echo e($item['total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title mb-0">Registrar pago</h4></div>
    <div class="card-body">
        <form method="post" action="index.php?route=invoices/pay">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Monto</label>
                    <input type="number" step="0.01" name="monto" class="form-control" value="<?php echo e($pendingTotal ?? $invoice['total']); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha pago</label>
                    <input type="date" name="fecha_pago" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Método</label>
                    <select name="metodo" class="form-select">
                        <option value="transferencia">Transferencia</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Referencia</label>
                    <input type="text" name="referencia" class="form-control">
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Registrar pago</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title mb-0">Pagos registrados</h4></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Método</th>
                        <th>Referencia</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo e($payment['monto']); ?></td>
                            <td><?php echo e($payment['fecha_pago']); ?></td>
                            <td><?php echo e($payment['metodo']); ?></td>
                            <td><?php echo e($payment['referencia']); ?></td>
                            <td class="text-end">
                                <button class="btn btn-soft-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#paymentEdit<?php echo $payment['id']; ?>" aria-expanded="false">
                                    Editar
                                </button>
                                <form method="post" action="index.php?route=invoices/payments/send-receipt" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                                    <button type="submit" class="btn btn-soft-success btn-sm">Enviar comprobante</button>
                                </form>
                                <form method="post" action="index.php?route=invoices/payments/delete" class="d-inline" onsubmit="return confirm('¿Eliminar este pago?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                                    <button type="submit" class="btn btn-soft-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="collapse" id="paymentEdit<?php echo $payment['id']; ?>">
                            <td colspan="5">
                                <form method="post" action="index.php?route=invoices/payments/update" class="row g-2">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                                    <div class="col-md-3">
                                        <label class="form-label">Monto</label>
                                        <input type="number" step="0.01" name="monto" class="form-control" value="<?php echo e($payment['monto']); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Fecha</label>
                                        <input type="date" name="fecha_pago" class="form-control" value="<?php echo e($payment['fecha_pago']); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Método</label>
                                        <select name="metodo" class="form-select">
                                            <option value="transferencia" <?php echo ($payment['metodo'] ?? '') === 'transferencia' ? 'selected' : ''; ?>>Transferencia</option>
                                            <option value="efectivo" <?php echo ($payment['metodo'] ?? '') === 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                                            <option value="otro" <?php echo ($payment['metodo'] ?? '') === 'otro' ? 'selected' : ''; ?>>Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Referencia</label>
                                        <input type="text" name="referencia" class="form-control" value="<?php echo e($payment['referencia']); ?>">
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-sm">Guardar cambios</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
