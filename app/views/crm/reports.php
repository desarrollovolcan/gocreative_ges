<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <div>
                        <h4 class="card-title mb-1">Resumen Comercial</h4>
                        <p class="text-muted mb-0">KPIs clave de facturación, pipeline y servicio.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">Descargar reporte</button>
                        <button class="btn btn-outline-primary">Compartir</button>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100">
                            <p class="text-muted mb-1">Facturación mensual</p>
                            <h3 class="mb-0">$128.4k</h3>
                            <span class="badge text-bg-success">+14%</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100">
                            <p class="text-muted mb-1">Pipeline activo</p>
                            <h3 class="mb-0">$392k</h3>
                            <span class="badge text-bg-info">38 oportunidades</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100">
                            <p class="text-muted mb-1">SLA de servicio</p>
                            <h3 class="mb-0">94%</h3>
                            <span class="badge text-bg-warning">3 alertas</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h5 class="mb-3">Actividad prioritaria</h5>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Oportunidad</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Siguiente paso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Andrés Bakery</td>
                                    <td>Rediseño web</td>
                                    <td>Camila Díaz</td>
                                    <td><span class="badge text-bg-primary">Propuesta</span></td>
                                    <td>Revisar alcance</td>
                                </tr>
                                <tr>
                                    <td>Nova Logistics</td>
                                    <td>Soporte ERP</td>
                                    <td>Diego Pérez</td>
                                    <td><span class="badge text-bg-success">Ganada</span></td>
                                    <td>Kickoff</td>
                                </tr>
                                <tr>
                                    <td>Cloudline</td>
                                    <td>Automatización marketing</td>
                                    <td>Andrea López</td>
                                    <td><span class="badge text-bg-warning">Negociación</span></td>
                                    <td>Ajuste de pricing</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Filtros inteligentes</h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label" for="crm-report-range">Rango de fechas</label>
                        <select class="form-select" id="crm-report-range">
                            <option selected>Últimos 30 días</option>
                            <option>Trimestre actual</option>
                            <option>Año en curso</option>
                            <option>Personalizado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="crm-report-team">Equipo</label>
                        <select class="form-select" id="crm-report-team">
                            <option selected>Todos</option>
                            <option>Ventas</option>
                            <option>Delivery</option>
                            <option>Soporte</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="crm-report-region">Región</label>
                        <select class="form-select" id="crm-report-region">
                            <option selected>Todas</option>
                            <option>Latam</option>
                            <option>Norteamérica</option>
                            <option>Europa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="crm-report-owner">Responsable</label>
                        <input type="text" class="form-control" id="crm-report-owner" placeholder="Buscar responsable">
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-secondary">Aplicar filtros</button>
                        <button type="button" class="btn btn-outline-secondary">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Accesos rápidos</h5>
                <div class="d-grid gap-2">
                    <a href="index.php?route=projects" class="btn btn-outline-primary">Proyectos</a>
                    <a href="index.php?route=notifications" class="btn btn-outline-info">Actividad</a>
                    <a href="index.php?route=tickets" class="btn btn-outline-warning">Service Desk</a>
                    <a href="index.php?route=invoices" class="btn btn-outline-success">Facturación</a>
                </div>
            </div>
        </div>
    </div>
</div>
