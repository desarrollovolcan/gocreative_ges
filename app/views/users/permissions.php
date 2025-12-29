<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Asignación de privilegios</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            Nota: cada vez que se cree un menú o submenú nuevo, debe agregarse al catálogo de permisos en <strong>app/helpers.php</strong> para poder asignarlo a los perfiles.
        </div>
        <form method="get" action="index.php" class="row g-3 align-items-end mb-3">
            <input type="hidden" name="route" value="users/permissions">
            <div class="col-md-6">
                <label class="form-label">Perfil</label>
                <select name="role_id" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role['id']; ?>" <?php echo (int)$selectedRoleId === (int)$role['id'] ? 'selected' : ''; ?>>
                            <?php echo e($role['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <form method="post" action="index.php?route=users/permissions/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="role_id" value="<?php echo (int)$selectedRoleId; ?>">
            <div class="row">
                <?php foreach ($permissionCatalog as $key => $permission): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="perm-<?php echo e($key); ?>" name="permissions[]" value="<?php echo e($key); ?>" <?php echo in_array($key, $selectedPermissions, true) ? 'checked' : ''; ?>>
                                <label class="form-check-label fw-semibold" for="perm-<?php echo e($key); ?>">
                                    <?php echo e($permission['label']); ?>
                                </label>
                            </div>
                            <div class="text-muted small mt-1">
                                Rutas: <?php echo e(implode(', ', $permission['routes'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar permisos</button>
            </div>
        </form>
    </div>
</div>
