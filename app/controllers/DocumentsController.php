<?php

class DocumentsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para ver documentos.');
            $this->redirect('index.php?route=dashboard');
        }
        $documents = $this->listDocuments((int)$companyId);
        $this->render('documents/index', [
            'title' => 'Documentos',
            'pageTitle' => 'Documentos',
            'documents' => $documents,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para cargar documentos.');
            $this->redirect('index.php?route=dashboard');
        }
        $files = $this->normalizeFiles($_FILES['documents'] ?? $_FILES['document'] ?? null);
        if (empty($files)) {
            flash('error', 'Selecciona uno o más archivos para subir.');
            $this->redirect('index.php?route=documents');
        }
        $directory = $this->documentsDirectory((int)$companyId);
        $directoryError = ensure_upload_directory($directory);
        if ($directoryError !== null) {
            flash('error', $directoryError);
            $this->redirect('index.php?route=documents');
        }
        $uploaded = 0;
        $errors = [];
        foreach ($files as $file) {
            if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                $errors[] = 'No pudimos cargar uno de los archivos.';
                continue;
            }
            if (($file['size'] ?? 0) > 10 * 1024 * 1024) {
                $errors[] = 'Uno de los archivos supera el tamaño máximo de 10MB.';
                continue;
            }
            $originalName = basename((string)($file['name'] ?? 'documento'));
            $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
            $uniquePrefix = date('YmdHis') . '-' . bin2hex(random_bytes(4));
            $storedName = $uniquePrefix . '__' . $safeName;
            $destination = $directory . '/' . $storedName;
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                $errors[] = 'No pudimos guardar uno de los archivos en el servidor.';
                continue;
            }
            $mime = $this->guessMime($destination);
            $size = filesize($destination) ?: 0;
            $this->db->execute(
                'INSERT INTO documents (company_id, filename, original_name, mime_type, file_size, created_at, updated_at)
                 VALUES (:company_id, :filename, :original_name, :mime_type, :file_size, NOW(), NOW())',
                [
                    'company_id' => (int)$companyId,
                    'filename' => $storedName,
                    'original_name' => $originalName,
                    'mime_type' => $mime,
                    'file_size' => $size,
                ]
            );
            $uploaded++;
        }
        if ($uploaded > 0) {
            flash('success', 'Documentos cargados correctamente.');
        }
        if (!empty($errors)) {
            flash('warning', implode(' ', array_unique($errors)));
        }
        if ($uploaded === 0) {
            flash('error', 'No pudimos cargar los documentos.');
        }
        $this->redirect('index.php?route=documents');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para eliminar documentos.');
            $this->redirect('index.php?route=dashboard');
        }
        $documentId = (int)($_POST['id'] ?? 0);
        if ($documentId <= 0) {
            flash('error', 'Documento no encontrado.');
            $this->redirect('index.php?route=documents');
        }
        $document = $this->db->fetch(
            'SELECT id, filename FROM documents WHERE id = :id AND company_id = :company_id',
            ['id' => $documentId, 'company_id' => (int)$companyId]
        );
        if (!$document) {
            flash('error', 'Documento no encontrado.');
            $this->redirect('index.php?route=documents');
        }
        $directory = $this->documentsDirectory((int)$companyId);
        $target = $this->safeDocumentPath($directory, (string)$document['filename']);
        if ($target !== null && is_file($target) && !unlink($target)) {
            flash('error', 'No pudimos eliminar el documento.');
            $this->redirect('index.php?route=documents');
        }
        $this->db->execute(
            'DELETE FROM documents WHERE id = :id AND company_id = :company_id',
            ['id' => $documentId, 'company_id' => (int)$companyId]
        );
        flash('success', 'Documento eliminado.');
        $this->redirect('index.php?route=documents');
    }

    public function download(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            http_response_code(403);
            echo 'Empresa no válida';
            return;
        }
        $documentId = (int)($_GET['id'] ?? 0);
        if ($documentId <= 0) {
            http_response_code(404);
            echo 'Documento no encontrado';
            return;
        }
        $document = $this->db->fetch(
            'SELECT filename, original_name FROM documents WHERE id = :id AND company_id = :company_id',
            ['id' => $documentId, 'company_id' => (int)$companyId]
        );
        if (!$document) {
            http_response_code(404);
            echo 'Documento no encontrado';
            return;
        }
        $directory = $this->documentsDirectory((int)$companyId);
        $target = $this->safeDocumentPath($directory, (string)$document['filename']);
        if ($target === null || !is_file($target)) {
            http_response_code(404);
            echo 'Documento no encontrado';
            return;
        }
        $displayName = $document['original_name'] ?: $this->displayName((string)$document['filename']);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $displayName . '"');
        header('Content-Length: ' . filesize($target));
        readfile($target);
        exit;
    }

    private function documentsDirectory(int $companyId): string
    {
        return dirname(__DIR__) . '/../storage/uploads/documents/' . $companyId;
    }

    private function listDocuments(int $companyId): array
    {
        $rows = $this->db->fetchAll(
            'SELECT id, filename, original_name, mime_type, file_size, updated_at
             FROM documents WHERE company_id = :company_id ORDER BY id DESC',
            ['company_id' => $companyId]
        );
        $documents = [];
        foreach ($rows as $row) {
            $filename = (string)$row['filename'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $documents[] = [
                'id' => (int)$row['id'],
                'filename' => $filename,
                'name' => $row['original_name'] ?: $this->displayName($filename),
                'extension' => $extension !== '' ? strtoupper($extension) : 'Archivo',
                'size' => (int)($row['file_size'] ?? 0),
                'updated_at' => $row['updated_at']
                    ? date('d/m/Y', strtotime((string)$row['updated_at']))
                    : date('d/m/Y'),
                'download_url' => 'index.php?route=documents/download&id=' . urlencode((string)$row['id']),
            ];
        }
        return $documents;
    }

    private function safeDocumentPath(string $directory, string $filename): ?string
    {
        $safe = basename($filename);
        if ($safe === '') {
            return null;
        }
        $path = $directory . '/' . $safe;
        $realDirectory = realpath($directory);
        $realPath = realpath($path);
        if ($realDirectory === false || $realPath === false) {
            return null;
        }
        if (!str_starts_with($realPath, $realDirectory)) {
            return null;
        }
        return $realPath;
    }

    private function displayName(string $filename): string
    {
        $parts = explode('__', $filename, 2);
        return $parts[1] ?? $filename;
    }

    private function guessMime(string $path): string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            return 'application/octet-stream';
        }
        $mime = finfo_file($finfo, $path) ?: 'application/octet-stream';
        finfo_close($finfo);
        return $mime;
    }

    private function normalizeFiles(?array $files): array
    {
        if ($files === null || empty($files['name'])) {
            return [];
        }
        if (is_array($files['name'])) {
            $normalized = [];
            $count = count($files['name']);
            for ($index = 0; $index < $count; $index++) {
                if (($files['error'][$index] ?? UPLOAD_ERR_OK) === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $normalized[] = [
                    'name' => $files['name'][$index] ?? '',
                    'type' => $files['type'][$index] ?? '',
                    'tmp_name' => $files['tmp_name'][$index] ?? '',
                    'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$index] ?? 0,
                ];
            }
            return $normalized;
        }
        if (($files['error'] ?? UPLOAD_ERR_OK) === UPLOAD_ERR_NO_FILE) {
            return [];
        }
        return [$files];
    }
}
