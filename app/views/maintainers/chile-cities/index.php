<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h4 class="card-title mb-0">Ciudades</h4>
            <small class="text-muted">Listado de ciudades de Chile.</small>
        </div>
        <div class="d-flex align-items-center gap-2 align-self-start align-self-md-center">
            <span class="badge bg-soft-primary text-primary">
                <?php echo count($cities); ?> registros
            </span>
            <a href="index.php?route=maintainers/chile-cities/create" class="btn btn-primary btn-sm">
                Agregar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Ciudad</th>
                        <th>Región</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cities)): ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center">No hay ciudades disponibles.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($cities as $city): ?>
                            <tr>
                                <td><?php echo e($city['name'] ?? ''); ?></td>
                                <td><?php echo e($city['region'] ?? ''); ?></td>
                                <td class="text-end">
                                    <a href="index.php?route=maintainers/chile-cities/edit&id=<?php echo $city['id']; ?>" class="btn btn-soft-primary btn-sm">
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
