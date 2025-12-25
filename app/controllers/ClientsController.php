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

        $portalToken = bin2hex(random_bytes(16));
        $portalPassword = trim($_POST['portal_password'] ?? '');
        if ($portalPassword === '') {
            $_SESSION['error'] = 'Define una contraseña para el acceso del cliente.';
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
            'portal_token' => $portalToken,
            'portal_password' => password_hash($portalPassword, PASSWORD_DEFAULT),
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
            'portalUrl' => $this->buildPortalUrl($client),
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

        $portalToken = trim($_POST['portal_token'] ?? '');
        if (!empty($_POST['regenerate_portal_token']) || $portalToken === '') {
            $portalToken = bin2hex(random_bytes(16));
        }
        $portalPassword = trim($_POST['portal_password'] ?? '');
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
            'portal_token' => $portalToken,
            'notes' => trim($_POST['notes'] ?? ''),
            'status' => $_POST['status'] ?? 'activo',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($portalPassword !== '') {
            $data['portal_password'] = password_hash($portalPassword, PASSWORD_DEFAULT);
        }
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
            'portalUrl' => $this->buildPortalUrl($client),
        ]);
    }

    public function portalLogin(): void
    {
        $error = null;
        $email = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $email = trim($_POST['email'] ?? '');
            $accessCode = trim($_POST['access_code'] ?? '');
            $password = trim($_POST['password'] ?? '');
            if (!Validator::email($email) || $accessCode === '' || $password === '') {
                $error = 'Completa los datos solicitados.';
            } else {
                $client = $this->db->fetch(
                    'SELECT * FROM clients WHERE email = :email AND portal_token = :token AND deleted_at IS NULL',
                    [
                        'email' => $email,
                        'token' => $accessCode,
                    ]
                );
                if (!$client || empty($client['portal_password']) || !password_verify($password, $client['portal_password'])) {
                    $error = 'Las credenciales no son válidas.';
                } else {
                    $this->redirect('index.php?route=clients/portal&token=' . urlencode($client['portal_token']));
                }
            }
        }

        $this->renderPublic('clients/login', [
            'title' => 'Acceso Intranet Cliente',
            'pageTitle' => 'Acceso Portal Cliente',
            'error' => $error,
            'email' => $email,
            'showAdminAccess' => true,
            'hidePortalHeader' => true,
        ]);
    }

    public function portal(): void
    {
        $token = trim($_GET['token'] ?? '');
        if ($token === '') {
            $this->renderPublic('clients/portal', [
                'title' => 'Portal Cliente',
                'pageTitle' => 'Portal Cliente',
                'error' => 'Token inválido.',
            ]);
            return;
        }

        $client = $this->db->fetch('SELECT * FROM clients WHERE portal_token = :token AND deleted_at IS NULL', ['token' => $token]);
        if (!$client) {
            $this->renderPublic('clients/portal', [
                'title' => 'Portal Cliente',
                'pageTitle' => 'Portal Cliente',
                'error' => 'No encontramos un cliente asociado a este token.',
            ]);
            return;
        }

        $activities = $this->db->fetchAll(
            'SELECT project_tasks.*, projects.name as project_name
             FROM project_tasks
             JOIN projects ON project_tasks.project_id = projects.id
             WHERE projects.client_id = :id AND projects.deleted_at IS NULL
             ORDER BY project_tasks.created_at DESC',
            ['id' => $client['id']]
        );
        $payments = $this->db->fetchAll(
            'SELECT payments.*, invoices.numero as invoice_number, invoices.estado as invoice_status, invoices.total as invoice_total
             FROM payments
             JOIN invoices ON payments.invoice_id = invoices.id
             WHERE invoices.client_id = :id
             ORDER BY payments.fecha_pago DESC',
            ['id' => $client['id']]
        );
        $pendingInvoices = $this->db->fetchAll(
            'SELECT * FROM invoices WHERE client_id = :id AND estado != "pagado" AND deleted_at IS NULL ORDER BY fecha_vencimiento ASC',
            ['id' => $client['id']]
        );
        $pendingTotal = array_sum(array_map(static fn(array $invoice) => (float)$invoice['total'], $pendingInvoices));
        $paidTotal = array_sum(array_map(static fn(array $payment) => (float)$payment['monto'], $payments));

        $this->renderPublic('clients/portal', [
            'title' => 'Portal Cliente',
            'pageTitle' => 'Portal Cliente',
            'client' => $client,
            'activities' => $activities,
            'payments' => $payments,
            'pendingInvoices' => $pendingInvoices,
            'pendingTotal' => $pendingTotal,
            'paidTotal' => $paidTotal,
        ]);
    }

    private function buildPortalUrl(array $client): string
    {
        $baseUrl = rtrim($this->config['app']['base_url'] ?? '', '/');
        $token = $client['portal_token'] ?? '';
        if ($token === '') {
            return '';
        }
        $path = 'index.php?route=clients/login';
        return $baseUrl !== '' ? $baseUrl . '/' . $path : $path;
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
