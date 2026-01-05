<?php

class CalendarModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function listEvents(int $companyId, ?string $start, ?string $end): array
    {
        $conditions = ['company_id = :company_id'];
        $params = ['company_id' => $companyId];
        $startFilter = $this->normalizeDateTime($start);
        $endFilter = $this->normalizeDateTime($end);
        if ($startFilter && $endFilter) {
            $conditions[] = '(start_at <= :end_at AND (end_at IS NULL OR end_at >= :start_at))';
            $params['start_at'] = $startFilter;
            $params['end_at'] = $endFilter;
        }

        $rows = $this->db->fetchAll(
            'SELECT id, title, description, event_type, location, start_at, end_at, all_day, reminder_minutes, class_name
             FROM calendar_events
             WHERE ' . implode(' AND ', $conditions) . '
             ORDER BY start_at ASC',
            $params
        );
        $eventIds = array_map(static fn(array $row) => (int)$row['id'], $rows);
        $documentsByEvent = $this->documentsForEvents($eventIds);
        $events = [];

        foreach ($rows as $row) {
            $allDay = (bool)($row['all_day'] ?? false);
            $startAt = $this->formatEventDate($row['start_at'] ?? null, $allDay);
            $endAt = $this->formatEventDate($this->normalizeAllDayEnd($row['start_at'] ?? null, $row['end_at'] ?? null, $allDay), $allDay);
            $events[] = [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'start' => $startAt,
                'end' => $endAt,
                'allDay' => $allDay,
                'className' => $row['class_name'] ?: null,
                'extendedProps' => [
                    'type' => $row['event_type'],
                    'location' => $row['location'],
                    'description' => $row['description'],
                    'reminder_minutes' => $row['reminder_minutes'] !== null ? (int)$row['reminder_minutes'] : null,
                    'documents' => $documentsByEvent[(int)$row['id']] ?? [],
                ],
            ];
        }

        return $events;
    }

    public function listDocuments(int $companyId): array
    {
        $rows = $this->db->fetchAll(
            'SELECT id, filename, original_name, mime_type, file_size
             FROM documents
             WHERE company_id = :company_id AND deleted_at IS NULL
             ORDER BY id DESC',
            ['company_id' => $companyId]
        );
        $documents = [];
        foreach ($rows as $row) {
            $filename = (string)$row['filename'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $documents[] = [
                'id' => (int)$row['id'],
                'name' => $row['original_name'] ?: $this->displayName($filename),
                'extension' => $extension !== '' ? strtoupper($extension) : 'Archivo',
                'mime_type' => $row['mime_type'] ?? '',
                'size' => (int)($row['file_size'] ?? 0),
                'download_url' => 'index.php?route=documents/download&id=' . (int)$row['id'],
            ];
        }
        return $documents;
    }

    private function documentsForEvents(array $eventIds): array
    {
        $eventIds = array_values(array_filter(array_unique($eventIds), static fn(int $id) => $id > 0));
        if (empty($eventIds)) {
            return [];
        }
        $placeholders = [];
        $params = [];
        foreach ($eventIds as $index => $eventId) {
            $key = 'event' . $index;
            $placeholders[] = ':' . $key;
            $params[$key] = $eventId;
        }
        $rows = $this->db->fetchAll(
            'SELECT ced.event_id, d.id, d.filename, d.original_name
             FROM calendar_event_documents ced
             INNER JOIN documents d ON d.id = ced.document_id AND d.deleted_at IS NULL
             WHERE ced.event_id IN (' . implode(',', $placeholders) . ')',
            $params
        );
        $documentsByEvent = [];
        foreach ($rows as $row) {
            $filename = (string)$row['filename'];
            $documentsByEvent[(int)$row['event_id']][] = [
                'id' => (int)$row['id'],
                'name' => $row['original_name'] ?: $this->displayName($filename),
                'download_url' => 'index.php?route=documents/download&id=' . (int)$row['id'],
            ];
        }
        return $documentsByEvent;
    }

    private function normalizeDateTime(?string $value): ?string
    {
        if (!$value) {
            return null;
        }
        try {
            $date = new DateTime($value);
            return $date->format('Y-m-d H:i:s');
        } catch (Throwable $e) {
            return null;
        }
    }

    private function formatEventDate(?string $value, bool $allDay): ?string
    {
        if (!$value) {
            return null;
        }
        try {
            $date = new DateTime($value);
        } catch (Throwable $e) {
            return null;
        }
        return $allDay ? $date->format('Y-m-d') : $date->format('Y-m-d\TH:i');
    }

    private function normalizeAllDayEnd(?string $startAt, ?string $endAt, bool $allDay): ?string
    {
        if (!$allDay || !$startAt) {
            return $endAt;
        }
        if (!$endAt) {
            return null;
        }
        try {
            $start = new DateTime($startAt);
            $end = new DateTime($endAt);
        } catch (Throwable $e) {
            return $endAt;
        }
        if ($end <= $start) {
            $end = (clone $start)->modify('+1 day');
        }
        return $end->format('Y-m-d H:i:s');
    }

    private function displayName(string $filename): string
    {
        $parts = explode('__', $filename, 2);
        $name = $parts[1] ?? $filename;
        return str_replace('_', ' ', $name);
    }
}
