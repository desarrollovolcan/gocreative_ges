/**
 * Template Name: UBold - Admin & Dashboard Template
 * By (Author): Coderthemes
 * Module/App (File Name): Apps Calendar
 */

class CalendarSchedule {
    constructor() {
        this.body = document.body;
        this.modal = new bootstrap.Modal(document.getElementById('event-modal'), {backdrop: 'static'});
        this.calendar = document.getElementById('calendar');
        this.formEvent = document.getElementById('forms-event');
        this.btnNewEvent = document.querySelectorAll('.btn-new-event');
        this.btnDeleteEvent = document.getElementById('btn-delete-event');
        this.btnSaveEvent = document.getElementById('btn-save-event');
        this.modalTitle = document.getElementById('modal-title');
        this.eventIdInput = document.getElementById('event-id');
        this.eventTitleInput = document.getElementById('event-title');
        this.eventTypeInput = document.getElementById('event-type');
        this.eventCategoryInput = document.getElementById('event-category');
        this.eventStartInput = document.getElementById('event-start');
        this.eventEndInput = document.getElementById('event-end');
        this.eventLocationInput = document.getElementById('event-location');
        this.eventReminderInput = document.getElementById('event-reminder');
        this.eventAllDayInput = document.getElementById('event-all-day');
        this.eventDescriptionInput = document.getElementById('event-description');
        this.documentPreview = document.getElementById('event-documents-preview');
        this.documentCheckboxes = document.querySelectorAll('.calendar-document-checkbox');
        this.config = window.calendarConfig || {};
        this.calendarObj = null;
        this.selectedEvent = null;
        this.newEventData = null;
        this.pendingEvent = null;
        this.activeDocumentIds = [];
    }

    init() {
        const today = new Date();
        const self = this;
        const externalEventContainerEl = document.getElementById('external-events');

        if (externalEventContainerEl) {
            new FullCalendar.Draggable(externalEventContainerEl, {
                itemSelector: '.external-event',
                eventData: function (eventEl) {
                    return {
                        title: eventEl.innerText.trim(),
                        classNames: eventEl.getAttribute('data-class'),
                        extendedProps: {
                            type: eventEl.getAttribute('data-type') || 'meeting'
                        }
                    };
                }
            });
        }

        self.calendarObj = new FullCalendar.Calendar(self.calendar, {
            plugins: [],
            slotDuration: '00:30:00',
            slotMinTime: '07:00:00',
            slotMaxTime: '19:00:00',
            themeSystem: 'bootstrap',
            bootstrapFontAwesome: false,
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista',
                prev: 'Anterior',
                next: 'Siguiente'
            },
            initialView: 'dayGridMonth',
            handleWindowResize: true,
            height: window.innerHeight - 240,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            events: self.config.eventsUrl || [],
            editable: true,
            droppable: true,
            selectable: true,
            select: function (info) {
                self.onSelect(info);
            },
            dateClick: function (info) {
                self.onSelect(info);
            },
            eventClick: function (info) {
                self.onEventClick(info);
            },
            eventReceive: function (info) {
                self.pendingEvent = info.event;
                self.selectedEvent = info.event;
                self.openModalWithEvent(info.event, true);
            },
            eventDrop: function (info) {
                self.persistEvent(info.event, false).catch(function () {
                    info.revert();
                });
            },
            eventResize: function (info) {
                self.persistEvent(info.event, false).catch(function () {
                    info.revert();
                });
            }
        });

        self.calendarObj.render();

        self.btnNewEvent.forEach(function (btn) {
            btn.addEventListener('click', function () {
                self.onSelect({
                    date: new Date(),
                    allDay: true
                });
            });
        });

        if (self.eventAllDayInput) {
            self.eventAllDayInput.addEventListener('change', function () {
                self.syncAllDayInputs();
            });
        }

