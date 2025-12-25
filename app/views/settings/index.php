<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Datos empresa</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=settings/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="section" value="company">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($company['name'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="<?php echo e($company['rut'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Banco</label>
                    <input type="text" name="bank" class="form-control" value="<?php echo e($company['bank'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo cuenta</label>
                    <input type="text" name="account_type" class="form-control" value="<?php echo e($company['account_type'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Número cuenta</label>
                    <input type="text" name="account_number" class="form-control" value="<?php echo e($company['account_number'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email contacto</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($company['email'] ?? ''); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Firma</label>
                    <textarea name="signature" class="form-control" rows="3"><?php echo e($company['signature'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <form method="post" action="index.php?route=settings/test-smtp" class="mt-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Probar cuenta</label>
                    <select name="smtp_type" class="form-select">
                        <option value="cobranza">Cobranza</option>
                        <option value="info">Información</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary">Probar envío a mi correo</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Parámetros cobranza</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=settings/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="section" value="billing">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Días aviso 1</label>
                    <input type="number" name="notice_days_1" class="form-control" value="<?php echo e($billing['notice_days_1'] ?? 15); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Días aviso 2</label>
                    <input type="number" name="notice_days_2" class="form-control" value="<?php echo e($billing['notice_days_2'] ?? 5); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Horario envío</label>
                    <input type="time" name="send_time" class="form-control" value="<?php echo e($billing['send_time'] ?? '09:00'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Zona horaria</label>
                    <input type="text" name="timezone" class="form-control" value="<?php echo e($billing['timezone'] ?? 'America/Santiago'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Prefijo factura</label>
                    <input type="text" name="invoice_prefix" class="form-control" value="<?php echo e($billing['invoice_prefix'] ?? 'FAC-'); ?>">
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">SMTP Cuentas</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=settings/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="section" value="smtp">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Cuenta cobranza</h5>
                    <div class="mb-2">
                        <label class="form-label">Host</label>
                        <input type="text" name="smtp_cobranza_host" class="form-control" value="<?php echo e($smtpCobranza['host'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Puerto</label>
                        <input type="number" name="smtp_cobranza_port" class="form-control" value="<?php echo e($smtpCobranza['port'] ?? 587); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Seguridad</label>
                        <select name="smtp_cobranza_security" class="form-select">
                            <option value="tls" <?php echo ($smtpCobranza['security'] ?? '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                            <option value="ssl" <?php echo ($smtpCobranza['security'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            <option value="none" <?php echo ($smtpCobranza['security'] ?? '') === 'none' ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="smtp_cobranza_username" class="form-control" value="<?php echo e($smtpCobranza['username'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="smtp_cobranza_password" class="form-control" value="<?php echo e($smtpCobranza['password'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">From Name</label>
                        <input type="text" name="smtp_cobranza_from_name" class="form-control" value="<?php echo e($smtpCobranza['from_name'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">From Email</label>
                        <input type="email" name="smtp_cobranza_from_email" class="form-control" value="<?php echo e($smtpCobranza['from_email'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Reply-To</label>
                        <input type="email" name="smtp_cobranza_reply_to" class="form-control" value="<?php echo e($smtpCobranza['reply_to'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Cuenta información</h5>
                    <div class="mb-2">
                        <label class="form-label">Host</label>
                        <input type="text" name="smtp_info_host" class="form-control" value="<?php echo e($smtpInfo['host'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Puerto</label>
                        <input type="number" name="smtp_info_port" class="form-control" value="<?php echo e($smtpInfo['port'] ?? 587); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Seguridad</label>
                        <select name="smtp_info_security" class="form-select">
                            <option value="tls" <?php echo ($smtpInfo['security'] ?? '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                            <option value="ssl" <?php echo ($smtpInfo['security'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            <option value="none" <?php echo ($smtpInfo['security'] ?? '') === 'none' ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="smtp_info_username" class="form-control" value="<?php echo e($smtpInfo['username'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="smtp_info_password" class="form-control" value="<?php echo e($smtpInfo['password'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">From Name</label>
                        <input type="text" name="smtp_info_from_name" class="form-control" value="<?php echo e($smtpInfo['from_name'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">From Email</label>
                        <input type="email" name="smtp_info_from_email" class="form-control" value="<?php echo e($smtpInfo['from_email'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Reply-To</label>
                        <input type="email" name="smtp_info_reply_to" class="form-control" value="<?php echo e($smtpInfo['reply_to'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
