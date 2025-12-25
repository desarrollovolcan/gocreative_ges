<div class="card">
    <div class="card-body">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?route=clients/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
            <div class="row">
                <div class="col-12">
                    <h5 class="form-section-title mt-0">Datos de la empresa</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Razón social</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($client['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="<?php echo e($client['rut'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email principal</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($client['email'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email cobranza</label>
                    <input type="email" name="billing_email" class="form-control" value="<?php echo e($client['billing_email'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e($client['phone'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contacto</label>
                    <input type="text" name="contact" class="form-control" value="<?php echo e($client['contact'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Datos del mandante</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Nombre</label>
                    <input type="text" name="mandante_name" class="form-control" value="<?php echo e($client['mandante_name'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - RUT</label>
                    <input type="text" name="mandante_rut" class="form-control" value="<?php echo e($client['mandante_rut'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Teléfono</label>
                    <input type="text" name="mandante_phone" class="form-control" value="<?php echo e($client['mandante_phone'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mandante - Correo</label>
                    <input type="email" name="mandante_email" class="form-control" value="<?php echo e($client['mandante_email'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Datos adicionales</h5>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" value="<?php echo e($client['address'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="activo" <?php echo ($client['status'] ?? '') === 'activo' ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo ($client['status'] ?? '') === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($client['notes'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <h5 class="form-section-title">Acceso cliente</h5>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Link intranet</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?php echo e($portalUrl ?? ''); ?>" readonly>
                        <button class="btn btn-soft-primary" type="button" data-copy-portal <?php echo empty($portalUrl) ? 'disabled' : ''; ?>>Copiar</button>
                    </div>
                    <?php if (empty($portalUrl)): ?>
                        <small class="text-muted">Guarda para generar el link.</small>
                    <?php endif; ?>
                    <input type="hidden" name="portal_token" value="<?php echo e($client['portal_token'] ?? ''); ?>">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="regeneratePortalToken" name="regenerate_portal_token">
                        <label class="form-check-label" for="regeneratePortalToken">Regenerar link</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=clients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const copyPortalButton = document.querySelector('[data-copy-portal]');
    copyPortalButton?.addEventListener('click', async () => {
        const input = copyPortalButton.closest('.input-group')?.querySelector('input');
        if (!input) {
            return;
        }
        try {
            await navigator.clipboard.writeText(input.value);
            copyPortalButton.textContent = 'Copiado';
            setTimeout(() => {
                copyPortalButton.textContent = 'Copiar';
            }, 2000);
        } catch (error) {
            input.select();
            document.execCommand('copy');
        }
    });
</script>
