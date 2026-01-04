<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Nuevo trabajador</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=hr/employees/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">RUT *</label>
                    <input type="text" name="rut" class="form-control" placeholder="12.345.678-9" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Apellido *</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Departamento</label>
                    <select name="department_id" class="form-select">
                        <option value="">Selecciona</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?php echo (int)$department['id']; ?>"><?php echo e($department['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cargo</label>
                    <select name="position_id" class="form-select">
                        <option value="">Selecciona</option>
                        <?php foreach ($positions as $position): ?>
                            <option value="<?php echo (int)$position['id']; ?>"><?php echo e($position['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de ingreso *</label>
                    <input type="date" name="hire_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de término</label>
                    <input type="date" name="termination_date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="suspendido">Suspendido</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php?route=hr/employees" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
</div>
