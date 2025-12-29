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
        $selectedClientId = (int)($_GET['client_id'] ?? 0);
        $selectedProjectId = (int)($_GET['project_id'] ?? 0);
        $this->render('invoices/create', [
            'title' => 'Nueva Factura',
            'pageTitle' => 'Nueva Factura',
            'clients' => $clients,
            'services' => $services,
            'projects' => $projects,
            'number' => $number,
            'selectedClientId' => $selectedClientId,
            'selectedProjectId' => $selectedProjectId,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $serviceId = trim($_POST['service_id'] ?? '');
        $projectId = trim($_POST['project_id'] ?? '');
        $issueDate = trim($_POST['fecha_emision'] ?? '');
        $dueDate = trim($_POST['fecha_vencimiento'] ?? '');
        $subtotal = trim($_POST['subtotal'] ?? '');
        $impuestos = trim($_POST['impuestos'] ?? '');
        $total = trim($_POST['total'] ?? '');

        $invoiceId = $this->invoices->create([
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'service_id' => $serviceId !== '' ? $serviceId : null,
            'project_id' => $projectId !== '' ? $projectId : null,
            'numero' => trim($_POST['numero'] ?? ''),
            'fecha_emision' => $issueDate !== '' ? $issueDate : date('Y-m-d'),
            'fecha_vencimiento' => $dueDate !== '' ? $dueDate : date('Y-m-d'),
            'estado' => $_POST['estado'] ?? 'pendiente',
            'subtotal' => $subtotal !== '' ? $subtotal : 0,
            'impuestos' => $impuestos !== '' ? $impuestos : 0,
            'total' => $total !== '' ? $total : 0,
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
        $paidTotal = array_sum(array_map(static fn(array $payment) => (float)$payment['monto'], $payments));
        $pendingTotal = max(0, (float)$invoice['total'] - $paidTotal);
        $this->render('invoices/show', [
            'title' => 'Detalle Factura',
            'pageTitle' => 'Detalle Factura',
            'invoice' => $invoice,
            'client' => $client,
            'items' => $items,
            'payments' => $payments,
            'paidTotal' => $paidTotal,
            'pendingTotal' => $pendingTotal,
        ]);
    }

    public function pay(): void
    {
        $this->requireLogin();
        verify_csrf();
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $paymentDate = trim($_POST['fecha_pago'] ?? '');
        $amount = trim($_POST['monto'] ?? '');
        $paymentsModel = new PaymentsModel($this->db);
        $paymentId = $paymentsModel->create([
            'invoice_id' => $invoiceId,
            'monto' => $amount !== '' ? $amount : 0,
            'fecha_pago' => $paymentDate !== '' ? $paymentDate : date('Y-m-d'),
            'metodo' => $_POST['metodo'] ?? 'transferencia',
            'referencia' => trim($_POST['referencia'] ?? ''),
            'comprobante' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->syncInvoiceBalance($invoiceId);
        $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
            'title' => 'Pago registrado',
            'message' => 'Se registró un pago para la factura #' . $invoiceId,
            'type' => 'success',
        ]);
        $this->sendPaymentReceiptEmail($paymentId, true);
        audit($this->db, Auth::user()['id'], 'pay', 'invoices', $invoiceId);
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function updatePayment(): void
    {
        $this->requireLogin();
        verify_csrf();
        $paymentId = (int)($_POST['payment_id'] ?? 0);
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $payment = (new PaymentsModel($this->db))->find($paymentId);
        if (!$payment) {
            $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
        }
        (new PaymentsModel($this->db))->update($paymentId, [
            'monto' => trim($_POST['monto'] ?? $payment['monto']),
            'fecha_pago' => trim($_POST['fecha_pago'] ?? $payment['fecha_pago']),
            'metodo' => $_POST['metodo'] ?? $payment['metodo'],
            'referencia' => trim($_POST['referencia'] ?? $payment['referencia']),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->syncInvoiceBalance($invoiceId);
        audit($this->db, Auth::user()['id'], 'update', 'payments', $paymentId);
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function deletePayment(): void
    {
        $this->requireLogin();
        verify_csrf();
        $paymentId = (int)($_POST['payment_id'] ?? 0);
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $payment = (new PaymentsModel($this->db))->find($paymentId);
        if ($payment) {
            $this->db->execute('DELETE FROM payments WHERE id = :id', ['id' => $paymentId]);
            $this->syncInvoiceBalance($invoiceId);
            audit($this->db, Auth::user()['id'], 'delete', 'payments', $paymentId);
        }
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function sendPaymentReceipt(): void
    {
        $this->requireLogin();
        verify_csrf();
        $paymentId = (int)($_POST['payment_id'] ?? 0);
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $sent = $this->sendPaymentReceiptEmail($paymentId, false);
        if ($sent) {
            $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                'title' => 'Comprobante enviado',
                'message' => 'El comprobante de pago fue enviado correctamente.',
                'type' => 'success',
            ]);
        }
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    private function syncInvoiceBalance(int $invoiceId): void
    {
        $paymentsModel = new PaymentsModel($this->db);
        $payments = $paymentsModel->byInvoice($invoiceId);
        $paidTotal = array_sum(array_map(static fn(array $payment) => (float)$payment['monto'], $payments));
        $invoice = $this->invoices->find($invoiceId);
        if (!$invoice) {
            return;
        }
        $total = (float)$invoice['total'];
        $status = $paidTotal >= $total && $total > 0 ? 'pagada' : 'pendiente';
        $this->invoices->update($invoiceId, [
            'estado' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    private function sendPaymentReceiptEmail(int $paymentId, bool $silent): bool
    {
        $payment = $this->db->fetch('SELECT * FROM payments WHERE id = :id', ['id' => $paymentId]);
        if (!$payment) {
            return false;
        }
        $invoice = $this->invoices->find((int)$payment['invoice_id']);
        if (!$invoice) {
            return false;
        }
        $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $invoice['client_id']]);
        if (!$client) {
            return false;
        }

        $recipients = array_filter([
            $client['email'] ?? null,
            $client['billing_email'] ?? null,
        ], fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
        if (empty($recipients)) {
            if (!$silent) {
                $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                    'title' => 'Correo no enviado',
                    'message' => 'No hay email asociado al cliente para enviar el comprobante.',
                    'type' => 'danger',
                ]);
            }
            return false;
        }

        $paymentsModel = new PaymentsModel($this->db);
        $payments = $paymentsModel->byInvoice((int)$payment['invoice_id']);
        $paidTotal = array_sum(array_map(static fn(array $paymentRow) => (float)$paymentRow['monto'], $payments));
        $pendingTotal = max(0, (float)$invoice['total'] - $paidTotal);

        $context = [
            'cliente_nombre' => $client['name'] ?? '',
            'rut' => $client['rut'] ?? '',
            'monto_total' => $invoice['total'] ?? '',
            'numero_factura' => $invoice['numero'] ?? '',
            'monto_pagado' => $payment['monto'] ?? '',
            'saldo_pendiente' => $pendingTotal,
            'fecha_pago' => $payment['fecha_pago'] ?? '',
            'metodo_pago' => $payment['metodo'] ?? '',
            'referencia_pago' => $payment['referencia'] ?? '',
        ];

        $template = $this->db->fetch('SELECT * FROM email_templates WHERE type = :type AND deleted_at IS NULL ORDER BY id DESC LIMIT 1', [
            'type' => 'pago',
        ]);
        $subject = 'Comprobante de pago factura ' . ($invoice['numero'] ?? '');
        $bodyHtml = $this->buildPaymentReceiptFallback($context);
        if ($template) {
            $subjectTemplate = trim($template['subject'] ?? '');
            $subject = $subjectTemplate !== '' ? render_template_vars($subjectTemplate, $context) : $subject;
            $bodyHtml = render_template_vars($template['body_html'] ?? '', $context);
        }

        try {
            $mailer = new Mailer($this->db);
            $sent = $mailer->send('info', $recipients, $subject, $bodyHtml);
            if ($sent) {
                $this->db->execute('INSERT INTO email_logs (client_id, type, subject, body_html, status, created_at, updated_at) VALUES (:client_id, :type, :subject, :body_html, :status, NOW(), NOW())', [
                    'client_id' => $client['id'],
                    'type' => 'pago',
                    'subject' => $subject,
                    'body_html' => $bodyHtml,
                    'status' => 'sent',
                ]);
            } elseif (!$silent) {
                $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                    'title' => 'Correo fallido',
                    'message' => 'No se pudo enviar el comprobante.',
                    'type' => 'danger',
                ]);
            }
            return $sent;
        } catch (Throwable $e) {
            log_message('error', 'Payment receipt email failed: ' . $e->getMessage());
            if (!$silent) {
                $this->db->execute('INSERT INTO notifications (title, message, type, created_at, updated_at) VALUES (:title, :message, :type, NOW(), NOW())', [
                    'title' => 'Correo fallido',
                    'message' => 'No se pudo enviar el comprobante.',
                    'type' => 'danger',
                ]);
            }
            return false;
        }
    }

    private function buildPaymentReceiptFallback(array $context): string
    {
        $clientName = e((string)($context['cliente_nombre'] ?? ''));
        $invoiceNumber = e((string)($context['numero_factura'] ?? ''));
        $amount = e((string)($context['monto_pagado'] ?? ''));
        $pending = e((string)($context['saldo_pendiente'] ?? ''));
        $date = e((string)($context['fecha_pago'] ?? ''));
        $method = e((string)($context['metodo_pago'] ?? ''));
        $reference = e((string)($context['referencia_pago'] ?? ''));

        return '<div style="font-family:Arial, sans-serif; color:#111827; line-height:1.6;">
            <h2 style="font-size:18px; margin-bottom:12px;">Comprobante de pago</h2>
            <p>Hola ' . $clientName . ',</p>
            <p>Hemos registrado el pago de la factura <strong>' . $invoiceNumber . '</strong> con el siguiente detalle:</p>
            <table style="width:100%; border-collapse:collapse; margin-bottom:16px;">
                <tr><td style="padding:6px 0;"><strong>Monto pagado:</strong></td><td style="padding:6px 0;">' . $amount . '</td></tr>
                <tr><td style="padding:6px 0;"><strong>Fecha de pago:</strong></td><td style="padding:6px 0;">' . $date . '</td></tr>
                <tr><td style="padding:6px 0;"><strong>Método:</strong></td><td style="padding:6px 0;">' . $method . '</td></tr>
                <tr><td style="padding:6px 0;"><strong>Referencia:</strong></td><td style="padding:6px 0;">' . $reference . '</td></tr>
                <tr><td style="padding:6px 0;"><strong>Saldo pendiente:</strong></td><td style="padding:6px 0;">' . $pending . '</td></tr>
            </table>
            <p>Gracias por tu pago.</p>
        </div>';
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
