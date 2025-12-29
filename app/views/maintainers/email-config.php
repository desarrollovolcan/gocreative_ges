<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Configuración de correo</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=maintainers/email-config/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Servidor (host)</label>
                    <input type="text" name="host" class="form-control" value="<?php echo e($smtpConfig['host'] ?? ''); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Puerto</label>
                    <input type="number" name="port" class="form-control" value="<?php echo e($smtpConfig['port'] ?? 587); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Seguridad</label>
                    <select name="security" class="form-select">
                        <option value="ssl" <?php echo ($smtpConfig['security'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                        <option value="tls" <?php echo ($smtpConfig['security'] ?? '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                        <option value="none" <?php echo ($smtpConfig['security'] ?? '') === 'none' ? 'selected' : ''; ?>>Ninguna</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control" value="<?php echo e($smtpConfig['username'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" value="<?php echo e($smtpConfig['password'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre remitente</label>
                    <input type="text" name="from_name" class="form-control" value="<?php echo e($smtpConfig['from_name'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Correo remitente</label>
                    <input type="email" name="from_email" class="form-control" value="<?php echo e($smtpConfig['from_email'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Responder a</label>
                    <input type="email" name="reply_to" class="form-control" value="<?php echo e($smtpConfig['reply_to'] ?? ''); ?>">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <form method="post" action="index.php?route=maintainers/email-config/test" class="mt-3 d-flex justify-content-end">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <button type="submit" class="btn btn-outline-primary">Probar conexión</button>
        </form>
    </div>
</div>
