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
}
