<div class="row">
    <div class="col-12 col-lg-6 col-xl-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Editar proveedor</h4>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=suppliers/update">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" value="<?php echo (int)($supplier['id'] ?? 0); ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo e($supplier['name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e($supplier['email'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo e($supplier['phone'] ?? ''); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="address" class="form-control" value="<?php echo e($supplier['address'] ?? ''); ?>">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Actualizar proveedor</button>
                            <a href="index.php?route=suppliers" class="btn btn-light ms-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
