<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Nueva cuenta bancaria</h4>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=treasury/accounts/store">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Banco</label>
                        <input type="text" name="bank_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número cuenta</label>
                        <input type="text" name="account_number" class="form-control">
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Moneda</label>
                            <select name="currency" class="form-select">
                                <option value="CLP">CLP</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="UF">UF</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Saldo inicial</label>
                            <input type="number" step="0.01" name="current_balance" class="form-control" value="0">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Cuentas registradas</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>Banco</th>
                                <th>Moneda</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td><?php echo e($account['name']); ?></td>
                                    <td><?php echo e($account['bank_name']); ?></td>
                                    <td><?php echo e($account['currency']); ?></td>
                                    <td><?php echo e(format_currency((float)($account['current_balance'] ?? 0))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($accounts)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay cuentas registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
