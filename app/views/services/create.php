<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=services/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="client_id" class="form-select" required>
                        <option value="">Selecciona cliente</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>"><?php echo e($client['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo de servicio</label>
                    <select name="service_type" class="form-select">
                        <option value="dominio">Dominio</option>
                        <option value="hosting">Hosting</option>
                        <option value="plan">Plan mensual</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre servicio</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Costo</label>
                    <input type="number" step="0.01" name="cost" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Moneda</label>
                    <select name="currency" class="form-select">
                        <option value="CLP">CLP</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ciclo de cobro</label>
                    <select name="billing_cycle" class="form-select">
                        <option value="mensual">Mensual</option>
                        <option value="anual">Anual</option>
                        <option value="unico">Único</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha vencimiento</label>
                    <input type="date" name="due_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha eliminación</label>
                    <input type="date" name="delete_date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Días aviso 1</label>
                    <input type="number" name="notice_days_1" class="form-control" value="15">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Días aviso 2</label>
                    <input type="number" name="notice_days_2" class="form-control" value="5">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="activo">Activo</option>
                        <option value="suspendido">Suspendido</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="auto_invoice" id="auto_invoice" checked>
                        <label class="form-check-label" for="auto_invoice">Auto facturar</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="auto_email" id="auto_email" checked>
                        <label class="form-check-label" for="auto_email">Auto enviar correos</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=services" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
