<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar trabajador</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=hr/employees/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo (int)$employee['id']; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">RUT *</label>
                    <input type="text" name="rut" class="form-control" value="<?php echo e($employee['rut'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo e($employee['first_name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Apellido *</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo e($employee['last_name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($employee['email'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e($employee['phone'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" value="<?php echo e($employee['address'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Departamento</label>
                    <select name="department_id" class="form-select">
                        <option value="">Selecciona</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?php echo (int)$department['id']; ?>" <?php echo ((int)($employee['department_id'] ?? 0) === (int)$department['id']) ? 'selected' : ''; ?>>
                                <?php echo e($department['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cargo</label>
                    <select name="position_id" class="form-select">
                        <option value="">Selecciona</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?php echo (int)$position['id']; ?>" <?php echo ((int)($employee['position_id'] ?? 0) === (int)$position['id']) ? 'selected' : ''; ?>>
                                <?php echo e($position['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de ingreso *</label>
                    <input type="date" name="hire_date" class="form-control" value="<?php echo e($employee['hire_date'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de término</label>
                    <input type="date" name="termination_date" class="form-control" value="<?php echo e($employee['termination_date'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php $status = $employee['status'] ?? 'activo'; ?>
                        <option value="activo" <?php echo $status === 'activo' ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo $status === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                        <option value="suspendido" <?php echo $status === 'suspendido' ? 'selected' : ''; ?>>Suspendido</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php?route=hr/employees" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
</div>
