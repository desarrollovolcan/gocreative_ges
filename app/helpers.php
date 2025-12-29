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

function log_message(string $level, string $message): void
{
    $logFile = __DIR__ . '/../storage/logs/app.log';
    $entry = sprintf("[%s] %s: %s\n", date('Y-m-d H:i:s'), strtoupper($level), $message);
    file_put_contents($logFile, $entry, FILE_APPEND);
}

function audit(Database $db, int $userId, string $action, string $entity, ?int $entityId = null): void
{
    $db->execute(
        'INSERT INTO audit_logs (user_id, action, entity, entity_id, created_at) VALUES (:user_id, :action, :entity, :entity_id, NOW())',
        [
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
        'services' => [
            'label' => 'Servicios',
            'routes' => ['services'],
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
        'users' => [
            'label' => 'Usuarios',
            'routes' => ['users'],
        ],
        'users_permissions' => [
            'label' => 'Permisos de usuarios',
            'routes' => ['users/permissions'],
        ],
    ];
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
