<?php

class ClientsController extends Controller
{
    private ClientsModel $clients;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->clients = new ClientsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $clients = $this->clients->active();
        $this->render('clients/index', [
            'title' => 'Clientes',
            'pageTitle' => 'Clientes',
            'clients' => $clients,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('clients/create', [
            'title' => 'Nuevo Cliente',
            'pageTitle' => 'Nuevo Cliente',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if (!Validator::required($name) || !Validator::email($email)) {
            $_SESSION['error'] = 'Completa los campos obligatorios.';
            $this->redirect('index.php?route=clients/create');
        }

        $data = [
            'name' => $name,
            'rut' => trim($_POST['rut'] ?? ''),
            'email' => $email,
            'billing_email' => trim($_POST['billing_email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'contact' => trim($_POST['contact'] ?? ''),
            'mandante_name' => trim($_POST['mandante_name'] ?? ''),
            'mandante_rut' => trim($_POST['mandante_rut'] ?? ''),
            'mandante_phone' => trim($_POST['mandante_phone'] ?? ''),
            'mandante_email' => trim($_POST['mandante_email'] ?? ''),
            'notes' => trim($_POST['notes'] ?? ''),
            'status' => $_POST['status'] ?? 'activo',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->clients->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'clients');
        $this->redirect('index.php?route=clients');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $client = $this->clients->find($id);
        if (!$client) {
            $this->redirect('index.php?route=clients');
        }
        $this->render('clients/edit', [
            'title' => 'Editar Cliente',
            'pageTitle' => 'Editar Cliente',
            'client' => $client,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if (!Validator::required($name) || !Validator::email($email)) {
            $_SESSION['error'] = 'Completa los campos obligatorios.';
            $this->redirect('index.php?route=clients/edit&id=' . $id);
        }

        $data = [
            'name' => $name,
            'rut' => trim($_POST['rut'] ?? ''),
            'email' => $email,
            'billing_email' => trim($_POST['billing_email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'contact' => trim($_POST['contact'] ?? ''),
            'mandante_name' => trim($_POST['mandante_name'] ?? ''),
            'mandante_rut' => trim($_POST['mandante_rut'] ?? ''),
            'mandante_phone' => trim($_POST['mandante_phone'] ?? ''),
            'mandante_email' => trim($_POST['mandante_email'] ?? ''),
            'notes' => trim($_POST['notes'] ?? ''),
            'status' => $_POST['status'] ?? 'activo',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->clients->update($id, $data);
        audit($this->db, Auth::user()['id'], 'update', 'clients', $id);
        $this->redirect('index.php?route=clients');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $client = $this->clients->find($id);
        if (!$client) {
            $this->redirect('index.php?route=clients');
        }
        $services = $this->db->fetchAll('SELECT * FROM services WHERE client_id = :id AND deleted_at IS NULL', ['id' => $id]);
        $projects = $this->db->fetchAll('SELECT * FROM projects WHERE client_id = :id AND deleted_at IS NULL', ['id' => $id]);
        $invoices = $this->db->fetchAll('SELECT * FROM invoices WHERE client_id = :id AND deleted_at IS NULL', ['id' => $id]);
        $emails = $this->db->fetchAll('SELECT * FROM email_logs WHERE client_id = :id ORDER BY created_at DESC', ['id' => $id]);
        $payments = $this->db->fetchAll('SELECT payments.* FROM payments JOIN invoices ON payments.invoice_id = invoices.id WHERE invoices.client_id = :id', ['id' => $id]);

        $this->render('clients/show', [
            'title' => 'Detalle Cliente',
            'pageTitle' => 'Detalle Cliente',
            'client' => $client,
            'services' => $services,
            'projects' => $projects,
            'invoices' => $invoices,
            'emails' => $emails,
            'payments' => $payments,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->clients->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'clients', $id);
        $this->redirect('index.php?route=clients');
    }
}
