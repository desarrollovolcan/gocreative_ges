<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo e($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?route=clients/update" id="client-edit-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
            <div class="mb-3">
                <?php echo render_id_badge($client['id'] ?? null); ?>
            </div>
            <div class="accordion" id="clientEditAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="editHeadingCompany">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseCompany" aria-expanded="true" aria-controls="editCollapseCompany">
                            Datos de la empresa
                        </button>
                    </h2>
                    <div id="editCollapseCompany" class="accordion-collapse collapse show" aria-labelledby="editHeadingCompany" data-bs-parent="#clientEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Foto de perfil</label>
                                    <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                    <div class="form-text">Formatos permitidos: JPG, PNG o WEBP (máx 2MB).</div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <?php if (!empty($client['avatar_path'])): ?>
                                        <img src="<?php echo e($client['avatar_path']); ?>" alt="Avatar cliente" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Razón social</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo e($client['name'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email principal</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo e($client['email'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email cobranza</label>
                                    <div class="input-group">
                                        <input type="email" name="billing_email" class="form-control" value="<?php echo e($client['billing_email'] ?? ''); ?>">
                                        <button class="btn btn-outline-secondary" type="button" data-copy-billing>Usar principal</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Teléfono</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo e($client['phone'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Contacto</label>
                                    <input type="text" name="contact" class="form-control" value="<?php echo e($client['contact'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="editHeadingMandante">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseMandante" aria-expanded="false" aria-controls="editCollapseMandante">
                            Datos del mandante
                        </button>
                    </h2>
                    <div id="editCollapseMandante" class="accordion-collapse collapse" aria-labelledby="editHeadingMandante" data-bs-parent="#clientEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="syncMandanteEdit" data-sync-mandante>
                                        <label class="form-check-label" for="syncMandanteEdit">Sincronizar con datos de la empresa</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-copy-mandante>
                                        Usar datos de la empresa para el mandante
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mandante - Nombre</label>
                                    <input type="text" name="mandante_name" class="form-control" value="<?php echo e($client['mandante_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mandante - RUT</label>
                                    <input type="text" name="mandante_rut" class="form-control" value="<?php echo e($client['mandante_rut'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mandante - Teléfono</label>
                                    <input type="text" name="mandante_phone" class="form-control" value="<?php echo e($client['mandante_phone'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mandante - Correo</label>
                                    <input type="email" name="mandante_email" class="form-control" value="<?php echo e($client['mandante_email'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="editHeadingSii">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseSii" aria-expanded="false" aria-controls="editCollapseSii">
                            Datos tributarios (SII)
                        </button>
                    </h2>
                    <div id="editCollapseSii" class="accordion-collapse collapse" aria-labelledby="editHeadingSii" data-bs-parent="#clientEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">RUT</label>
                                    <input type="text" name="rut" class="form-control" value="<?php echo e($client['rut'] ?? ''); ?>" placeholder="12.345.678-9">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Giro</label>
                                    <input type="text" name="giro" class="form-control" value="<?php echo e($client['giro'] ?? ''); ?>" placeholder="Ej: Servicios informáticos">
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $activityCodeValue = $client['activity_code'] ?? '';
                                    $activityCodeOptions = $activityCodeOptions ?? [];
                                    include __DIR__ . '/../partials/activity-code-field.php';
                                    ?>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Dirección tributaria</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo e($client['address'] ?? ''); ?>">
                                </div>
                                <div class="col-12">
                                    <?php
                                    $communeValue = $client['commune'] ?? '';
                                    $cityValue = $client['city'] ?? '';
                                    include __DIR__ . '/../partials/commune-city-fields.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="editHeadingAdditional">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseAdditional" aria-expanded="false" aria-controls="editCollapseAdditional">
                            Datos adicionales
                        </button>
                    </h2>
                    <div id="editCollapseAdditional" class="accordion-collapse collapse" aria-labelledby="editHeadingAdditional" data-bs-parent="#clientEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Estado</label>
                                    <select name="status" class="form-select">
                                        <option value="activo" <?php echo ($client['status'] ?? '') === 'activo' ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo ($client['status'] ?? '') === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Notas</label>
                                    <textarea name="notes" class="form-control" rows="3"><?php echo e($client['notes'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="editHeadingAccess">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseAccess" aria-expanded="false" aria-controls="editCollapseAccess">
                            Acceso cliente
                        </button>
                    </h2>
                    <div id="editCollapseAccess" class="accordion-collapse collapse" aria-labelledby="editHeadingAccess" data-bs-parent="#clientEditAccordion">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Correo portal (email principal)</label>
                                    <input type="email" class="form-control" name="portal_email_display" value="<?php echo e($client['email'] ?? ''); ?>" readonly>
                                    <small class="text-muted">Se usa el email principal como usuario de acceso.</small>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Link intranet</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo e($portalUrl ?? ''); ?>" readonly>
                                        <button class="btn btn-soft-primary" type="button" data-copy-input <?php echo empty($portalUrl) ? 'disabled' : ''; ?>>Copiar</button>
                                    </div>
                                    <?php if (empty($portalUrl)): ?>
                                        <small class="text-muted">Guarda para generar el link.</small>
                                    <?php endif; ?>
                                    <input type="hidden" name="portal_token" value="<?php echo e($client['portal_token'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Contraseña portal</label>
                                    <div class="input-group">
                                        <input type="password" name="portal_password" class="form-control" placeholder="Nueva contraseña" data-password-field>
                                        <button class="btn btn-outline-secondary" type="button" data-toggle-password>Mostrar</button>
                                        <button class="btn btn-outline-secondary" type="button" data-generate-password>Generar</button>
                                    </div>
                                    <small class="text-muted">Deja en blanco para mantener la contraseña actual.</small>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="regeneratePortalToken" name="regenerate_portal_token">
                                        <label class="form-check-label" for="regeneratePortalToken">Regenerar link</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="index.php?route=clients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        
    <?php
    $reportTemplate = 'informeIcargaEspanol.php';
    $reportSource = 'clients/edit';
    include __DIR__ . '/../partials/report-download.php';
    ?>
</form>
    </div>
</div>

<script>
    document.querySelectorAll('[data-copy-input]').forEach((button) => {
        button.addEventListener('click', async () => {
            const input = button.closest('.input-group')?.querySelector('input');
            if (!input) {
                return;
            }
            try {
                await navigator.clipboard.writeText(input.value);
                button.textContent = 'Copiado';
                setTimeout(() => {
                    button.textContent = 'Copiar';
                }, 2000);
            } catch (error) {
                input.select();
                document.execCommand('copy');
            }
        });
    });

    const editForm = document.getElementById('client-edit-form');
    const getEditInput = (name) => editForm?.querySelector(`[name="${name}"]`);
    const mandanteSyncToggle = document.querySelector('[data-sync-mandante]');
    const mandanteMappings = {
        contact: 'mandante_name',
        rut: 'mandante_rut',
        phone: 'mandante_phone',
        email: 'mandante_email',
    };
    const syncMandanteFromCompany = () => {
        if (!mandanteSyncToggle?.checked) {
            return;
        }
        Object.entries(mandanteMappings).forEach(([from, to]) => {
            const fromInput = getEditInput(from);
            const toInput = getEditInput(to);
            if (fromInput && toInput) {
                toInput.value = fromInput.value;
            }
        });
        const mandanteCollapse = document.getElementById('editCollapseMandante');
        if (mandanteCollapse && !mandanteCollapse.classList.contains('show')) {
            mandanteCollapse.classList.add('show');
        }
    };

    document.querySelector('[data-copy-billing]')?.addEventListener('click', () => {
        const emailInput = getEditInput('email');
        const billingInput = getEditInput('billing_email');
        if (emailInput && billingInput) {
            billingInput.value = emailInput.value;
        }
    });

    document.querySelector('[data-copy-mandante]')?.addEventListener('click', () => {
        if (mandanteSyncToggle) {
            mandanteSyncToggle.checked = true;
        }
        syncMandanteFromCompany();
    });

    const portalEmailDisplay = getEditInput('portal_email_display');
    const emailInput = getEditInput('email');
    const syncPortalEmail = () => {
        if (portalEmailDisplay && emailInput) {
            portalEmailDisplay.value = emailInput.value;
        }
    };
    emailInput?.addEventListener('input', syncPortalEmail);
    syncPortalEmail();

    Object.keys(mandanteMappings).forEach((field) => {
        getEditInput(field)?.addEventListener('input', syncMandanteFromCompany);
    });
    mandanteSyncToggle?.addEventListener('change', syncMandanteFromCompany);
    syncMandanteFromCompany();

    document.querySelector('[data-generate-password]')?.addEventListener('click', () => {
        const passwordInput = getEditInput('portal_password');
        if (!passwordInput) {
            return;
        }
        const charset = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
        let password = '';
        for (let i = 0; i < 12; i += 1) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        passwordInput.value = password;
    });

    document.querySelector('[data-toggle-password]')?.addEventListener('click', (event) => {
        const button = event.currentTarget;
        const passwordInput = editForm?.querySelector('[data-password-field]');
        if (!passwordInput || !button) {
            return;
        }
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        button.textContent = isPassword ? 'Ocultar' : 'Mostrar';
    });

    editForm?.addEventListener('submit', () => {
        const billingInput = getEditInput('billing_email');
        if (emailInput && billingInput && billingInput.value.trim() === '') {
            billingInput.value = emailInput.value;
        }
    });
</script>
