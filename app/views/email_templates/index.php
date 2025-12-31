<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Plantillas de correo</h4>
        <div class="d-flex flex-wrap gap-2">
            <form method="post" action="index.php?route=email-templates/seed-defaults" class="d-inline">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <button type="submit" class="btn btn-outline-primary">Cargar plantillas base</button>
            </form>
            <a href="index.php?route=email-templates/create" class="btn btn-primary">Nueva plantilla</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Asunto</th>
                        <th>Tipo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($templates as $template): ?>
                        <tr>
                            <td><?php echo e($template['name']); ?></td>
                            <td><?php echo e($template['subject']); ?></td>
                            <td><?php echo e($template['type']); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=email-templates/edit&id=<?php echo $template['id']; ?>" class="btn btn-soft-primary btn-sm">Editar</a>
                                <form method="post" action="index.php?route=email-templates/delete" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="id" value="<?php echo $template['id']; ?>">
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
