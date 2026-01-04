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
        $documents = $this->listDocuments($companyId);
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
        $file = $_FILES['document'] ?? null;
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            flash('error', 'Selecciona un archivo para subir.');
            $this->redirect('index.php?route=documents');
        }
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            flash('error', 'No pudimos cargar el archivo, intenta nuevamente.');
            $this->redirect('index.php?route=documents');
        }
        if (($file['size'] ?? 0) > 10 * 1024 * 1024) {
            flash('error', 'El archivo supera el tamaño máximo de 10MB.');
            $this->redirect('index.php?route=documents');
        }
        $directory = $this->documentsDirectory((int)$companyId);
        $directoryError = ensure_upload_directory($directory);
        if ($directoryError !== null) {
            flash('error', $directoryError);
            $this->redirect('index.php?route=documents');
        }
        $originalName = basename((string)($file['name'] ?? 'documento'));
        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $uniquePrefix = date('YmdHis') . '-' . bin2hex(random_bytes(4));
        $storedName = $uniquePrefix . '__' . $safeName;
        $destination = $directory . '/' . $storedName;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            flash('error', 'No pudimos guardar el archivo en el servidor.');
            $this->redirect('index.php?route=documents');
        }
        flash('success', 'Documento cargado correctamente.');
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
        $filename = trim($_POST['file'] ?? '');
        if ($filename === '') {
            flash('error', 'Documento no encontrado.');
            $this->redirect('index.php?route=documents');
        }
        $directory = $this->documentsDirectory((int)$companyId);
        $target = $this->safeDocumentPath($directory, $filename);
        if ($target === null || !is_file($target)) {
            flash('error', 'Documento no encontrado.');
            $this->redirect('index.php?route=documents');
        }
        if (!unlink($target)) {
            flash('error', 'No pudimos eliminar el documento.');
            $this->redirect('index.php?route=documents');
        }
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
        $filename = trim($_GET['file'] ?? '');
        if ($filename === '') {
            http_response_code(404);
            echo 'Documento no encontrado';
            return;
        }
        $directory = $this->documentsDirectory((int)$companyId);
        $target = $this->safeDocumentPath($directory, $filename);
        if ($target === null || !is_file($target)) {
            http_response_code(404);
            echo 'Documento no encontrado';
            return;
        }
        $displayName = $this->displayName($filename);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $displayName . '"');
        header('Content-Length: ' . filesize($target));
        readfile($target);
        exit;
    }

    private function documentsDirectory(int $companyId): string
    {
        return __DIR__ . '/../storage/uploads/documents/' . $companyId;
    }

    private function listDocuments(int $companyId): array
    {
        $directory = $this->documentsDirectory($companyId);
        if (!is_dir($directory)) {
            return [];
        }
        $files = glob($directory . '/*') ?: [];
        $documents = [];
        foreach ($files as $path) {
            if (!is_file($path)) {
                continue;
            }
            $filename = basename($path);
            $displayName = $this->displayName($filename);
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $documents[] = [
                'filename' => $filename,
                'name' => $displayName,
                'extension' => $extension !== '' ? strtoupper($extension) : 'Archivo',
                'size' => filesize($path) ?: 0,
                'updated_at' => date('d/m/Y', filemtime($path) ?: time()),
                'download_url' => 'index.php?route=documents/download&file=' . urlencode($filename),
            ];
        }
        usort($documents, static fn(array $a, array $b): int => strcmp($b['filename'], $a['filename']));
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
}
