<div class="outlook-box gap-1">
    <div class="offcanvas-lg offcanvas-start outlook-left-menu outlook-left-menu-md" tabindex="-1" id="documentsSidebarOffcanvas">
        <div class="card h-100 mb-0 rounded-0 border-0" data-simplebar>
            <div class="card-body">
                <a href="#!" class="btn btn-danger fw-medium w-100">Subir archivos</a>

                <div class="list-group list-group-flush list-custom mt-3">
                    <a href="#!" class="list-group-item list-group-item-action active">
                        <i class="ti ti-folder me-1 opacity-75 fs-lg align-middle"></i>
                        <span class="align-middle">Mis archivos</span>
                        <span class="badge align-middle bg-danger-subtle fs-xxs text-danger float-end">12</span>
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
            <div class="row g-2 mb-3">
                <div class="col-md-6 col-lg-4 col-xxl-3">
                    <div class="card border border-dashed mb-0">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="flex-shrink-0 avatar-md bg-light bg-opacity-50 text-muted rounded-2">
                                    <i class="ti ti-folder fs-24 avatar-title"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fs-sm"><a href="#!" class="link-reset">Documentación
                                            fiscal</a></h5>
                                    <p class="text-muted mb-0 fs-xs">2.3 GB</p>
                                </div>
                                <div class="dropdown flex-shrink-0 text-muted">
                                    <a href="#" class="dropdown-toggle drop-arrow-none fs-xxl link-reset p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item"><i class="ti ti-share me-1"></i> Compartir</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-link me-1"></i> Obtener enlace</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-download me-1"></i> Descargar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-pin me-1"></i> Fijar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-edit me-1"></i> Editar</a>
                                        <a href="#!" class="dropdown-item" data-dismissible="#documents-tax"><i class="ti ti-trash me-1"></i> Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xxl-3">
                    <div class="card border border-dashed mb-0">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="flex-shrink-0 avatar-md bg-light bg-opacity-50 text-muted rounded-2">
                                    <i class="ti ti-folder fs-24 avatar-title"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fs-sm"><a href="#!" class="link-reset">Contratos
                                            legales</a></h5>
                                    <p class="text-muted mb-0 fs-xs">105.3 MB</p>
                                </div>
                                <div class="dropdown flex-shrink-0 text-muted">
                                    <a href="#" class="dropdown-toggle drop-arrow-none fs-xxl link-reset p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item"><i class="ti ti-share me-1"></i> Compartir</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-link me-1"></i> Obtener enlace</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-download me-1"></i> Descargar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-pin me-1"></i> Fijar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-edit me-1"></i> Editar</a>
                                        <a href="#!" class="dropdown-item" data-dismissible="#documents-contracts"><i class="ti ti-trash me-1"></i> Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xxl-3">
                    <div class="card border border-dashed mb-0">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="flex-shrink-0 avatar-md bg-light bg-opacity-50 text-muted rounded-2">
                                    <i class="ti ti-folder fs-24 avatar-title"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fs-sm"><a href="#!" class="link-reset">Evidencias
                                            comerciales</a></h5>
                                    <p class="text-muted mb-0 fs-xs">512 MB</p>
                                </div>
                                <div class="dropdown flex-shrink-0 text-muted">
                                    <a href="#" class="dropdown-toggle drop-arrow-none fs-xxl link-reset p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item"><i class="ti ti-share me-1"></i> Compartir</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-link me-1"></i> Obtener enlace</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-download me-1"></i> Descargar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-pin me-1"></i> Fijar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-edit me-1"></i> Editar</a>
                                        <a href="#!" class="dropdown-item" data-dismissible="#documents-sales"><i class="ti ti-trash me-1"></i> Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xxl-3">
                    <div class="card border border-dashed mb-0">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="flex-shrink-0 avatar-md bg-light bg-opacity-50 text-muted rounded-2">
                                    <i class="ti ti-folder fs-24 avatar-title"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fs-sm"><a href="#!" class="link-reset">Recursos de
                                            marketing</a></h5>
                                    <p class="text-muted mb-0 fs-xs">980 MB</p>
                                </div>
                                <div class="dropdown flex-shrink-0 text-muted">
                                    <a href="#" class="dropdown-toggle drop-arrow-none fs-xxl link-reset p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item"><i class="ti ti-share me-1"></i> Compartir</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-link me-1"></i> Obtener enlace</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-download me-1"></i> Descargar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-pin me-1"></i> Fijar</a>
                                        <a href="#!" class="dropdown-item"><i class="ti ti-edit me-1"></i> Editar</a>
                                        <a href="#!" class="dropdown-item" data-dismissible="#documents-marketing"><i class="ti ti-trash me-1"></i> Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                                <div class="fw-semibold">Contrato cliente - Enero.pdf</div>
                                                <div class="text-muted fs-xs">Clientes</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>PDF</td>
                                    <td>2.4 MB</td>
                                    <td>12/01/2024</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-light">Ver</button>
                                            <button class="btn btn-light">Descargar</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" data-table-check>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-xs bg-light text-muted rounded-2">
                                                <i class="ti ti-file-spreadsheet fs-16 avatar-title"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">Balance de pagos.xlsx</div>
                                                <div class="text-muted fs-xs">Finanzas</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>XLSX</td>
                                    <td>1.2 MB</td>
                                    <td>02/02/2024</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-light">Ver</button>
                                            <button class="btn btn-light">Descargar</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" data-table-check>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-xs bg-light text-muted rounded-2">
                                                <i class="ti ti-photo fs-16 avatar-title"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">Campaña redes.jpg</div>
                                                <div class="text-muted fs-xs">Marketing</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>JPG</td>
                                    <td>3.8 MB</td>
                                    <td>11/03/2024</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-light">Ver</button>
                                            <button class="btn btn-light">Descargar</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" data-table-check>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-xs bg-light text-muted rounded-2">
                                                <i class="ti ti-music fs-16 avatar-title"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">Audio spot.mp3</div>
                                                <div class="text-muted fs-xs">Media</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>MP3</td>
                                    <td>6.7 MB</td>
                                    <td>22/03/2024</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-light">Ver</button>
                                            <button class="btn btn-light">Descargar</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
