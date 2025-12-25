<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Proyectos</h4>
        <a href="index.php?route=projects/create" class="btn btn-primary">Nuevo proyecto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cliente</th>
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
