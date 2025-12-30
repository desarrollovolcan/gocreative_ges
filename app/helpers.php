<?php

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        exit('CSRF token inválido.');
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function app_config(?string $key = null, mixed $default = null): mixed
{
    static $config = null;

    if ($config === null) {
        if (isset($GLOBALS['config']) && is_array($GLOBALS['config'])) {
            $config = $GLOBALS['config'];
        } else {
            $config = require __DIR__ . '/config/config.php';
        }
    }

    if ($key === null) {
        return $config;
    }

    $value = $config;
    foreach (explode('.', $key) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function currency_format_settings(): array
{
    return app_config('currency_format', [
        'thousands_separator' => '.',
        'decimal_separator' => ',',
        'decimals' => 0,
        'symbol' => '$',
    ]);
}

function format_currency(float $amount, ?int $decimals = null): string
{
    $settings = currency_format_settings();
    $precision = $decimals ?? (int)($settings['decimals'] ?? 0);
    $decimalSeparator = (string)($settings['decimal_separator'] ?? ',');
    $thousandsSeparator = (string)($settings['thousands_separator'] ?? '.');
    $symbol = (string)($settings['symbol'] ?? '$');

    return $symbol . number_format($amount, $precision, $decimalSeparator, $thousandsSeparator);
}

function log_message(string $level, string $message): void
{
    $logFile = __DIR__ . '/../storage/logs/app.log';
    $entry = sprintf("[%s] %s: %s\n", date('Y-m-d H:i:s'), strtoupper($level), $message);
    file_put_contents($logFile, $entry, FILE_APPEND);
}

function current_company_id(): ?int
{
    $companyId = null;
    if (class_exists('Auth')) {
        $user = Auth::user();
        if (!empty($user['company_id'])) {
            $companyId = (int)$user['company_id'];
        }
    }
    if (!$companyId && !empty($_SESSION['client_company_id'])) {
        $companyId = (int)$_SESSION['client_company_id'];
    }

    return $companyId ?: null;
}

function user_company_ids(Database $db, ?array $user): array
{
    if (!$user) {
        return [];
    }
    $companyIds = [];
    if (!empty($user['company_id'])) {
        $companyIds[] = (int)$user['company_id'];
    }
    $rows = $db->fetchAll(
        'SELECT company_id FROM user_companies WHERE user_id = :user_id',
        ['user_id' => (int)($user['id'] ?? 0)]
    );
    foreach ($rows as $row) {
        $companyIds[] = (int)$row['company_id'];
    }
    $companyIds = array_values(array_unique(array_filter($companyIds)));
    sort($companyIds);
    return $companyIds;
}

function ensure_upload_directory(string $directory): ?string
{
    if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
        return 'No pudimos crear la carpeta de cargas en el servidor.';
    }

    if (!is_writable($directory)) {
        @chmod($directory, 0775);
    }

    if (!is_writable($directory)) {
        return 'No hay permisos de escritura para guardar archivos en el servidor.';
    }

    return null;
}

function upload_avatar(?array $file, string $prefix): array
{
    if ($file === null || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['path' => null, 'error' => null];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['path' => null, 'error' => 'No pudimos cargar la imagen, intenta nuevamente.'];
    }

    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        return ['path' => null, 'error' => 'La imagen supera el tamaño máximo de 2MB.'];
    }

    $info = getimagesize($file['tmp_name'] ?? '');
    if ($info === false || empty($info['mime'])) {
        return ['path' => null, 'error' => 'El archivo seleccionado no es una imagen válida.'];
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    $extension = $allowed[$info['mime']] ?? null;
    if ($extension === null) {
        return ['path' => null, 'error' => 'Solo se permiten imágenes JPG, PNG o WEBP.'];
    }

    $directory = __DIR__ . '/../storage/uploads/avatars';
    $directoryError = ensure_upload_directory($directory);
    if ($directoryError !== null) {
        return ['path' => null, 'error' => $directoryError];
    }

    $filename = sprintf('%s-%s.%s', $prefix, bin2hex(random_bytes(8)), $extension);
    $destination = $directory . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['path' => null, 'error' => 'No pudimos guardar la imagen en el servidor.'];
    }

    return ['path' => 'storage/uploads/avatars/' . $filename, 'error' => null];
}

function upload_company_logo(?array $file, string $prefix): array
{
    if ($file === null || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['path' => null, 'error' => null];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['path' => null, 'error' => 'No pudimos cargar la imagen, intenta nuevamente.'];
    }

    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        return ['path' => null, 'error' => 'La imagen supera el tamaño máximo de 2MB.'];
    }

    $info = getimagesize($file['tmp_name'] ?? '');
    if ($info === false || empty($info['mime'])) {
        return ['path' => null, 'error' => 'El archivo seleccionado no es una imagen válida.'];
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    $extension = $allowed[$info['mime']] ?? null;
    if ($extension === null) {
        return ['path' => null, 'error' => 'Solo se permiten imágenes JPG, PNG o WEBP.'];
    }

    $directory = __DIR__ . '/../storage/uploads/logos';
    $directoryError = ensure_upload_directory($directory);
    if ($directoryError !== null) {
        return ['path' => null, 'error' => $directoryError];
    }

    $filename = sprintf('%s-%s.%s', $prefix, bin2hex(random_bytes(8)), $extension);
    $destination = $directory . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['path' => null, 'error' => 'No pudimos guardar la imagen en el servidor.'];
    }

    return ['path' => 'storage/uploads/logos/' . $filename, 'error' => null];
}

