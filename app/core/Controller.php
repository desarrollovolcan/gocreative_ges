<?php

class Controller
{
    protected array $config;
    protected Database $db;

    public function __construct(array $config, Database $db)
    {
        $this->config = $config;
        $this->db = $db;
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $config = $this->config;
        $currentUser = Auth::user();
        try {
            $notifications = $this->db->fetchAll("SELECT * FROM notifications WHERE read_at IS NULL ORDER BY created_at DESC LIMIT 5");
        } catch (PDOException $e) {
            log_message('error', 'Failed to load notifications: ' . $e->getMessage());
            $notifications = [];
        }
        $notificationCount = count($notifications);
        include __DIR__ . '/../views/layouts/main.php';
    }

    protected function renderPublic(string $view, array $data = []): void
    {
        extract($data);
        $config = $this->config;
        include __DIR__ . '/../views/layouts/portal.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requireLogin(): void
    {
        if (!Auth::check()) {
            $this->redirect('login.php');
        }
    }

    protected function requireRole(string $role): void
    {
        $user = Auth::user();
        if (!$user || $user['role'] !== $role) {
            $this->redirect('index.php?route=dashboard');
        }
    }
}
