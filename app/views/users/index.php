<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Usuarios</h4>
        <a href="index.php?route=users/create" class="btn btn-primary">Nuevo usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo e($user['name']); ?></td>
                            <td><?php echo e($user['email']); ?></td>
                            <td><?php echo e($user['role']); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=users/edit&id=<?php echo $user['id']; ?>" class="btn btn-soft-primary btn-sm">Editar</a>
                                <form method="post" action="index.php?route=users/delete" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
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
