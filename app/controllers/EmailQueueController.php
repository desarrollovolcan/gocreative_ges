<?php

class EmailQueueController extends Controller
{
    private EmailQueueModel $queue;
    private EmailTemplatesModel $templates;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->queue = new EmailQueueModel($db);
        $this->templates = new EmailTemplatesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $emails = $this->db->fetchAll('SELECT email_queue.*, clients.name as client_name FROM email_queue LEFT JOIN clients ON email_queue.client_id = clients.id ORDER BY email_queue.id DESC');
        $this->render('email_queue/index', [
            'title' => 'Cola de Correos',
            'pageTitle' => 'Cola de Correos',
            'emails' => $emails,
        ]);
    }

    public function compose(): void
    {
        $this->requireLogin();
        $templates = $this->templates->all('deleted_at IS NULL');
        $clients = $this->db->fetchAll('SELECT * FROM clients WHERE deleted_at IS NULL ORDER BY name');
        $this->render('email_queue/compose', [
            'title' => 'Nuevo Correo',
            'pageTitle' => 'Nuevo Correo',
            'templates' => $templates,
            'clients' => $clients,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $this->queue->create([
            'client_id' => $_POST['client_id'] ?: null,
            'template_id' => $_POST['template_id'] ?: null,
            'subject' => trim($_POST['subject'] ?? ''),
            'body_html' => $_POST['body_html'] ?? '',
            'type' => $_POST['type'] ?? 'cobranza',
            'status' => $_POST['status'] ?? 'pending',
            'scheduled_at' => $_POST['scheduled_at'] ?? date('Y-m-d H:i:s'),
            'tries' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'email_queue');
        $this->redirect('index.php?route=email-queue');
    }

    public function sendNow(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $email = $this->db->fetch('SELECT * FROM email_queue WHERE id = :id', ['id' => $id]);
        if (!$email) {
            $this->redirect('index.php?route=email-queue');
        }

        if ($email['status'] === 'sent') {
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Correo enviado',
                'message' => 'El correo ya fue enviado previamente.',
                'type' => 'info',
            ]);
            $this->redirect('index.php?route=email-queue');
        }

        $client = null;
        if (!empty($email['client_id'])) {
            $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $email['client_id']]);
        }
        $to = $client['billing_email'] ?? $client['email'] ?? null;
        if (!$to) {
            $this->db->execute('UPDATE email_queue SET status = "failed", tries = tries + 1, last_error = "Sin email" WHERE id = :id', ['id' => $email['id']]);
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Correo fallido',
                'message' => 'No hay email asociado al cliente para enviar.',
                'type' => 'danger',
            ]);
            $this->redirect('index.php?route=email-queue');
        }

        $mailer = new Mailer($this->db);
        $sent = $mailer->send($email['type'], $to, $email['subject'], $email['body_html']);

        if ($sent) {
            $this->db->execute('UPDATE email_queue SET status = "sent", updated_at = NOW() WHERE id = :id', ['id' => $email['id']]);
            $this->db->execute('INSERT INTO email_logs (client_id, type, subject, body_html, status, created_at, updated_at) VALUES (:client_id, :type, :subject, :body_html, :status, NOW(), NOW())', [
                'client_id' => $email['client_id'],
                'type' => $email['type'],
                'subject' => $email['subject'],
                'body_html' => $email['body_html'],
                'status' => 'sent',
            ]);
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Correo enviado',
                'message' => 'El correo se envió correctamente.',
                'type' => 'success',
            ]);
        } else {
            $this->db->execute('UPDATE email_queue SET status = "failed", tries = tries + 1, last_error = "Error envío" WHERE id = :id', ['id' => $email['id']]);
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Correo fallido',
                'message' => 'No se pudo enviar el correo.',
                'type' => 'danger',
            ]);
        }

        $this->redirect('index.php?route=email-queue');
    }
}
