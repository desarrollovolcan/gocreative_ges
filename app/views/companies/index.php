<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Empresas</h5>
            <a href="index.php?route=companies/create" class="btn btn-primary">Nueva empresa</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($companies ?? []) as $company): ?>
                        <tr>
                            <td><?php echo e($company['name'] ?? ''); ?></td>
                            <td><?php echo e($company['rut'] ?? ''); ?></td>
                            <td><?php echo e($company['email'] ?? ''); ?></td>
                            <td><?php echo e($company['phone'] ?? ''); ?></td>
                            <td><?php echo e($company['address'] ?? ''); ?></td>
                            <td class="text-end">
                                <a href="index.php?route=companies/edit&id=<?php echo e((string)$company['id']); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
