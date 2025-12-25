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
                            <option value="<?php echo $client['id']; ?>"><?php echo e($client['name']); ?></option>
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
                            <option value="<?php echo $project['id']; ?>"><?php echo e($project['name']); ?> (<?php echo e($project['client_name']); ?>)</option>
                        <?php endforeach; ?>
                    </select>
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
                    <input type="number" step="0.01" name="subtotal" class="form-control" value="0">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Impuestos</label>
                    <input type="number" step="0.01" name="impuestos" class="form-control" value="0">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" value="0">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notas" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Items de factura</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-2">
                        <div class="col-md-5">
                            <input type="text" name="items[0][descripcion]" class="form-control" placeholder="Descripción">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][cantidad]" class="form-control" value="1">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][precio_unitario]" class="form-control" value="0">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="items[0][total]" class="form-control" value="0">
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
