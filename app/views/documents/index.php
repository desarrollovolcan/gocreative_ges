<?php
$documents = $documents ?? [];
$documentCount = count($documents);
?>

<div class="outlook-box gap-1">
    <div class="offcanvas-lg offcanvas-start outlook-left-menu outlook-left-menu-md" tabindex="-1" id="documentsSidebarOffcanvas">
        <div class="card h-100 mb-0 rounded-0 border-0" data-simplebar>
            <div class="card-body">
                <button type="button" class="btn btn-danger fw-medium w-100" data-bs-toggle="modal" data-bs-target="#documentsUploadModal">Subir archivos</button>

                <div class="list-group list-group-flush list-custom mt-3">
                    <a href="#!" class="list-group-item list-group-item-action active">
                        <i class="ti ti-folder me-1 opacity-75 fs-lg align-middle"></i>
                        <span class="align-middle">Mis archivos</span>
                        <span class="badge align-middle bg-danger-subtle fs-xxs text-danger float-end"><?php echo e((string)$documentCount); ?></span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-share align-middle me-1 opacity-75 fs-lg"></i>
                        <span class="align-middle">Compartidos conmigo</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-clock align-middle me-1 opacity-75 fs-lg"></i>
                        <span class="align-middle">Recientes</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-star align-middle me-1 opacity-75 fs-lg"></i>
                        <span class="align-middle">Favoritos</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-download align-middle me-1 opacity-75 fs-lg"></i>
                        <span class="align-middle">Descargas</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-trash me-1 align-middle opacity-75 fs-lg"></i>
                        <span class="align-middle">Papelera</span>
                    </a>

                    <div class="list-group-item mt-2">
                        <span class="align-middle">Categorías</span>
                    </div>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-chart-donut-filled me-1 align-middle fs-sm text-primary"></i>
                        <span class="align-middle">Trabajo</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-chart-donut-filled me-1 align-middle fs-sm text-purple"></i>
                        <span class="align-middle">Proyectos</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-chart-donut-filled me-1 align-middle fs-sm text-info"></i>
                        <span class="align-middle">Medios</span>
                    </a>

                    <a href="#!" class="list-group-item list-group-item-action">
                        <i class="ti ti-chart-donut-filled me-1 align-middle fs-sm text-warning"></i>
                        <span class="align-middle">Documentos</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div data-table data-table-rows-per-page="8" class="card h-100 mb-0 rounded-0 flex-grow-1 border-0">
        <div class="card-header border-light justify-content-between">
            <div class="d-flex gap-2">
                <div class="d-lg-none d-inline-flex gap-2">
                    <button class="btn btn-default btn-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#documentsSidebarOffcanvas" aria-controls="documentsSidebarOffcanvas">
                        <i class="ti ti-menu-2 fs-lg"></i>
                    </button>
                </div>

                <div class="app-search">
                    <input data-table-search type="search" class="form-control" placeholder="Buscar archivos...">
                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                </div>
                <button data-table-delete-selected class="btn btn-danger d-none">Eliminar</button>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="me-2 fw-semibold">Filtrar por:</span>

                <div class="app-search">
                    <select data-table-filter="type" class="form-select form-control my-1 my-md-0">
                        <option value="">Tipo de archivo</option>
                        <option value="Folder">Carpeta</option>
                        <option value="MySQL">MySQL</option>
                        <option value="MP4">MP4</option>
                        <option value="Audio">Audio</option>
                        <option value="Figma">Figma</option>
                    </select>
                    <i data-lucide="file" class="app-search-icon text-muted"></i>
                </div>

                <div>
                    <select data-table-set-rows-per-page class="form-select form-control my-1 my-md-0">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body" style="height: calc(100% - 100px);" data-simplebar data-simplebar-md>
            <div class="row g-2">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" data-table-sort>
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th style="width: 24px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" data-table-check-all>
                                        </div>
                                    </th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Tamaño</th>
                                    <th>Última actualización</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($documents)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No hay documentos cargados todavía.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($documents as $document): ?>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" data-table-check>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-xs bg-light text-muted rounded-2">
                                                        <i class="ti ti-file-text fs-16 avatar-title"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold"><?php echo e($document['name']); ?></div>
                                                        <div class="text-muted fs-xs">Documentos</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo e($document['extension']); ?></td>
                                            <td><?php echo e(number_format(($document['size'] ?? 0) / 1024, 1)); ?> KB</td>
                                            <td><?php echo e($document['updated_at']); ?></td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <a class="btn btn-light" href="<?php echo e($document['download_url']); ?>">Descargar</a>
                                                    <form method="post" action="index.php?route=documents/delete" class="d-inline">
                                                        <input type="hidden" name="file" value="<?php echo e($document['filename']); ?>">
                                                        <button type="submit" class="btn btn-light text-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="documentsUploadModal" tabindex="-1" aria-labelledby="documentsUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="index.php?route=documents/store" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentsUploadModalLabel">Subir documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Archivo</label>
                        <input type="file" name="document" class="form-control" required>
                        <small class="text-muted">Máximo 10MB por archivo.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>
