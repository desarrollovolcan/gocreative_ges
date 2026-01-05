<?php

class CalendarController extends Controller
{
    private const ALLOWED_TYPES = ['reminder', 'meeting', 'task'];
    private const ALLOWED_CLASSNAMES = [
        'bg-primary-subtle text-primary',
        'bg-secondary-subtle text-secondary',
        'bg-success-subtle text-success',
        'bg-info-subtle text-info',
        'bg-warning-subtle text-warning',
        'bg-danger-subtle text-danger',
        'bg-dark-subtle text-dark',
    ];

    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para usar el calendario.');
            $this->redirect('index.php?route=dashboard');
        }
        $calendarModel = new CalendarModel($this->db);
        $documents = $calendarModel->listDocuments((int)$companyId);

        $this->render('calendar/index', [
            'title' => 'Calendario',
            'pageTitle' => 'Calendario',
            'documents' => $documents,
        ]);
    }

    public function events(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $companyId = current_company_id();
        if (!$companyId) {
            echo json_encode([], JSON_UNESCAPED_UNICODE);
            return;
        }
        $start = $_GET['start'] ?? null;
        $end = $_GET['end'] ?? null;
        $calendarModel = new CalendarModel($this->db);
        $events = $calendarModel->listEvents((int)$companyId, $start, $end);
        echo json_encode($events, JSON_UNESCAPED_UNICODE);
    }

    public function store(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $companyId = current_company_id();
        if (!$companyId) {
            http_response_code(403);
            echo json_encode(['message' => 'Empresa no válida.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        $data = $this->requestData();
        $this->verifyToken($data['csrf_token'] ?? null);

        $title = trim((string)($data['title'] ?? ''));
        $eventType = (string)($data['type'] ?? 'meeting');
        $className = (string)($data['class_name'] ?? '');
        $location = trim((string)($data['location'] ?? ''));
        $description = trim((string)($data['description'] ?? ''));
        $allDay = !empty($data['all_day']);
        $reminderMinutes = isset($data['reminder_minutes']) && $data['reminder_minutes'] !== ''
            ? (int)$data['reminder_minutes']
            : null;

        $start = $this->parseDateTime($data['start'] ?? null);
        $end = $this->parseDateTime($data['end'] ?? null);
        if ($title === '' || !$start) {
            http_response_code(422);
            echo json_encode(['message' => 'Completa el título y la fecha de inicio.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        if (!in_array($eventType, self::ALLOWED_TYPES, true)) {
            $eventType = 'meeting';
        }
        if (!in_array($className, self::ALLOWED_CLASSNAMES, true)) {
            $className = self::ALLOWED_CLASSNAMES[0];
        }
        if ($end && $end < $start) {
            http_response_code(422);
            echo json_encode(['message' => 'La fecha de término no puede ser anterior a la fecha de inicio.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        if ($reminderMinutes !== null && $reminderMinutes < 0) {
            $reminderMinutes = null;
        }

        $user = Auth::user();
        $userId = (int)($user['id'] ?? 0);
        if ($userId <= 0) {
            http_response_code(403);
            echo json_encode(['message' => 'Usuario no válido.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        $eventId = (int)($data['id'] ?? 0);
        if ($eventId > 0) {
            $existing = $this->db->fetch(
                'SELECT id FROM calendar_events WHERE id = :id AND company_id = :company_id',
                ['id' => $eventId, 'company_id' => (int)$companyId]
            );
            if (!$existing) {
                http_response_code(404);
                echo json_encode(['message' => 'Evento no encontrado.'], JSON_UNESCAPED_UNICODE);
                return;
            }
            $this->db->execute(
                'UPDATE calendar_events
                 SET title = :title,
                     description = :description,
                     event_type = :event_type,
                     location = :location,
                     start_at = :start_at,
                     end_at = :end_at,
                     all_day = :all_day,
                     reminder_minutes = :reminder_minutes,
                     class_name = :class_name,
                     updated_at = NOW()
                 WHERE id = :id AND company_id = :company_id',
                [
                    'title' => $title,
                    'description' => $description !== '' ? $description : null,
                    'event_type' => $eventType,
                    'location' => $location !== '' ? $location : null,
                    'start_at' => $start->format('Y-m-d H:i:s'),
                    'end_at' => $end ? $end->format('Y-m-d H:i:s') : null,
                    'all_day' => $allDay ? 1 : 0,
                    'reminder_minutes' => $reminderMinutes,
                    'class_name' => $className,
                    'id' => $eventId,
                    'company_id' => (int)$companyId,
                ]
            );
        } else {
            $this->db->execute(
                'INSERT INTO calendar_events
                    (company_id, created_by_user_id, title, description, event_type, location, start_at, end_at, all_day, reminder_minutes, class_name, created_at, updated_at)
                 VALUES
                    (:company_id, :created_by, :title, :description, :event_type, :location, :start_at, :end_at, :all_day, :reminder_minutes, :class_name, NOW(), NOW())',
                [
                    'company_id' => (int)$companyId,
                    'created_by' => $userId,
                    'title' => $title,
                    'description' => $description !== '' ? $description : null,
                    'event_type' => $eventType,
                    'location' => $location !== '' ? $location : null,
                    'start_at' => $start->format('Y-m-d H:i:s'),
                    'end_at' => $end ? $end->format('Y-m-d H:i:s') : null,
                    'all_day' => $allDay ? 1 : 0,
                    'reminder_minutes' => $reminderMinutes,
                    'class_name' => $className,
                ]
            );
            $eventId = (int)$this->db->lastInsertId();
        }

        $documentIds = $this->sanitizeDocumentIds($data['documents'] ?? []);
        $this->syncEventDocuments($eventId, (int)$companyId, $documentIds);

        echo json_encode(['success' => true, 'id' => $eventId], JSON_UNESCAPED_UNICODE);
    }

    public function delete(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $companyId = current_company_id();
        if (!$companyId) {
            http_response_code(403);
            echo json_encode(['message' => 'Empresa no válida.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        $data = $this->requestData();
        $this->verifyToken($data['csrf_token'] ?? null);

        $eventId = (int)($data['id'] ?? 0);
        if ($eventId <= 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Evento no encontrado.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        $existing = $this->db->fetch(
            'SELECT id FROM calendar_events WHERE id = :id AND company_id = :company_id',
            ['id' => $eventId, 'company_id' => (int)$companyId]
        );
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['message' => 'Evento no encontrado.'], JSON_UNESCAPED_UNICODE);
            return;
        }
        $this->db->execute('DELETE FROM calendar_events WHERE id = :id AND company_id = :company_id', [
            'id' => $eventId,
            'company_id' => (int)$companyId,
        ]);
        echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
    }

    private function requestData(): array
    {
        if (!empty($_POST)) {
            return $_POST;
        }
        $raw = file_get_contents('php://input');
        if (!$raw) {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function verifyToken(?string $token): void
    {
        if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            echo json_encode(['message' => 'CSRF token inválido.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    private function parseDateTime(?string $value): ?DateTime
    {
        if (!$value) {
            return null;
        }
        try {
            return new DateTime($value);
        } catch (Throwable $e) {
            return null;
        }
    }

    private function sanitizeDocumentIds(array|string $documentIds): array
    {
        $ids = is_array($documentIds) ? $documentIds : [$documentIds];
        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, static fn(int $id) => $id > 0);
        $ids = array_values(array_unique($ids));
        return $ids;
    }

    private function syncEventDocuments(int $eventId, int $companyId, array $documentIds): void
    {
        $this->db->execute('DELETE FROM calendar_event_documents WHERE event_id = :event_id', [
            'event_id' => $eventId,
        ]);
        if (empty($documentIds)) {
            return;
        }
        $placeholders = [];
        $params = ['company_id' => $companyId];
        foreach ($documentIds as $index => $documentId) {
            $key = 'doc' . $index;
            $placeholders[] = ':' . $key;
            $params[$key] = $documentId;
        }
        $rows = $this->db->fetchAll(
            'SELECT id FROM documents WHERE company_id = :company_id AND deleted_at IS NULL AND id IN (' . implode(',', $placeholders) . ')',
            $params
        );
        foreach ($rows as $row) {
            $this->db->execute(
                'INSERT INTO calendar_event_documents (event_id, document_id, created_at)
                 VALUES (:event_id, :document_id, NOW())',
                [
                    'event_id' => $eventId,
                    'document_id' => (int)$row['id'],
                ]
            );
        }
    }
}