function audit(Database $db, int $userId, string $action, string $entity, ?int $entityId = null): void
{
    $companyId = current_company_id();
    $db->execute(
        'INSERT INTO audit_logs (company_id, user_id, action, entity, entity_id, created_at) VALUES (:company_id, :user_id, :action, :entity, :entity_id, NOW())',
        [
            'company_id' => $companyId,
            'user_id' => $userId,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
        ]
    );
}

function render_template_vars(string $html, array $context = []): string
{
    $defaults = [
        'cliente_nombre' => $context['cliente_nombre'] ?? '',
        'rut' => $context['rut'] ?? '',
        'monto_total' => $context['monto_total'] ?? '',
        'fecha_vencimiento' => $context['fecha_vencimiento'] ?? '',
        'servicio_nombre' => $context['servicio_nombre'] ?? '',
        'dominio' => $context['dominio'] ?? '',
        'hosting' => $context['hosting'] ?? '',
        'fecha_eliminacion' => $context['fecha_eliminacion'] ?? '',
        'link_pago' => $context['link_pago'] ?? '',
        'numero_factura' => $context['numero_factura'] ?? '',
        'monto_pagado' => $context['monto_pagado'] ?? '',
        'saldo_pendiente' => $context['saldo_pendiente'] ?? '',
        'fecha_pago' => $context['fecha_pago'] ?? '',
        'metodo_pago' => $context['metodo_pago'] ?? '',
        'referencia_pago' => $context['referencia_pago'] ?? '',
    ];

    foreach ($defaults as $key => $value) {
        $html = str_replace('{{' . $key . '}}', (string)$value, $html);
    }

    return $html;
}

function permission_catalog(): array
{
    return [
        'dashboard' => [
            'label' => 'Dashboard',
            'routes' => ['dashboard'],
        ],
        'clients' => [
            'label' => 'Clientes',
            'routes' => ['clients'],
        ],
        'projects' => [
            'label' => 'Proyectos',
            'routes' => ['projects'],
        ],
        'crm' => [
            'label' => 'CRM Comercial',
            'routes' => ['crm'],
        ],
        'services' => [
            'label' => 'Servicios',
            'routes' => ['services'],
        ],
        'quotes' => [
            'label' => 'Cotizaciones',
            'routes' => ['quotes'],
        ],
        'invoices' => [
            'label' => 'Facturas',
            'routes' => ['invoices'],
        ],
        'email_templates' => [
            'label' => 'Plantillas Email',
            'routes' => ['email-templates'],
        ],
        'email_queue' => [
            'label' => 'Cola de Correos',
            'routes' => ['email-queue'],
        ],
        'settings' => [
            'label' => 'Configuración',
            'routes' => ['settings'],
        ],
        'maintainers' => [
            'label' => 'Mantenedores',
            'routes' => ['maintainers'],
        ],
        'companies' => [
            'label' => 'Empresas',
            'routes' => ['companies'],
        ],
        'users' => [
            'label' => 'Usuarios',
            'routes' => ['users'],
        ],
        'users_companies' => [
            'label' => 'Usuarios por empresa',
            'routes' => ['users/assign-company'],
        ],
        'company_switch' => [
            'label' => 'Cambio de empresa',
            'routes' => ['auth/switch-company'],
        ],
        'users_permissions' => [
            'label' => 'Permisos de usuarios',
            'routes' => ['users/permissions'],
        ],
        'tickets' => [
            'label' => 'Tickets de soporte',
            'routes' => ['tickets'],
        ],
    ];
}

function flash(string $type, string $message): void
{
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    if (!isset($_SESSION['flash'][$type])) {
        $_SESSION['flash'][$type] = [];
    }
    $_SESSION['flash'][$type][] = $message;
}

function consume_flash(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function permission_key_for_route(string $route): ?string
{
    $catalog = permission_catalog();
    foreach ($catalog as $key => $data) {
        foreach ($data['routes'] as $prefix) {
            if ($route === $prefix || str_starts_with($route, $prefix . '/')) {
                return $key;
            }
        }
    }
    return null;
}

function role_permissions(Database $db, int $roleId): array
{
    static $cache = [];
    if (isset($cache[$roleId])) {
        return $cache[$roleId];
    }
    $rows = $db->fetchAll('SELECT permission_key FROM role_permissions WHERE role_id = :role_id', [
        'role_id' => $roleId,
    ]);
    $permissions = array_map(static fn(array $row) => $row['permission_key'], $rows);
    $cache[$roleId] = $permissions;
    return $permissions;
}

function can_access_route(Database $db, string $route, ?array $user): bool
{
    if (!$user) {
        return false;
    }
    if (($user['role'] ?? '') === 'admin') {
        return true;
    }
    $key = permission_key_for_route($route);
    if ($key === null) {
        return true;
    }
    $roleId = (int)($user['role_id'] ?? 0);
    if ($roleId === 0 && !empty($user['role'])) {
        $roleRow = $db->fetch('SELECT id FROM roles WHERE name = :name', ['name' => $user['role']]);
        $roleId = (int)($roleRow['id'] ?? 0);
    }
    if ($roleId === 0) {
        return false;
    }
    $permissions = role_permissions($db, $roleId);
    return in_array($key, $permissions, true);
}
