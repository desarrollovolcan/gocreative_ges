<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=projects/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="client_id" class="form-select" required>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>" <?php echo $client['id'] == $project['client_id'] ? 'selected' : ''; ?>><?php echo e($client['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($project['name']); ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo e($project['description']); ?></textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="cotizado" <?php echo $project['status'] === 'cotizado' ? 'selected' : ''; ?>>Cotizado</option>
                        <option value="en_curso" <?php echo $project['status'] === 'en_curso' ? 'selected' : ''; ?>>En curso</option>
                        <option value="en_pausa" <?php echo $project['status'] === 'en_pausa' ? 'selected' : ''; ?>>En pausa</option>
                        <option value="finalizado" <?php echo $project['status'] === 'finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e($project['start_date']); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha entrega</label>
                    <input type="date" name="delivery_date" class="form-control" value="<?php echo e($project['delivery_date']); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="value" class="form-control" value="<?php echo e($project['value']); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($project['notes']); ?></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?route=projects" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
