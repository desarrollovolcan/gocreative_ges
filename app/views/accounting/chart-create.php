<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Nueva cuenta contable</h4>
        <a href="index.php?route=accounting/chart" class="btn btn-light btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=accounting/chart/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Código</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo</label>
                    <select name="type" class="form-select" required>
                        <option value="">Selecciona tipo</option>
                        <option value="activo">Activo</option>
                        <option value="pasivo">Pasivo</option>
                        <option value="patrimonio">Patrimonio</option>
                        <option value="resultado">Resultado</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cuenta padre</label>
                    <select name="parent_id" class="form-select">
                        <option value="">Sin cuenta padre</option>
                        <?php foreach ($accounts as $account): ?>
                            <option value="<?php echo (int)$account['id']; ?>">
                                <?php echo e($account['code'] . ' - ' . $account['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="account-active" checked>
                        <label class="form-check-label" for="account-active">Cuenta activa</label>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        
    <?php
    $reportTemplate = 'informeIcargaEnglish.php';
    $reportSource = 'accounting/chart-create';
    include __DIR__ . '/../partials/report-download.php';
    ?>
</form>
    </div>
</div>
