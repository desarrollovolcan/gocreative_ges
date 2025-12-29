<?php

class QuotesController extends Controller
{
    private QuotesModel $quotes;
    private ClientsModel $clients;
    private SystemServicesModel $services;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->quotes = new QuotesModel($db);
        $this->clients = new ClientsModel($db);
        $this->services = new SystemServicesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $quotes = $this->quotes->allWithClient();
        $this->render('quotes/index', [
            'title' => 'Cotizaciones',
            'pageTitle' => 'Cotizaciones',
            'quotes' => $quotes,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $clients = $this->clients->active();
        try {
            $services = $this->services->popularHostingAndDomain(10);
        } catch (PDOException $e) {
            log_message('error', 'Failed to load system services for quotes: ' . $e->getMessage());
            $services = [];
        }
        $projects = $this->db->fetchAll('SELECT projects.*, clients.name as client_name FROM projects JOIN clients ON projects.client_id = clients.id WHERE projects.deleted_at IS NULL ORDER BY projects.id DESC');
        $number = $this->quotes->nextNumber('COT-');
        $this->render('quotes/create', [
            'title' => 'Nueva Cotización',
            'pageTitle' => 'Nueva Cotización',
            'clients' => $clients,
            'services' => $services,
            'projects' => $projects,
            'number' => $number,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $serviceId = trim($_POST['system_service_id'] ?? '');
        $projectId = trim($_POST['project_id'] ?? '');
        $issueDate = trim($_POST['fecha_emision'] ?? '');
        $subtotal = trim($_POST['subtotal'] ?? '');
        $impuestos = trim($_POST['impuestos'] ?? '');
        $total = trim($_POST['total'] ?? '');

        $quoteId = $this->quotes->create([
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'system_service_id' => $serviceId !== '' ? $serviceId : null,
            'project_id' => $projectId !== '' ? $projectId : null,
            'numero' => trim($_POST['numero'] ?? ''),
            'fecha_emision' => $issueDate !== '' ? $issueDate : date('Y-m-d'),
            'estado' => $_POST['estado'] ?? 'pendiente',
            'subtotal' => $subtotal !== '' ? $subtotal : 0,
            'impuestos' => $impuestos !== '' ? $impuestos : 0,
            'total' => $total !== '' ? $total : 0,
            'notas' => trim($_POST['notas'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $items = $_POST['items'] ?? [];
        $itemsModel = new QuoteItemsModel($this->db);
        foreach ($items as $item) {
            if (empty($item['descripcion'])) {
                continue;
            }
            $itemsModel->create([
                'quote_id' => $quoteId,
                'descripcion' => $item['descripcion'],
                'cantidad' => $item['cantidad'] ?? 1,
                'precio_unitario' => $item['precio_unitario'] ?? 0,
                'total' => $item['total'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        audit($this->db, Auth::user()['id'], 'create', 'quotes', $quoteId);
        $this->redirect('index.php?route=quotes');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $quote = $this->quotes->find($id);
        if (!$quote) {
            $this->redirect('index.php?route=quotes');
        }
        $items = (new QuoteItemsModel($this->db))->byQuote($id);
        $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $quote['client_id']]);
        $this->render('quotes/show', [
            'title' => 'Detalle Cotización',
            'pageTitle' => 'Detalle Cotización',
            'quote' => $quote,
            'client' => $client,
            'items' => $items,
        ]);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $quote = $this->quotes->find($id);
        if (!$quote) {
            $this->redirect('index.php?route=quotes');
        }
        $items = (new QuoteItemsModel($this->db))->byQuote($id);
        $clients = $this->clients->active();
        try {
            $services = $this->services->popularHostingAndDomain(10);
        } catch (PDOException $e) {
            log_message('error', 'Failed to load system services for quotes edit: ' . $e->getMessage());
            $services = [];
        }
        $projects = $this->db->fetchAll('SELECT projects.*, clients.name as client_name FROM projects JOIN clients ON projects.client_id = clients.id WHERE projects.deleted_at IS NULL ORDER BY projects.id DESC');
        $this->render('quotes/edit', [
            'title' => 'Editar Cotización',
            'pageTitle' => 'Editar Cotización',
            'quote' => $quote,
            'items' => $items,
            'clients' => $clients,
            'services' => $services,
            'projects' => $projects,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $quote = $this->quotes->find($id);
        if (!$quote) {
            $this->redirect('index.php?route=quotes');
        }
        $serviceId = trim($_POST['system_service_id'] ?? '');
        $projectId = trim($_POST['project_id'] ?? '');
        $issueDate = trim($_POST['fecha_emision'] ?? '');
        $subtotal = trim($_POST['subtotal'] ?? '');
        $impuestos = trim($_POST['impuestos'] ?? '');
        $total = trim($_POST['total'] ?? '');

        $this->quotes->update($id, [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'system_service_id' => $serviceId !== '' ? $serviceId : null,
            'project_id' => $projectId !== '' ? $projectId : null,
            'numero' => trim($_POST['numero'] ?? ''),
            'fecha_emision' => $issueDate !== '' ? $issueDate : $quote['fecha_emision'],
            'estado' => $_POST['estado'] ?? 'pendiente',
            'subtotal' => $subtotal !== '' ? $subtotal : 0,
            'impuestos' => $impuestos !== '' ? $impuestos : 0,
            'total' => $total !== '' ? $total : 0,
            'notas' => trim($_POST['notas'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->execute('DELETE FROM quote_items WHERE quote_id = :quote_id', ['quote_id' => $id]);
        $items = $_POST['items'] ?? [];
        $itemsModel = new QuoteItemsModel($this->db);
        foreach ($items as $item) {
            if (empty($item['descripcion'])) {
                continue;
            }
            $itemsModel->create([
                'quote_id' => $id,
                'descripcion' => $item['descripcion'],
                'cantidad' => $item['cantidad'] ?? 1,
                'precio_unitario' => $item['precio_unitario'] ?? 0,
                'total' => $item['total'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        audit($this->db, Auth::user()['id'], 'update', 'quotes', $id);
        $this->redirect('index.php?route=quotes/show&id=' . $id);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM quote_items WHERE quote_id = :quote_id', ['quote_id' => $id]);
        $this->db->execute('DELETE FROM quotes WHERE id = :id', ['id' => $id]);
        audit($this->db, Auth::user()['id'], 'delete', 'quotes', $id);
        $this->redirect('index.php?route=quotes');
    }

    public function send(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $quote = $this->quotes->find($id);
        if (!$quote) {
            $this->redirect('index.php?route=quotes');
        }
        $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $quote['client_id']]);
        $recipient = $client['email'] ?? '';
        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Cotización no enviada',
                'message' => 'El cliente no tiene un correo válido.',
                'type' => 'danger',
            ]);
            $this->redirect('index.php?route=quotes');
        }
        $baseUrl = rtrim($this->config['app']['base_url'] ?? '', '/');
        if ($baseUrl === '') {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $baseUrl = $scheme . '://' . $host;
        }
        $printUrl = $baseUrl . '/index.php?route=quotes/print&id=' . $id;
        $subject = 'Cotización ' . ($quote['numero'] ?? '');
        $body = '<p>Adjuntamos la cotización solicitada.</p>'
            . '<p><a href="' . e($printUrl) . '">Ver cotización</a></p>';
        $sent = (new Mailer($this->db))->send('info', $recipient, $subject, $body);
        $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
            'title' => $sent ? 'Cotización enviada' : 'Cotización no enviada',
            'message' => $sent ? 'La cotización fue enviada correctamente.' : 'No se pudo enviar la cotización.',
            'type' => $sent ? 'success' : 'danger',
        ]);
        $this->redirect('index.php?route=quotes');
    }

    public function print(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $quote = $this->quotes->find($id);
        if (!$quote) {
            $this->redirect('index.php?route=quotes');
        }
        $items = (new QuoteItemsModel($this->db))->byQuote($id);
        $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $quote['client_id']]);
        $company = (new SettingsModel($this->db))->get('company', []);
        $viewPath = __DIR__ . '/../views/quotes/print.php';
        if (file_exists($viewPath)) {
            include $viewPath;
            return;
        }
        echo 'Vista no encontrada.';
    }
}
