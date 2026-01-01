<div class="row">
    <div class="col-12 col-lg-6 col-xl-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Nuevo proveedor</h4>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=suppliers/store">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="contacto@proveedor.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="phone" class="form-control" placeholder="+56 9 1234 5678">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="address" class="form-control" placeholder="Calle y número">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar proveedor</button>
                            <a href="index.php?route=suppliers" class="btn btn-light ms-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