        self.documentCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                self.updateDocumentPreview();
            });
        });

        self.formEvent?.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = self.formEvent;

            if (form.checkValidity()) {
                self.saveEvent().catch(function (error) {
                    console.error(error);
                    alert('No pudimos guardar el evento.');
                });
            } else {
                e.stopPropagation();
                form.classList.add('was-validated');
            }
        });

        self.btnDeleteEvent?.addEventListener('click', function () {
            self.deleteEvent().catch(function (error) {
                console.error(error);
                alert('No pudimos eliminar el evento.');
            });
        });

        const modalEl = document.getElementById('event-modal');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                if (self.pendingEvent) {
                    self.pendingEvent.remove();
                    self.pendingEvent = null;
                }
            });
        }
    }

    onEventClick(info) {
        this.formEvent?.reset();
        this.formEvent.classList.remove('was-validated');
        this.newEventData = null;
        this.pendingEvent = null;
        this.btnDeleteEvent.style.display = 'block';
        this.modalTitle.text = 'Editar evento';
        this.selectedEvent = info.event;
        this.openModalWithEvent(info.event, false);
    }

    onSelect(info) {
        this.formEvent?.reset();
        this.formEvent?.classList.remove('was-validated');
        this.selectedEvent = null;
        this.pendingEvent = null;
        this.newEventData = info;
        this.btnDeleteEvent.style.display = 'none';
        this.modalTitle.text = 'Crear evento';
        this.populateFormForNewEvent(info);
        this.modal.show();
        this.calendarObj.unselect();
    }

    openModalWithEvent(event, isNewFromDrop) {
        this.formEvent?.classList.remove('was-validated');
        if (isNewFromDrop) {
            this.btnDeleteEvent.style.display = 'none';
            this.modalTitle.text = 'Crear evento';
        } else {
            this.btnDeleteEvent.style.display = 'block';
            this.modalTitle.text = 'Editar evento';
        }
        this.populateFormFromEvent(event);
        this.modal.show();
    }

    populateFormForNewEvent(info) {
        if (this.eventIdInput) {
            this.eventIdInput.value = '';
        }
        if (this.eventTitleInput) {
            this.eventTitleInput.value = '';
        }
        if (this.eventTypeInput) {
            this.eventTypeInput.value = 'meeting';
        }
        if (this.eventCategoryInput) {
            this.eventCategoryInput.value = 'bg-primary-subtle text-primary';
        }
        const selection = this.normalizeSelection(info);
        if (this.eventAllDayInput) {
            this.eventAllDayInput.checked = selection.allDay === true;
        }
        this.setDateInputs(selection.start, selection.allDay === true, selection.end);
        if (this.eventLocationInput) {
            this.eventLocationInput.value = '';
        }
        if (this.eventReminderInput) {
            this.eventReminderInput.value = '';
        }
        if (this.eventDescriptionInput) {
            this.eventDescriptionInput.value = '';
        }
        this.resetDocumentSelection([]);
    }

    populateFormFromEvent(event) {
        if (this.eventIdInput) {
            this.eventIdInput.value = event.id || '';
        }
        if (this.eventTitleInput) {
            this.eventTitleInput.value = event.title || '';
        }
        if (this.eventTypeInput) {
            this.eventTypeInput.value = event.extendedProps?.type || 'meeting';
        }
        if (this.eventCategoryInput) {
            const classNames = event.classNames || [];
            this.eventCategoryInput.value = Array.isArray(classNames) ? classNames.join(' ') : classNames || 'bg-primary-subtle text-primary';
        }
        if (this.eventAllDayInput) {
            this.eventAllDayInput.checked = event.allDay === true;
        }
        const endDate = event.allDay ? this.normalizeAllDayEndForForm(event.end) : event.end;
        this.setDateInputs(event.start, event.allDay === true, endDate);
        if (this.eventLocationInput) {
            this.eventLocationInput.value = event.extendedProps?.location || '';
        }
        if (this.eventReminderInput) {
            const reminder = event.extendedProps?.reminder_minutes;
            this.eventReminderInput.value = reminder !== null && reminder !== undefined ? String(reminder) : '';
        }
        if (this.eventDescriptionInput) {
            this.eventDescriptionInput.value = event.extendedProps?.description || '';
        }
        const docs = event.extendedProps?.documents || [];
        this.resetDocumentSelection(docs.map(function (doc) { return doc.id; }));
    }

    setDateInputs(startDate, allDay, endDate = null) {
        if (!this.eventStartInput) {
            return;
        }
        const startValue = this.formatDateInput(startDate, allDay);
        this.eventStartInput.value = startValue || '';
        if (this.eventEndInput) {
            const endValue = this.formatDateInput(endDate || startDate, allDay);
            this.eventEndInput.value = endValue || '';
        }
        this.syncAllDayInputs();
    }

    formatDateInput(value, allDay) {
        if (!value) {
            return '';
        }
        const date = value instanceof Date ? value : new Date(value);
        if (Number.isNaN(date.getTime())) {
            return '';
        }
        const offset = date.getTimezoneOffset();
        const localDate = new Date(date.getTime() - offset * 60000);
        const iso = localDate.toISOString();
        return allDay ? iso.slice(0, 10) + 'T00:00' : iso.slice(0, 16);
    }

    syncAllDayInputs() {
        if (!this.eventAllDayInput || !this.eventStartInput || !this.eventEndInput) {
            return;
        }
        if (this.eventAllDayInput.checked) {
            this.eventStartInput.type = 'date';
            this.eventEndInput.type = 'date';
            if (this.eventStartInput.value) {
                this.eventStartInput.value = this.eventStartInput.value.slice(0, 10);
            }
            if (this.eventEndInput.value) {
                this.eventEndInput.value = this.eventEndInput.value.slice(0, 10);
            }
        } else {
            this.eventStartInput.type = 'datetime-local';
            this.eventEndInput.type = 'datetime-local';
        }
    }

    normalizeSelection(info) {
        const start = info.start || info.date || new Date();
        let end = info.end || info.date || start;
        if (info.allDay && info.end) {
            const endDate = new Date(info.end);
            endDate.setDate(endDate.getDate() - 1);
            end = endDate;
        }
        return {
            start: start,
            end: end,
            allDay: info.allDay === true
        };
    }

    normalizeAllDayEndForForm(endDate) {
        if (!endDate) {
            return null;
        }
        const adjusted = new Date(endDate);
        adjusted.setDate(adjusted.getDate() - 1);
        return adjusted;
    }

    buildPayload() {
        const allDay = this.eventAllDayInput?.checked || false;
        const startRaw = this.eventStartInput?.value || '';
        const endRaw = this.eventEndInput?.value || '';
        const start = this.normalizeInputDate(startRaw, allDay);
        const end = this.normalizeInputDate(endRaw, allDay);

        return {
            id: this.eventIdInput?.value || null,
            title: this.eventTitleInput?.value || '',
            type: this.eventTypeInput?.value || 'meeting',
            class_name: this.eventCategoryInput?.value || 'bg-primary-subtle text-primary',
            start: start,
            end: end,
            all_day: allDay ? 1 : 0,
            location: this.eventLocationInput?.value || '',
            reminder_minutes: this.eventReminderInput?.value || null,
            description: this.eventDescriptionInput?.value || '',
            documents: this.getSelectedDocumentIds(),
            csrf_token: this.config.csrfToken
        };
    }

    normalizeInputDate(value, allDay) {
        if (!value) {
            return null;
        }
        if (allDay) {
            return value.length > 10 ? value.slice(0, 10) : value;
        }
        return value;
    }

    getSelectedDocumentIds() {
        const ids = [];
        this.documentCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                ids.push(parseInt(checkbox.value, 10));
            }
        });
        return ids;
    }

    resetDocumentSelection(selectedIds) {
        this.activeDocumentIds = selectedIds || [];
        this.documentCheckboxes.forEach(function (checkbox) {
            const id = parseInt(checkbox.value, 10);
            checkbox.checked = selectedIds.includes(id);
        });
        this.updateDocumentPreview();
    }

    updateDocumentPreview() {
        if (!this.documentPreview) {
            return;
        }
        const selected = [];
        this.documentCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selected.push({
                    id: parseInt(checkbox.value, 10),
                    name: checkbox.getAttribute('data-document-name'),
                    url: checkbox.getAttribute('data-document-url')
                });
            }
        });
        if (selected.length === 0) {
            this.documentPreview.innerHTML = '<span class="text-muted fs-xs">Sin documentos adjuntos.</span>';
            return;
        }
        this.documentPreview.innerHTML = selected.map(function (doc) {
            return '<div class="d-flex align-items-center gap-2 fs-xs">' +
                '<i class="ti ti-file"></i>' +
                '<a class="link-reset" href="' + doc.url + '" target="_blank">' + doc.name + '</a>' +
                '</div>';
        }).join('');
    }

    async saveEvent() {
        const payload = this.buildPayload();
        if (!payload.title || !payload.start) {
            return;
        }
        const response = await fetch(this.config.storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Error al guardar el evento');
        }
        const eventData = this.buildEventData(payload, result.id);

        if (this.selectedEvent) {
            this.applyEventUpdates(this.selectedEvent, eventData);
        } else if (this.pendingEvent) {
            this.applyEventUpdates(this.pendingEvent, eventData);
            this.pendingEvent = null;
        } else {
            this.calendarObj.addEvent(eventData);
        }

        this.selectedEvent = null;
        this.modal.hide();
    }

    buildEventData(payload, id) {
        return {
            id: id,
            title: payload.title,
            start: payload.start,
            end: payload.end || null,
            allDay: payload.all_day === 1,
            className: payload.class_name,
            extendedProps: {
                type: payload.type,
                location: payload.location,
                description: payload.description,
                reminder_minutes: payload.reminder_minutes !== null && payload.reminder_minutes !== '' ? parseInt(payload.reminder_minutes, 10) : null,
                documents: this.collectSelectedDocuments()
            }
        };
    }

    collectSelectedDocuments() {
        const docs = [];
        this.documentCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                docs.push({
                    id: parseInt(checkbox.value, 10),
                    name: checkbox.getAttribute('data-document-name'),
                    download_url: checkbox.getAttribute('data-document-url')
                });
            }
        });
        return docs;
    }

    applyEventUpdates(event, data) {
        event.setProp('title', data.title);
        event.setStart(data.start);
        event.setEnd(data.end);
        event.setAllDay(data.allDay);
        event.setProp('classNames', data.className.split(' '));
        event.setExtendedProp('type', data.extendedProps.type);
        event.setExtendedProp('location', data.extendedProps.location);
        event.setExtendedProp('description', data.extendedProps.description);
        event.setExtendedProp('reminder_minutes', data.extendedProps.reminder_minutes);
        event.setExtendedProp('documents', data.extendedProps.documents);
    }

    async deleteEvent() {
        if (!this.selectedEvent) {
            return;
        }
        const response = await fetch(this.config.deleteUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: this.selectedEvent.id,
                csrf_token: this.config.csrfToken
            })
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Error al eliminar el evento');
        }
        this.selectedEvent.remove();
        this.selectedEvent = null;
        this.modal.hide();
    }

    async persistEvent(event, showModalOnError) {
        const payload = {
            id: event.id,
            title: event.title,
            type: event.extendedProps?.type || 'meeting',
            class_name: Array.isArray(event.classNames) ? event.classNames.join(' ') : event.classNames || '',
            start: event.startStr,
            end: event.endStr || null,
            all_day: event.allDay ? 1 : 0,
            location: event.extendedProps?.location || '',
            reminder_minutes: event.extendedProps?.reminder_minutes || null,
            description: event.extendedProps?.description || '',
            documents: (event.extendedProps?.documents || []).map(function (doc) { return doc.id; }),
            csrf_token: this.config.csrfToken
        };
        const response = await fetch(this.config.storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            if (showModalOnError) {
                alert(result.message || 'No pudimos actualizar el evento.');
            }
            throw new Error(result.message || 'Error al actualizar el evento');
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const calendarElement = document.getElementById('calendar');
    if (calendarElement) {
        new CalendarSchedule().init();
    }
});
