<?php

class EmailConfigController extends Controller
{
    private SettingsModel $settings;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->settings = new SettingsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $smtpConfig = $this->settings->get('smtp_info', []);
        if (!is_array($smtpConfig)) {
            $smtpConfig = [];
        }
        $defaults = [
            'host' => 'mail.gocreative.cl',
            'port' => 465,
            'security' => 'ssl',
            'username' => 'informevolcan@gocreative.cl',
            'password' => '#(3-QiWGI;l}oJW_',
            'from_name' => 'Información',
            'from_email' => 'informevolcan@gocreative.cl',
            'reply_to' => 'informevolcan@gocreative.cl',
        ];
        $smtpConfig = array_merge($defaults, $smtpConfig);
        $this->render('maintainers/email-config', [
            'title' => 'Configuración de correo',
            'pageTitle' => 'Configuración de correo',
            'smtpConfig' => $smtpConfig,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $this->settings->set('smtp_info', [
            'host' => trim($_POST['host'] ?? ''),
            'port' => (int)($_POST['port'] ?? 587),
            'security' => trim($_POST['security'] ?? 'tls'),
            'username' => trim($_POST['username'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'from_name' => trim($_POST['from_name'] ?? ''),
            'from_email' => trim($_POST['from_email'] ?? ''),
            'reply_to' => trim($_POST['reply_to'] ?? ''),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'smtp_info');
        $this->redirect('index.php?route=maintainers/email-config');
    }
}
