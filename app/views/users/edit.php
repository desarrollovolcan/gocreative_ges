<div class="card">
    <div class="card-body">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo e($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?route=users/update" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($user['name']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($user['email']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña (opcional)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rol</label>
                    <select name="role_id" class="form-select">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['id']; ?>" <?php echo $role['id'] == $user['role_id'] ? 'selected' : ''; ?>><?php echo e($role['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Firma</label>
                    <textarea name="signature" class="form-control" rows="3"><?php echo e($user['signature']); ?></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Foto de perfil</label>
                    <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg,image/webp">
                    <div class="form-text">Formatos permitidos: JPG, PNG o WEBP (máx 2MB).</div>
                    <?php if (!empty($user['avatar_path'])): ?>
                        <div class="mt-2">
                            <img src="<?php echo e($user['avatar_path']); ?>" alt="Avatar de usuario" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=users" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
