<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h4 class="card-title mb-0">Regiones</h4>
            <small class="text-muted">Listado de regiones de Chile.</small>
        </div>
        <div class="d-flex align-items-center gap-2 align-self-start align-self-md-center">
            <span class="badge bg-soft-primary text-primary">
                <?php echo count($regions); ?> registros
            </span>
            <a href="index.php?route=maintainers/chile-regions/create" class="btn btn-primary btn-sm">
                Agregar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Región</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($regions)): ?>
                        <tr>
                            <td colspan="2" class="text-muted text-center">No hay regiones disponibles.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($regions as $region): ?>
                            <tr>
                                <td><?php echo e($region['name'] ?? ''); ?></td>
                                <td class="text-end">
                                    <a href="index.php?route=maintainers/chile-regions/edit&id=<?php echo $region['id']; ?>" class="btn btn-soft-primary btn-sm">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
