<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Nuevo tipo de servicio</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=maintainers/service-types/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=maintainers/service-types" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
