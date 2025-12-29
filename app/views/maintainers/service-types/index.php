<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Tipos de servicios</h4>
        <a href="index.php?route=maintainers/service-types/create" class="btn btn-primary">Nuevo tipo</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($types as $type): ?>
                        <tr>
                            <td><?php echo e($type['name']); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=maintainers/service-types/edit&id=<?php echo $type['id']; ?>" class="btn btn-light btn-sm">Editar</a>
                                <form method="post" action="index.php?route=maintainers/service-types/delete" class="d-inline" onsubmit="return confirm('¿Eliminar este tipo?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $type['id']; ?>">
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
