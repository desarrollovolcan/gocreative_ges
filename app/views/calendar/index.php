<?php
$documents = $documents ?? [];
$users = $users ?? [];
$documentCount = count($documents);
$userCount = count($users);
$documentHelp = $documentCount > 0
    ? 'Adjunta documentos del módulo Documentos para preparar cada reunión o recordatorio.'
    : 'Aún no hay documentos disponibles. Súbelos desde el módulo de Documentos.';
$attendeeHelp = $userCount > 0
    ? 'Selecciona participantes internos para compartir el evento.'
    : 'No hay usuarios disponibles en tu empresa.';
?>

<div class="d-flex mb-3 gap-1">
    <div class="card h-100 mb-0 d-none d-lg-flex rounded-end-0">
        <div class="card-body">
            <button class="btn btn-primary w-100 btn-new-event">
                <i class="ti ti-plus me-2 align-middle"></i>
                Crear evento
            </button>

            <div id="external-events">
                <p class="text-muted mt-2 fst-italic fs-xs mb-3">Arrastra un tipo de evento al calendario o haz clic en la fecha.</p>

                <div class="external-event fc-event bg-primary-subtle text-primary fw-semibold" data-class="bg-primary-subtle text-primary" data-type="meeting">
                    <i class="ti ti-circle-filled me-2"></i>Reunión de equipo
                </div>

                <div class="external-event fc-event bg-secondary-subtle text-secondary fw-semibold" data-class="bg-secondary-subtle text-secondary" data-type="reminder">
                    <i class="ti ti-circle-filled me-2"></i>Recordatorio importante
                </div>

                <div class="external-event fc-event bg-success-subtle text-success fw-semibold" data-class="bg-success-subtle text-success" data-type="task">
                    <i class="ti ti-circle-filled me-2"></i>Tarea pendiente
                </div>

                <div class="external-event fc-event bg-info-subtle text-info fw-semibold" data-class="bg-info-subtle text-info" data-type="meeting">
                    <i class="ti ti-circle-filled me-2"></i>Reunión con cliente
                </div>

                <div class="external-event fc-event bg-warning-subtle text-warning fw-semibold" data-class="bg-warning-subtle text-warning" data-type="reminder">
                    <i class="ti ti-circle-filled me-2"></i>Entrega de proyecto
                </div>

                <div class="external-event fc-event bg-danger-subtle text-danger fw-semibold" data-class="bg-danger-subtle text-danger" data-type="reminder">
                    <i class="ti ti-circle-filled me-2"></i>Pago y facturación
                </div>
            </div>

        </div>
    </div> <!-- end card-->

    <div class="card h-100 mb-0 rounded-start-0 flex-grow-1 border-start-0">
        <div class="d-lg-none d-inline-flex card-header">
            <button class="btn btn-primary btn-new-event">
                <i class="ti ti-plus me-2 align-middle"></i>
                Crear evento
            </button>
        </div>

        <div class="card-body" style="height: calc(100% - 350px);" data-simplebar data-simplebar-md>
            <div id="calendar"></div>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> <!-- end row-->

