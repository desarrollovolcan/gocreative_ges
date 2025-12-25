<?php

class EmailTemplatesController extends Controller
{
    private EmailTemplatesModel $templates;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->templates = new EmailTemplatesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $templates = $this->templates->all('deleted_at IS NULL');
        $this->render('email_templates/index', [
            'title' => 'Plantillas de Email',
            'pageTitle' => 'Plantillas de Email',
            'templates' => $templates,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $this->render('email_templates/create', [
            'title' => 'Nueva Plantilla',
            'pageTitle' => 'Nueva Plantilla',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $this->templates->create([
            'name' => trim($_POST['name'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'body_html' => $_POST['body_html'] ?? '',
            'type' => $_POST['type'] ?? 'cobranza',
            'created_by' => Auth::user()['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'email_templates');
        $this->redirect('index.php?route=email-templates');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $id = (int)($_GET['id'] ?? 0);
        $template = $this->templates->find($id);
        if (!$template) {
            $this->redirect('index.php?route=email-templates');
        }
        $clients = $this->db->fetchAll('SELECT id, name, rut, email, billing_email FROM clients WHERE deleted_at IS NULL ORDER BY name');
        $this->render('email_templates/edit', [
            'title' => 'Editar Plantilla',
            'pageTitle' => 'Editar Plantilla',
            'template' => $template,
            'clients' => $clients,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->templates->update($id, [
            'name' => trim($_POST['name'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'body_html' => $_POST['body_html'] ?? '',
            'type' => $_POST['type'] ?? 'cobranza',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'email_templates', $id);
        $this->redirect('index.php?route=email-templates');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->templates->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'email_templates', $id);
        $this->redirect('index.php?route=email-templates');
    }

    public function preview(): void
    {
        $this->requireLogin();
        $templateId = (int)($_GET['template_id'] ?? 0);
        $clientId = (int)($_GET['client_id'] ?? 0);
        $template = $this->templates->find($templateId);
        $client = $clientId ? $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $clientId]) : null;

        if (!$template) {
            $this->redirect('index.php?route=email-templates');
        }

        $body = render_template_vars($template['body_html'], [
            'cliente_nombre' => $client['name'] ?? '',
            'rut' => $client['rut'] ?? '',
            'monto_total' => $client['balance'] ?? '',
            'fecha_vencimiento' => date('Y-m-d'),
            'servicio_nombre' => '',
        ]);

        $this->render('email_templates/preview', [
            'title' => 'Vista previa',
            'pageTitle' => 'Vista previa',
            'template' => $template,
            'client' => $client,
            'body' => $body,
        ]);
    }
}
