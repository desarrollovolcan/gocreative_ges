<?php

class SettingsController extends Controller
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
        $company = $this->settings->get('company', []);
        $billing = $this->settings->get('billing_defaults', []);
        $invoiceDefaults = $this->settings->get('invoice_defaults', []);
        $this->render('settings/index', [
            'title' => 'Configuración',
            'pageTitle' => 'Configuración',
            'company' => $company,
            'billing' => $billing,
            'invoiceDefaults' => $invoiceDefaults,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $section = $_POST['section'] ?? '';
        if ($section === 'company') {
            $this->settings->set('company', [
                'name' => trim($_POST['name'] ?? ''),
                'rut' => trim($_POST['rut'] ?? ''),
                'bank' => trim($_POST['bank'] ?? ''),
                'account_type' => trim($_POST['account_type'] ?? ''),
                'account_number' => trim($_POST['account_number'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'signature' => trim($_POST['signature'] ?? ''),
            ]);
        }

        if ($section === 'billing') {
            $this->settings->set('billing_defaults', [
                'notice_days_1' => (int)($_POST['notice_days_1'] ?? 15),
                'notice_days_2' => (int)($_POST['notice_days_2'] ?? 5),
                'send_time' => trim($_POST['send_time'] ?? '09:00'),
                'timezone' => trim($_POST['timezone'] ?? 'America/Santiago'),
                'invoice_prefix' => trim($_POST['invoice_prefix'] ?? 'FAC-'),
            ]);
            $this->settings->set('invoice_prefix', trim($_POST['invoice_prefix'] ?? 'FAC-'));
        }

        if ($section === 'invoice') {
            $this->settings->set('invoice_defaults', [
                'currency' => trim($_POST['currency'] ?? 'CLP'),
                'tax_rate' => (float)($_POST['tax_rate'] ?? 0),
                'apply_tax' => !empty($_POST['apply_tax']),
            ]);
        }

        audit($this->db, Auth::user()['id'], 'update', 'settings');
        $this->redirect('index.php?route=settings');
    }

    public function testSmtp(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $to = Auth::user()['email'] ?? '';
        if ($to === '') {
            $company = $this->settings->get('company', []);
            $to = $company['email'] ?? '';
        }
        if ($to === '') {
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Prueba SMTP',
                'message' => 'No se encontró correo para enviar la prueba.',
                'type' => 'danger',
            ]);
            $this->redirect('index.php?route=settings');
        }

        $mailer = new Mailer($this->db);
        $sent = $mailer->send('info', $to, 'Prueba SMTP', '<p>Correo de prueba exitoso.</p>');

        $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
            'title' => 'Prueba SMTP',
            'message' => $sent ? 'Correo enviado correctamente.' : 'Fallo el envío.',
            'type' => $sent ? 'success' : 'danger',
        ]);

        $this->redirect('index.php?route=settings');
    }
}
