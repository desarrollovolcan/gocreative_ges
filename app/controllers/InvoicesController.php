<?php

class InvoicesController extends Controller
{
    private InvoicesModel $invoices;
    private ClientsModel $clients;
    private ServicesModel $services;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->invoices = new InvoicesModel($db);
        $this->clients = new ClientsModel($db);
        $this->services = new ServicesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $invoices = $this->invoices->allWithClient();
        $this->render('invoices/index', [
            'title' => 'Facturas',
            'pageTitle' => 'Facturas',
            'invoices' => $invoices,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $clients = $this->clients->active();
        $services = $this->services->active();
        $projects = $this->db->fetchAll('SELECT projects.*, clients.name as client_name FROM projects JOIN clients ON projects.client_id = clients.id WHERE projects.deleted_at IS NULL ORDER BY projects.id DESC');
        $settings = new SettingsModel($this->db);
        $prefix = $settings->get('invoice_prefix', 'FAC-');
        $number = $this->invoices->nextNumber($prefix);
        $this->render('invoices/create', [
            'title' => 'Nueva Factura',
            'pageTitle' => 'Nueva Factura',
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

        $invoiceId = $this->invoices->create([
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'service_id' => $_POST['service_id'] ?: null,
            'project_id' => $_POST['project_id'] ?: null,
            'numero' => trim($_POST['numero'] ?? ''),
            'fecha_emision' => $_POST['fecha_emision'] ?? date('Y-m-d'),
            'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? date('Y-m-d'),
            'estado' => $_POST['estado'] ?? 'pendiente',
            'subtotal' => $_POST['subtotal'] ?? 0,
            'impuestos' => $_POST['impuestos'] ?? 0,
            'total' => $_POST['total'] ?? 0,
            'notas' => trim($_POST['notas'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $items = $_POST['items'] ?? [];
        $itemsModel = new InvoiceItemsModel($this->db);
        foreach ($items as $item) {
            if (empty($item['descripcion'])) {
                continue;
            }
            $itemsModel->create([
                'invoice_id' => $invoiceId,
                'descripcion' => $item['descripcion'],
                'cantidad' => $item['cantidad'] ?? 1,
                'precio_unitario' => $item['precio_unitario'] ?? 0,
                'total' => $item['total'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        audit($this->db, Auth::user()['id'], 'create', 'invoices', $invoiceId);
        $this->redirect('index.php?route=invoices');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $invoice = $this->invoices->find($id);
        if (!$invoice) {
            $this->redirect('index.php?route=invoices');
        }
        $itemsModel = new InvoiceItemsModel($this->db);
        $paymentsModel = new PaymentsModel($this->db);
        $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $invoice['client_id']]);
        $items = $itemsModel->byInvoice($id);
        $payments = $paymentsModel->byInvoice($id);
        $this->render('invoices/show', [
            'title' => 'Detalle Factura',
            'pageTitle' => 'Detalle Factura',
            'invoice' => $invoice,
            'client' => $client,
            'items' => $items,
            'payments' => $payments,
        ]);
    }

    public function pay(): void
    {
        $this->requireLogin();
        verify_csrf();
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $paymentsModel = new PaymentsModel($this->db);
        $paymentsModel->create([
            'invoice_id' => $invoiceId,
            'monto' => $_POST['monto'] ?? 0,
            'fecha_pago' => $_POST['fecha_pago'] ?? date('Y-m-d'),
            'metodo' => $_POST['metodo'] ?? 'transferencia',
            'referencia' => trim($_POST['referencia'] ?? ''),
            'comprobante' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->invoices->update($invoiceId, [
            'estado' => 'pagada',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
            'title' => 'Pago registrado',
            'message' => 'Se registró un pago para la factura #' . $invoiceId,
            'type' => 'success',
        ]);
        audit($this->db, Auth::user()['id'], 'pay', 'invoices', $invoiceId);
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->invoices->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'invoices', $id);
        $this->redirect('index.php?route=invoices');
    }

    public function export(): void
    {
        $this->requireLogin();
        $invoices = $this->invoices->allWithClient();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="facturas.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Numero', 'Cliente', 'Emision', 'Vencimiento', 'Estado', 'Total']);
        foreach ($invoices as $invoice) {
            fputcsv($output, [
                $invoice['numero'],
                $invoice['client_name'],
                $invoice['fecha_emision'],
                $invoice['fecha_vencimiento'],
                $invoice['estado'],
                $invoice['total'],
            ]);
        }
        fclose($output);
        exit;
    }
}
