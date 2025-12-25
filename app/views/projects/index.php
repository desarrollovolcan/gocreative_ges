<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Proyectos</h4>
        <a href="index.php?route=projects/create" class="btn btn-primary">Nuevo proyecto</a>
    </div>
    <div class="card-body">
        <form class="row g-3 mb-3" method="get" action="index.php">
            <input type="hidden" name="route" value="projects">
            <div class="col-md-3">
                <label class="form-label">Cliente</label>
                <select name="client_id" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['id']; ?>" <?php echo (int)($filters['client_id'] ?? 0) === (int)$client['id'] ? 'selected' : ''; ?>>
                            <?php echo e($client['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="cotizado" <?php echo ($filters['status'] ?? '') === 'cotizado' ? 'selected' : ''; ?>>Cotizado</option>
                    <option value="en_curso" <?php echo ($filters['status'] ?? '') === 'en_curso' ? 'selected' : ''; ?>>En curso</option>
                    <option value="en_pausa" <?php echo ($filters['status'] ?? '') === 'en_pausa' ? 'selected' : ''; ?>>En pausa</option>
                    <option value="finalizado" <?php echo ($filters['status'] ?? '') === 'finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mandante</label>
                <input type="text" name="mandante" class="form-control" value="<?php echo e($filters['mandante'] ?? ''); ?>" placeholder="Nombre del mandante">
            </div>
            <div class="col-md-3">
                <label class="form-label">Proyecto</label>
                <input type="text" name="name" class="form-control" value="<?php echo e($filters['name'] ?? ''); ?>" placeholder="Nombre del proyecto">
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="index.php?route=projects" class="btn btn-light">Limpiar</a>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cliente</th>
                        <th>Mandante</th>
                        <th>Estado</th>
                        <th>Entrega</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo e($project['name']); ?></td>
                            <td><?php echo e($project['client_name']); ?></td>
                            <td><?php echo e($project['mandante_name']); ?></td>
                            <td><span class="badge bg-secondary-subtle text-secondary"><?php echo e($project['status']); ?></span></td>
                            <td><?php echo e($project['delivery_date']); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=projects/show&id=<?php echo $project['id']; ?>" class="btn btn-light btn-sm">Ver</a>
                                <a href="index.php?route=projects/edit&id=<?php echo $project['id']; ?>" class="btn btn-soft-primary btn-sm">Editar</a>
                                <form method="post" action="index.php?route=projects/delete" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                    <button type="submit" class="btn btn-soft-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
