<div class="row justify-content-center">
    <div class="col-12 col-lg-6 col-xl-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-1">Bienvenido a tu Intranet</h4>
                        <p class="text-muted mb-0">Accede con el correo registrado y tu código de acceso.</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adminAccessModal">
                        Acceso administrador
                    </button>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo e($error); ?></div>
                <?php endif; ?>

                <form method="post" action="index.php?route=clients/login">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="mb-3">
                        <label class="form-label">Correo del cliente</label>
                        <input type="email" name="email" class="form-control" value="<?php echo e($email ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código de acceso</label>
                        <input type="text" name="access_code" class="form-control" required>
                        <div class="form-text">Este código corresponde al token del portal entregado por GoCreative.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar al portal</button>
                </form>
            </div>
        </div>
        <div class="text-center text-muted mt-3">
            ¿Necesitas ayuda? Escríbenos y con gusto revisamos tu acceso.
        </div>
    </div>
</div>

<div class="modal fade" id="adminAccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Acceso administrador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Ingresa tus credenciales de administración para acceder al panel interno.</p>
                <form method="post" action="login.php">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar al panel</button>
                </form>
            </div>
        </div>
    </div>
</div>
