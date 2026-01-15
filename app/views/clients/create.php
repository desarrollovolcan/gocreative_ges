<div class="card">
    <div class="card-body">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <div class="alert alert-info d-none" id="client-match-alert">
            <div class="d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                <div>
                    <strong>Cliente existente encontrado.</strong> Puedes autocompletar el formulario o abrir la ficha para evitar duplicados.
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" type="button" id="client-match-fill">Autocompletar</button>
                    <a class="btn btn-sm btn-primary" id="client-match-link" href="#">Ir a ficha</a>
                </div>
            </div>
        </div>
        <form method="post" action="index.php?route=clients/store" id="client-create-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="accordion" id="clientFormAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingCompany">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompany" aria-expanded="true" aria-controls="collapseCompany">
                            Datos de la empresa
                        </button>
                    </h2>
                    <div id="collapseCompany" class="accordion-collapse collapse show" aria-labelledby="headingCompany" data-bs-parent="#clientFormAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Foto de perfil</label>
                                    <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                    <div class="form-text">Formatos permitidos: JPG, PNG o WEBP (máx 2MB).</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Razón social</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email principal</label>
                                    <input type="email" name="email" class="form-control" required data-client-lookup>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email cobranza</label>
                                    <div class="input-group">
                                        <input type="email" name="billing_email" class="form-control">
                                        <button class="btn btn-outline-secondary" type="button" data-copy-billing>Usar principal</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contacto</label>
                                    <input type="text" name="contact" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMandante">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMandante" aria-expanded="false" aria-controls="collapseMandante">
                            Datos del mandante
                        </button>
                    </h2>
                    <div id="collapseMandante" class="accordion-collapse collapse" aria-labelledby="headingMandante" data-bs-parent="#clientFormAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="syncMandanteCreate" data-sync-mandante>
                                        <label class="form-check-label" for="syncMandanteCreate">Sincronizar con datos de la empresa</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-copy-mandante>
                                        Usar datos de la empresa para el mandante
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mandante - Nombre</label>
                                    <input type="text" name="mandante_name" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mandante - RUT</label>
                                    <input type="text" name="mandante_rut" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mandante - Teléfono</label>
                                    <input type="text" name="mandante_phone" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Mandante - Correo</label>
                                    <input type="email" name="mandante_email" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSii">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSii" aria-expanded="false" aria-controls="collapseSii">
                            Datos tributarios (SII)
                        </button>
                    </h2>
                    <div id="collapseSii" class="accordion-collapse collapse" aria-labelledby="headingSii" data-bs-parent="#clientFormAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">RUT</label>
                                    <input type="text" name="rut" class="form-control" placeholder="12.345.678-9" data-client-lookup>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Giro</label>
                                    <input type="text" name="giro" class="form-control" placeholder="Ej: Servicios informáticos">
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $activityCodeValue = '';
                                    $activityCodeOptions = $activityCodeOptions ?? [];
                                    include __DIR__ . '/../partials/activity-code-field.php';
                                    ?>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Dirección tributaria</label>
                                    <input type="text" name="address" class="form-control">
                                </div>
                                <div class="col-12">
                                    <?php
                                    $communeValue = '';
                                    $cityValue = '';
                                    include __DIR__ . '/../partials/commune-city-fields.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingAdditional">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdditional" aria-expanded="false" aria-controls="collapseAdditional">
                            Datos adicionales
                        </button>
                    </h2>
                    <div id="collapseAdditional" class="accordion-collapse collapse" aria-labelledby="headingAdditional" data-bs-parent="#clientFormAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <select name="status" class="form-select">
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notas</label>
                                    <textarea name="notes" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingAccess">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAccess" aria-expanded="false" aria-controls="collapseAccess">
                            Acceso cliente
                        </button>
                    </h2>
                    <div id="collapseAccess" class="accordion-collapse collapse" aria-labelledby="headingAccess" data-bs-parent="#clientFormAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Correo portal (email principal)</label>
                                    <input type="email" class="form-control" name="portal_email_display" readonly>
                                    <small class="text-muted">Se usa el email principal como usuario de acceso.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contraseña portal</label>
                                    <div class="input-group">
                                        <input type="password" name="portal_password" class="form-control" required data-password-field>
                                        <button class="btn btn-outline-secondary" type="button" data-toggle-password>Mostrar</button>
                                        <button class="btn btn-outline-secondary" type="button" data-generate-password>Generar</button>
                                    </div>
                                    <small class="text-muted">Comparte esta contraseña con el cliente.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="index.php?route=clients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        
    <?php
    $reportTemplate = 'informeIcargaEspanol.php';
    $reportSource = 'clients/create';
    include __DIR__ . '/../partials/report-download.php';
    ?>
