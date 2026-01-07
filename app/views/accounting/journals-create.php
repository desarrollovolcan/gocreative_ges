<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Nuevo asiento contable</h4>
        <a href="index.php?route=accounting/journals" class="btn btn-light btn-sm">Volver</a>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=accounting/journals/store" id="journal-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Nº asiento</label>
                    <input type="text" name="entry_number" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="entry_date" class="form-control" value="<?php echo e($today); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Descripción</label>
                    <input type="text" name="description" class="form-control">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle" id="journal-lines">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Cuenta</th>
                            <th>Descripción</th>
                            <th style="width: 15%;">Débito</th>
                            <th style="width: 15%;">Crédito</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="line-row">
                            <td>
                                <select name="account_id[]" class="form-select form-select-sm" required>
                                    <option value="">Selecciona cuenta</option>
                                    <?php foreach ($accounts as $account): ?>
                                        <option value="<?php echo (int)$account['id']; ?>">
                                            <?php echo e($account['code'] . ' - ' . $account['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="text" name="line_description[]" class="form-control form-control-sm"></td>
                            <td><input type="number" name="debit[]" class="form-control form-control-sm" step="0.01" min="0" value="0"></td>
                            <td><input type="number" name="credit[]" class="form-control form-control-sm" step="0.01" min="0" value="0"></td>
                            <td><button type="button" class="btn btn-link text-danger p-0 remove-line">✕</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="add-line">Agregar línea</button>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">Registrar asiento</button>
            </div>
        
    <?php
    $reportTemplate = 'informeIcargaEspanol.php';
    $reportSource = 'accounting/journals-create';
    include __DIR__ . '/../partials/report-download.php';
    ?>
</form>
    </div>
</div>

<script>
    (function() {
        const tableBody = document.querySelector('#journal-lines tbody');
        const addLineButton = document.getElementById('add-line');

        function addLine() {
            const template = tableBody.querySelector('.line-row');
            const clone = template.cloneNode(true);
            clone.querySelectorAll('input').forEach((input) => {
                input.value = '0';
            });
            clone.querySelector('select').selectedIndex = 0;
            tableBody.appendChild(clone);
        }

        tableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-line')) {
                const rows = tableBody.querySelectorAll('.line-row');
                if (rows.length > 1) {
                    event.target.closest('.line-row').remove();
                }
            }
        });

        addLineButton?.addEventListener('click', addLine);
    })();
</script>
