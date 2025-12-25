<?php

class ServicesController extends Controller
{
    private ServicesModel $services;
    private ClientsModel $clients;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->services = new ServicesModel($db);
        $this->clients = new ClientsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $services = $this->services->active();
        $this->render('services/index', [
            'title' => 'Servicios',
            'pageTitle' => 'Servicios',
            'services' => $services,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $clients = $this->clients->active();
        $this->render('services/create', [
            'title' => 'Nuevo Servicio',
            'pageTitle' => 'Nuevo Servicio',
            'clients' => $clients,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $startDate = trim($_POST['start_date'] ?? '');
        $dueDate = trim($_POST['due_date'] ?? '');
        $deleteDate = trim($_POST['delete_date'] ?? '');
        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'service_type' => $_POST['service_type'] ?? 'dominio',
            'name' => trim($_POST['name'] ?? ''),
            'cost' => (float)($_POST['cost'] ?? 0),
            'currency' => $_POST['currency'] ?? 'CLP',
            'billing_cycle' => $_POST['billing_cycle'] ?? 'anual',
            'start_date' => $startDate !== '' ? $startDate : null,
            'due_date' => $dueDate !== '' ? $dueDate : null,
            'delete_date' => $deleteDate !== '' ? $deleteDate : null,
            'notice_days_1' => (int)($_POST['notice_days_1'] ?? 15),
            'notice_days_2' => (int)($_POST['notice_days_2'] ?? 5),
            'status' => $_POST['status'] ?? 'activo',
            'auto_invoice' => isset($_POST['auto_invoice']) ? 1 : 0,
            'auto_email' => isset($_POST['auto_email']) ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->services->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'services');
        $this->redirect('index.php?route=services');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $service = $this->services->find($id);
        if (!$service) {
            $this->redirect('index.php?route=services');
        }
        $clients = $this->clients->active();
        $this->render('services/edit', [
            'title' => 'Editar Servicio',
            'pageTitle' => 'Editar Servicio',
            'service' => $service,
            'clients' => $clients,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $startDate = trim($_POST['start_date'] ?? '');
        $dueDate = trim($_POST['due_date'] ?? '');
        $deleteDate = trim($_POST['delete_date'] ?? '');
        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'service_type' => $_POST['service_type'] ?? 'dominio',
            'name' => trim($_POST['name'] ?? ''),
            'cost' => (float)($_POST['cost'] ?? 0),
            'currency' => $_POST['currency'] ?? 'CLP',
            'billing_cycle' => $_POST['billing_cycle'] ?? 'anual',
            'start_date' => $startDate !== '' ? $startDate : null,
            'due_date' => $dueDate !== '' ? $dueDate : null,
            'delete_date' => $deleteDate !== '' ? $deleteDate : null,
            'notice_days_1' => (int)($_POST['notice_days_1'] ?? 15),
            'notice_days_2' => (int)($_POST['notice_days_2'] ?? 5),
            'status' => $_POST['status'] ?? 'activo',
            'auto_invoice' => isset($_POST['auto_invoice']) ? 1 : 0,
            'auto_email' => isset($_POST['auto_email']) ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->services->update($id, $data);
        audit($this->db, Auth::user()['id'], 'update', 'services', $id);
        $this->redirect('index.php?route=services');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $service = $this->services->find($id);
        if (!$service) {
            $this->redirect('index.php?route=services');
        }
        $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $service['client_id']]);
        $invoices = $this->db->fetchAll('SELECT * FROM invoices WHERE service_id = :id ORDER BY id DESC', ['id' => $id]);
        $this->render('services/show', [
            'title' => 'Detalle Servicio',
            'pageTitle' => 'Detalle Servicio',
            'service' => $service,
            'client' => $client,
            'invoices' => $invoices,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->services->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'services', $id);
        $this->redirect('index.php?route=services');
    }

    public function generateInvoice(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $service = $this->services->find($id);
        if (!$service) {
            $this->redirect('index.php?route=services');
        }

        $settings = new SettingsModel($this->db);
        $prefix = $settings->get('invoice_prefix', 'FAC-');
        $invoicesModel = new InvoicesModel($this->db);
        $number = $invoicesModel->nextNumber($prefix);

        $invoiceId = $invoicesModel->create([
            'client_id' => $service['client_id'],
            'service_id' => $service['id'],
            'numero' => $number,
            'fecha_emision' => date('Y-m-d'),
            'fecha_vencimiento' => $service['due_date'] ?? date('Y-m-d'),
            'estado' => 'pendiente',
            'subtotal' => $service['cost'],
            'impuestos' => 0,
            'total' => $service['cost'],
            'notas' => 'Factura generada desde servicio',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $itemsModel = new InvoiceItemsModel($this->db);
        $itemsModel->create([
            'invoice_id' => $invoiceId,
            'descripcion' => $service['name'],
            'cantidad' => 1,
            'precio_unitario' => $service['cost'],
            'total' => $service['cost'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }
}