</form>
    </div>
</div>

<script>
    const clientMatchAlert = document.getElementById('client-match-alert');
    const clientMatchLink = document.getElementById('client-match-link');
    const clientMatchFill = document.getElementById('client-match-fill');
    const clientForm = document.getElementById('client-create-form');
    let matchedClient = null;

    const fieldMap = {
        name: 'name',
        rut: 'rut',
        email: 'email',
        billing_email: 'billing_email',
        phone: 'phone',
        contact: 'contact',
        mandante_name: 'mandante_name',
        mandante_rut: 'mandante_rut',
        mandante_phone: 'mandante_phone',
        mandante_email: 'mandante_email',
        address: 'address',
        giro: 'giro',
        activity_code: 'activity_code',
        commune: 'commune',
        city: 'city',
        status: 'status',
        notes: 'notes',
    };

    const getInput = (name) => clientForm?.querySelector(`[name="${name}"]`);

    const fillClientData = (data) => {
        if (!data) {
            return;
        }
        const hasValues = Object.values(fieldMap).some((name) => {
            const input = getInput(name);
            return input && input.value.trim() !== '';
        });
        if (hasValues && !window.confirm('El formulario ya tiene datos. ¿Quieres reemplazarlos con la información del cliente existente?')) {
            return;
        }
        Object.entries(fieldMap).forEach(([key, name]) => {
            const input = getInput(name);
            if (input && data[key] !== undefined) {
                input.value = data[key];
            }
        });
        if (typeof window.syncCommuneCitySelects === 'function') {
            window.syncCommuneCitySelects();
        }
        const mandanteCollapse = document.getElementById('collapseMandante');
        if (mandanteCollapse && !mandanteCollapse.classList.contains('show')) {
            mandanteCollapse.classList.add('show');
        }
    };

    const showMatch = (client) => {
        matchedClient = client;
        clientMatchAlert?.classList.remove('d-none');
        if (client?.id) {
            clientMatchLink.href = `index.php?route=clients/edit&id=${client.id}`;
        }
    };

    const hideMatch = () => {
        matchedClient = null;
        clientMatchAlert?.classList.add('d-none');
    };

    const lookupClient = async (term) => {
        if (!term) {
            hideMatch();
            return;
        }
        try {
            const response = await fetch(`index.php?route=clients/lookup&term=${encodeURIComponent(term)}`);
            if (!response.ok) {
                return;
            }
            const data = await response.json();
            if (data?.found && data.client) {
                showMatch(data.client);
            } else {
                hideMatch();
            }
        } catch (error) {
            // ignore lookup errors
        }
    };

    document.querySelectorAll('[data-client-lookup]').forEach((input) => {
        input.addEventListener('blur', () => lookupClient(input.value.trim()));
    });

    const portalEmailDisplay = getInput('portal_email_display');
    const emailInput = getInput('email');
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
            const fromInput = getInput(from);
            const toInput = getInput(to);
            if (fromInput && toInput) {
                toInput.value = fromInput.value;
            }
        });
        const mandanteCollapse = document.getElementById('collapseMandante');
        if (mandanteCollapse && !mandanteCollapse.classList.contains('show')) {
            mandanteCollapse.classList.add('show');
        }
    };

    const syncPortalEmail = () => {
        if (portalEmailDisplay && emailInput) {
            portalEmailDisplay.value = emailInput.value;
        }
    };
    emailInput?.addEventListener('input', syncPortalEmail);
    syncPortalEmail();

    clientMatchFill?.addEventListener('click', () => fillClientData(matchedClient));

    document.querySelector('[data-copy-billing]')?.addEventListener('click', () => {
        const emailInput = getInput('email');
        const billingInput = getInput('billing_email');
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

    Object.keys(mandanteMappings).forEach((field) => {
        getInput(field)?.addEventListener('input', syncMandanteFromCompany);
    });
    mandanteSyncToggle?.addEventListener('change', syncMandanteFromCompany);
    syncMandanteFromCompany();

    document.querySelector('[data-generate-password]')?.addEventListener('click', () => {
        const passwordInput = getInput('portal_password');
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
        const passwordInput = clientForm?.querySelector('[data-password-field]');
        if (!passwordInput || !button) {
            return;
        }
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        button.textContent = isPassword ? 'Ocultar' : 'Mostrar';
    });

    clientForm?.addEventListener('submit', () => {
        const billingInput = getInput('billing_email');
        if (emailInput && billingInput && billingInput.value.trim() === '') {
            billingInput.value = emailInput.value;
        }
    });
</script>