<!-- Modal Add/Edit -->
<div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form class="needs-validation" name="event-form" id="forms-event" novalidate>
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">
                        Crear evento
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="event-id">

                    <div class="row g-2">
                        <div class="col-12">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-title">Título</label>
                                <input class="form-control" placeholder="Ingresa un título" type="text" name="title" id="event-title" required>
                                <div class="invalid-feedback">Ingresa un título válido.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-type">Tipo de evento</label>
                                <select class="form-select" name="type" id="event-type" required>
                                    <option value="meeting">Reunión</option>
                                    <option value="reminder">Recordatorio</option>
                                    <option value="task">Tarea</option>
                                </select>
                                <div class="invalid-feedback">Selecciona un tipo de evento.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-category">Color</label>
                                <select class="form-select" name="category" id="event-category" required>
                                    <option value="bg-primary-subtle text-primary" selected>Primario</option>
                                    <option value="bg-secondary-subtle text-secondary">Secundario</option>
                                    <option value="bg-success-subtle text-success">Éxito</option>
                                    <option value="bg-info-subtle text-info">Info</option>
                                    <option value="bg-warning-subtle text-warning">Advertencia</option>
                                    <option value="bg-danger-subtle text-danger">Urgente</option>
                                    <option value="bg-dark-subtle text-dark">Oscuro</option>
                                </select>
                                <div class="invalid-feedback">Selecciona un color válido.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-start">Inicio</label>
                                <input class="form-control" type="datetime-local" name="start" id="event-start" required>
                                <div class="invalid-feedback">Ingresa una fecha de inicio.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-end">Término</label>
                                <input class="form-control" type="datetime-local" name="end" id="event-end">
                                <div class="invalid-feedback">La fecha de término no puede ser anterior al inicio.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-location">Lugar o enlace</label>
                                <input class="form-control" type="text" name="location" id="event-location" placeholder="Sala, Zoom, enlace Meet">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-reminder">Recordatorio</label>
                                <select class="form-select" name="reminder" id="event-reminder">
                                    <option value="">Sin recordatorio</option>
                                    <option value="5">5 minutos antes</option>
                                    <option value="10">10 minutos antes</option>
                                    <option value="30">30 minutos antes</option>
                                    <option value="60">1 hora antes</option>
                                    <option value="1440">1 día antes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="event-all-day" name="all_day">
                                <label class="form-check-label" for="event-all-day">Todo el día</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-description">Descripción</label>
                                <textarea class="form-control" name="description" id="event-description" rows="3" placeholder="Agrega notas, agenda o detalles"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-2">
                                <label class="control-label form-label">Documentos adjuntos</label>
                                <p class="text-muted fs-xs mb-2"><?php echo e($documentHelp); ?></p>
                                <?php if ($documentCount === 0): ?>
                                    <a class="btn btn-sm btn-outline-primary" href="index.php?route=documents">Ir a Documentos</a>
                                <?php else: ?>
                                    <div class="border rounded-2 p-2 mb-2" style="max-height: 180px; overflow-y: auto;">
                                        <?php foreach ($documents as $document): ?>
                                            <?php $docId = (int)$document['id']; ?>
                                            <div class="form-check mb-1">
                                                <input class="form-check-input calendar-document-checkbox" type="checkbox" value="<?php echo e((string)$docId); ?>" id="calendar-doc-<?php echo e((string)$docId); ?>" data-document-name="<?php echo e((string)$document['name']); ?>" data-document-url="<?php echo e((string)$document['download_url']); ?>">
                                                <label class="form-check-label" for="calendar-doc-<?php echo e((string)$docId); ?>">
                                                    <?php echo e((string)$document['name']); ?>
                                                    <span class="text-muted fs-xxs">· <?php echo e((string)$document['extension']); ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="border rounded-2 p-2 bg-light" id="event-documents-preview">
                                    <span class="text-muted fs-xs">Sin documentos adjuntos.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-2">
                                <label class="control-label form-label" for="event-attendees">Invitados internos</label>
                                <p class="text-muted fs-xs mb-2"><?php echo e($attendeeHelp); ?></p>
                                <?php if ($userCount === 0): ?>
                                    <span class="text-muted fs-xs">No hay usuarios activos para asignar.</span>
                                <?php else: ?>
                                    <select class="form-select" name="attendees[]" id="event-attendees" multiple size="5">
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?php echo e((string)$user['id']); ?>" data-user-name="<?php echo e((string)($user['name'] ?? '')); ?>">
                                                <?php echo e((string)($user['name'] ?? '')); ?>
                                                <?php if (!empty($user['email'])): ?>
                                                    (<?php echo e((string)$user['email']); ?>)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                                <div class="border rounded-2 p-2 bg-light mt-2" id="event-attendees-preview">
                                    <span class="text-muted fs-xs">Sin invitados asignados.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                        <button type="button" class="btn btn-danger" id="btn-delete-event">
                            Eliminar
                        </button>

                        <button type="button" class="btn btn-light ms-auto" data-bs-dismiss="modal">
                            Cerrar
                        </button>

                        <button type="submit" class="btn btn-primary" id="btn-save-event">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>
<!-- end modal-->

<script>
    window.calendarConfig = {
        eventsUrl: 'index.php?route=calendar/events',
        storeUrl: 'index.php?route=calendar/store',
        deleteUrl: 'index.php?route=calendar/delete',
        csrfToken: '<?php echo csrf_token(); ?>'
    };
</script>

<!-- Fullcalendar js -->
<script src="assets/plugins/fullcalendar/index.global.min.js"></script>

<!-- Calendar App js -->
<script src="assets/js/pages/apps-calendar.js"></script>
