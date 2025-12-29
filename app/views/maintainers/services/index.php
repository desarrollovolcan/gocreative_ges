<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Servicios</h4>
        <a href="index.php?route=maintainers/services/create" class="btn btn-primary">Nuevo servicio</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th class="text-end">Costo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo e($service['name']); ?></td>
                            <td><?php echo e($service['type_name']); ?></td>
                            <td class="text-end"><?php echo e(format_currency((float)($service['cost'] ?? 0))); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=maintainers/services/edit&id=<?php echo $service['id']; ?>" class="btn btn-light btn-sm">Editar</a>
                                <form method="post" action="index.php?route=maintainers/services/delete" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
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
