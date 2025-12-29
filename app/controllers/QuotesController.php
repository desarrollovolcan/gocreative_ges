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
