<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Clientes</h4>
        <a href="index.php?route=clients/create" class="btn btn-primary">Nuevo cliente</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Razón social</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo e($client['name']); ?></td>
                            <td><?php echo e($client['email']); ?></td>
                            <td><?php echo e($client['phone']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $client['status'] === 'activo' ? 'success' : 'secondary'; ?>-subtle text-<?php echo $client['status'] === 'activo' ? 'success' : 'secondary'; ?>">
                                    <?php echo e($client['status']); ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="index.php?route=clients/show&id=<?php echo $client['id']; ?>" class="btn btn-light btn-sm">Ver</a>
                                <a href="index.php?route=clients/edit&id=<?php echo $client['id']; ?>" class="btn btn-soft-primary btn-sm">Editar</a>
                                <form method="post" action="index.php?route=clients/delete" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
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
