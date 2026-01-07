<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Nuevo proveedor</h4>
                <a href="index.php?route=suppliers" class="btn btn-outline-secondary">Volver a la lista</a>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=suppliers/store">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="row g-3">
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Persona de contacto</label>
                            <input type="text" name="contact_name" class="form-control" placeholder="Nombre del contacto">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">RUT / ID</label>
                            <input type="text" name="tax_id" class="form-control" placeholder="12.345.678-9">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="contacto@proveedor.com">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="phone" class="form-control" placeholder="+56 9 1234 5678">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Sitio web</label>
                            <input type="url" name="website" class="form-control" placeholder="https://proveedor.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="address" class="form-control" placeholder="Calle y número">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Giro</label>
                            <input type="text" name="giro" class="form-control" placeholder="Ej: Servicios profesionales">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Código actividad</label>
                            <input type="text" name="activity_code" class="form-control" placeholder="Ej: 620100">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Comuna</label>
                            <input type="text" name="commune" class="form-control">
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="city" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notas</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Información adicional, condiciones de pago, etc."></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Guardar proveedor</button>
                            <a href="index.php?route=suppliers" class="btn btn-light ms-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Proveedores registrados</h4>
                <a href="index.php?route=suppliers" class="btn btn-soft-primary btn-sm">Ver listado completo</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Contacto</th>
                                <th>RUT / ID</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Sitio web</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($suppliers)): ?>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <tr>
                                        <td class="text-muted"><?php echo render_id_badge($supplier['id'] ?? null); ?></td>
                                        <td><?php echo e($supplier['name'] ?? ''); ?></td>
                                        <td><?php echo e($supplier['contact_name'] ?? ''); ?></td>
                                        <td><?php echo e($supplier['tax_id'] ?? ''); ?></td>
                                        <td><?php echo e($supplier['email'] ?? ''); ?></td>
                                        <td><?php echo e($supplier['phone'] ?? ''); ?></td>
                                        <td><?php echo e($supplier['address'] ?? ''); ?></td>
                                        <td><?php echo e($supplier['website'] ?? ''); ?></td>
                                        <td class="text-end">
                                            <div class="dropdown actions-dropdown">
                                                <button class="btn btn-soft-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Acciones
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="index.php?route=suppliers/edit&id=<?php echo (int)$supplier['id']; ?>">Editar</a></li>
                                                    <li>
                                                        <form method="post" action="index.php?route=suppliers/delete" onsubmit="return confirm('¿Eliminar este proveedor?');">
                                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="id" value="<?php echo (int)$supplier['id']; ?>">
                                                            <button type="submit" class="dropdown-item dropdown-item-button text-danger">Eliminar</button>
                                                        
    <?php
    $reportTemplate = 'informeIcargaEspanol.php';
    $reportSource = 'suppliers/create';
    include __DIR__ . '/../partials/report-download.php';
    ?>
</form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Aún no hay proveedores registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
