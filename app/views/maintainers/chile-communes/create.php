<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Nueva comuna</h4>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=maintainers/chile-communes/store">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="mb-3">
                <label class="form-label">Comuna</label>
                <input type="text" name="commune" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Región</label>
                <input type="text" name="region" class="form-control" required>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=maintainers/chile-communes" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
