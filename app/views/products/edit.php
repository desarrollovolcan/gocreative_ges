<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Editar producto</h4>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=products/update">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" value="<?php echo (int)($product['id'] ?? 0); ?>">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo e($product['name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control" value="<?php echo e($product['sku'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Proveedor</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">Sin proveedor</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?php echo (int)$supplier['id']; ?>" <?php echo ((int)($product['supplier_id'] ?? 0) === (int)$supplier['id']) ? 'selected' : ''; ?>>
                                        <?php echo e($supplier['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Precio venta</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" value="<?php echo e((float)($product['price'] ?? 0)); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Costo</label>
                            <input type="number" name="cost" class="form-control" step="0.01" min="0" value="<?php echo e((float)($product['cost'] ?? 0)); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" min="0" value="<?php echo e((int)($product['stock'] ?? 0)); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stock mínimo</label>
                            <input type="number" name="stock_min" class="form-control" min="0" value="<?php echo e((int)($product['stock_min'] ?? 0)); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                <option value="activo" <?php echo ($product['status'] ?? '') === 'activo' ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactivo" <?php echo ($product['status'] ?? '') === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo e($product['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Actualizar producto</button>
                            <a href="index.php?route=products" class="btn btn-light ms-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
