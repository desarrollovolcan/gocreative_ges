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
        $invoices = $this->invoices->allWithClient(current_company_id());
        $this->render('invoices/index', [
            'title' => 'Facturas',
            'pageTitle' => 'Facturas',
            'invoices' => $invoices,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $clients = $this->clients->active($companyId);
        $services = $this->services->active($companyId);
        $projects = $this->db->fetchAll(
            'SELECT projects.*, clients.name as client_name FROM projects JOIN clients ON projects.client_id = clients.id WHERE projects.deleted_at IS NULL AND projects.company_id = :company_id ORDER BY projects.id DESC',
            ['company_id' => $companyId]
        );
        $settings = new SettingsModel($this->db);
        $prefix = $settings->get('invoice_prefix', 'FAC-');
        $number = $this->invoices->nextNumber($prefix, $companyId);
        $invoiceDefaults = $settings->get('invoice_defaults', []);
        $selectedClientId = (int)($_GET['client_id'] ?? 0);
        $selectedProjectId = (int)($_GET['project_id'] ?? 0);
        $selectedServiceId = (int)($_GET['service_id'] ?? 0);
        $projectInvoiceCount = 0;
        if ($selectedProjectId > 0) {
            $countRow = $this->db->fetch(
                'SELECT COUNT(*) as total FROM invoices WHERE project_id = :project_id AND deleted_at IS NULL AND company_id = :company_id',
                ['project_id' => $selectedProjectId, 'company_id' => $companyId]
            );
            $projectInvoiceCount = (int)($countRow['total'] ?? 0);
        }
        $this->render('invoices/create', [
            'title' => 'Nueva Factura',
            'pageTitle' => 'Nueva Factura',
            'clients' => $clients,
            'services' => $services,
            'projects' => $projects,
            'number' => $number,
            'invoiceDefaults' => $invoiceDefaults,
            'selectedClientId' => $selectedClientId,
            'selectedProjectId' => $selectedProjectId,
            'selectedServiceId' => $selectedServiceId,
            'projectInvoiceCount' => $projectInvoiceCount,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = current_company_id();
        $serviceId = trim($_POST['service_id'] ?? '');
        $projectId = trim($_POST['project_id'] ?? '');
        $issueDate = trim($_POST['fecha_emision'] ?? '');
        $dueDate = trim($_POST['fecha_vencimiento'] ?? '');
        $subtotal = trim($_POST['subtotal'] ?? '');
        $impuestos = trim($_POST['impuestos'] ?? '');
        $total = trim($_POST['total'] ?? '');
        $clientId = (int)($_POST['client_id'] ?? 0);
        $client = $this->db->fetch(
            'SELECT id FROM clients WHERE id = :id AND company_id = :company_id',
            ['id' => $clientId, 'company_id' => $companyId]
        );
        if (!$client) {
            flash('error', 'Cliente no encontrado para esta empresa.');
            $this->redirect('index.php?route=invoices/create');
        }

        $invoiceId = $this->invoices->create([
            'company_id' => $companyId,
            'client_id' => $clientId,
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
        flash('success', 'Factura creada correctamente.');
        $this->redirect('index.php?route=invoices');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $invoice = $this->db->fetch(
            'SELECT * FROM invoices WHERE id = :id AND company_id = :company_id',
            ['id' => $id, 'company_id' => current_company_id()]
        );
        if (!$invoice) {
            $this->redirect('index.php?route=invoices');
        }
        $itemsModel = new InvoiceItemsModel($this->db);
        $paymentsModel = new PaymentsModel($this->db);
        $client = $this->db->fetch(
            'SELECT * FROM clients WHERE id = :id AND company_id = :company_id',
            ['id' => $invoice['client_id'], 'company_id' => current_company_id()]
        );
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

    public function details(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $invoice = $this->db->fetch(
            'SELECT * FROM invoices WHERE id = :id AND company_id = :company_id',
            ['id' => $id, 'company_id' => current_company_id()]
        );
        if (!$invoice) {
            $this->redirect('index.php?route=invoices');
        }
        $itemsModel = new InvoiceItemsModel($this->db);
        $client = $this->db->fetch(
            'SELECT * FROM clients WHERE id = :id AND company_id = :company_id',
            ['id' => $invoice['client_id'], 'company_id' => current_company_id()]
        );
        $items = $itemsModel->byInvoice($id);
        $settings = new SettingsModel($this->db);
        $company = $settings->get('company', []);
        $this->render('invoices/details', [
            'title' => 'Detalle Factura',
            'pageTitle' => 'Detalle Factura',
            'invoice' => $invoice,
            'client' => $client,
            'items' => $items,
            'company' => $company,
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
        $this->db->execute('INSERT INTO notifications (company_id, title, message, type, created_at, updated_at) VALUES (:company_id, :title, :message, :type, NOW(), NOW())', [
            'company_id' => current_company_id(),
            'title' => 'Pago registrado',
            'message' => 'Se registró un pago para la factura #' . $invoiceId,
            'type' => 'success',
        ]);
        $this->sendPaymentReceiptEmail($paymentId, true);
        audit($this->db, Auth::user()['id'], 'pay', 'invoices', $invoiceId);
        flash('success', 'Pago registrado correctamente.');
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function updatePayment(): void
    {
        $this->requireLogin();
        verify_csrf();
        $paymentId = (int)($_POST['payment_id'] ?? 0);
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $invoice = $this->db->fetch(
            'SELECT id FROM invoices WHERE id = :id AND company_id = :company_id',
            ['id' => $invoiceId, 'company_id' => current_company_id()]
        );
        if (!$invoice) {
            flash('error', 'Factura no encontrada para esta empresa.');
            $this->redirect('index.php?route=invoices');
        }
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
        flash('success', 'Pago actualizado correctamente.');
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function deletePayment(): void
    {
        $this->requireLogin();
        verify_csrf();
        $paymentId = (int)($_POST['payment_id'] ?? 0);
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $invoice = $this->db->fetch(
            'SELECT id FROM invoices WHERE id = :id AND company_id = :company_id',
            ['id' => $invoiceId, 'company_id' => current_company_id()]
        );
        if (!$invoice) {
            flash('error', 'Factura no encontrada para esta empresa.');
            $this->redirect('index.php?route=invoices');
        }
        $payment = (new PaymentsModel($this->db))->find($paymentId);
        if ($payment) {
            $this->db->execute('DELETE FROM payments WHERE id = :id', ['id' => $paymentId]);
            $this->syncInvoiceBalance($invoiceId);
            audit($this->db, Auth::user()['id'], 'delete', 'payments', $paymentId);
            flash('success', 'Pago eliminado correctamente.');
        }
        $this->redirect('index.php?route=invoices/show&id=' . $invoiceId);
    }

    public function sendPaymentReceipt(): void
    {
        $this->requireLogin();
        verify_csrf();
        $paymentId = (int)($_POST['payment_id'] ?? 0);
        $invoiceId = (int)($_POST['invoice_id'] ?? 0);
        $invoice = $this->db->fetch(
            'SELECT id FROM invoices WHERE id = :id AND company_id = :company_id',
            ['id' => $invoiceId, 'company_id' => current_company_id()]
        );
        if (!$invoice) {
            flash('error', 'Factura no encontrada para esta empresa.');
            $this->redirect('index.php?route=invoices');
        }
        $sent = $this->sendPaymentReceiptEmail($paymentId, false);
        if ($sent) {
            $this->db->execute('INSERT INTO notifications (company_id, title, message, type, created_at, updated_at) VALUES (:company_id, :title, :message, :type, NOW(), NOW())', [
                'company_id' => current_company_id(),
                'title' => 'Comprobante enviado',
                'message' => 'El comprobante de pago fue enviado correctamente.',
                'type' => 'success',
            ]);
            flash('success', 'Comprobante enviado correctamente.');
        } else {
            flash('error', 'No se pudo enviar el comprobante.');
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
        $invoice = $this->db->fetch(
            'SELECT * FROM invoices WHERE id = :id AND company_id = :company_id',
            ['id' => (int)$payment['invoice_id'], 'company_id' => current_company_id()]
        );
        if (!$invoice) {
            return false;
        }
        $client = $this->db->fetch(
            'SELECT * FROM clients WHERE id = :id AND company_id = :company_id',
            ['id' => $invoice['client_id'], 'company_id' => current_company_id()]
        );
        if (!$client) {
            return false;
        }

        $recipients = array_filter([
            $client['email'] ?? null,
            $client['billing_email'] ?? null,
        ], fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
        if (empty($recipients)) {
            if (!$silent) {
                $this->db->execute('INSERT INTO notifications (company_id, title, message, type, created_at, updated_at) VALUES (:company_id, :title, :message, :type, NOW(), NOW())', [
                    'company_id' => current_company_id(),
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

        $template = $this->db->fetch(
            'SELECT * FROM email_templates WHERE type = :type AND deleted_at IS NULL AND company_id = :company_id ORDER BY id DESC LIMIT 1',
            ['type' => 'pago', 'company_id' => current_company_id()]
        );
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
                $this->db->execute('INSERT INTO email_logs (company_id, client_id, type, subject, body_html, status, created_at, updated_at) VALUES (:company_id, :client_id, :type, :subject, :body_html, :status, NOW(), NOW())', [
                    'company_id' => current_company_id(),
                    'client_id' => $client['id'],
                    'type' => 'pago',
                    'subject' => $subject,
                    'body_html' => $bodyHtml,
                    'status' => 'sent',
                ]);
            } elseif (!$silent) {
                $this->db->execute('INSERT INTO notifications (company_id, title, message, type, created_at, updated_at) VALUES (:company_id, :title, :message, :type, NOW(), NOW())', [
                    'company_id' => current_company_id(),
                    'title' => 'Correo fallido',
                    'message' => 'No se pudo enviar el comprobante.',
                    'type' => 'danger',
                ]);
            }
            return $sent;
        } catch (Throwable $e) {
            log_message('error', 'Payment receipt email failed: ' . $e->getMessage());
            if (!$silent) {
                $this->db->execute('INSERT INTO notifications (company_id, title, message, type, created_at, updated_at) VALUES (:company_id, :title, :message, :type, NOW(), NOW())', [
                    'company_id' => current_company_id(),
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
        $invoice = $this->db->fetch(
            'SELECT id FROM invoices WHERE id = :id AND deleted_at IS NULL' . (current_company_id() ? ' AND company_id = :company_id' : ''),
            current_company_id() ? ['id' => $id, 'company_id' => current_company_id()] : ['id' => $id]
        );
        if (!$invoice) {
            flash('error', 'Factura no encontrada.');
            $this->redirect('index.php?route=invoices');
        }
        $payments = $this->db->fetch('SELECT COUNT(*) as total FROM payments WHERE invoice_id = :id', ['id' => $id]);
        if (!empty($payments['total'])) {
            flash('error', 'No se puede eliminar la factura porque tiene pagos asociados.');
            $this->redirect('index.php?route=invoices');
        }
        $this->invoices->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'invoices', $id);
        flash('success', 'Factura eliminada correctamente.');
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
