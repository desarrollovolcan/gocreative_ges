<?php

class ServicesController extends Controller
{
    private ServicesModel $services;
    private ClientsModel $clients;
    private EmailQueueModel $queue;
    private EmailTemplatesModel $templates;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->services = new ServicesModel($db);
        $this->clients = new ClientsModel($db);
        $this->queue = new EmailQueueModel($db);
        $this->templates = new EmailTemplatesModel($db);
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
        $serviceId = $this->services->create($data);
        $service = $this->services->find($serviceId);
        if ($service) {
            $client = $this->db->fetch('SELECT * FROM clients WHERE id = :id', ['id' => $service['client_id']]);
            if ($client) {
                $this->enqueueServiceEmails($service, $client);
            }
        }
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

    private function enqueueServiceEmails(array $service, array $client): void
    {
        $settings = new SettingsModel($this->db);
        $company = $settings->get('company', []);
        $billingDefaults = $settings->get('billing_defaults', []);
        $sendTime = $billingDefaults['send_time'] ?? '09:00';
        $timezone = $billingDefaults['timezone'] ?? ($this->config['app']['timezone'] ?? 'UTC');
        $scheduledNow = (new DateTimeImmutable('now', new DateTimeZone($timezone)))->format('Y-m-d H:i:s');

        $context = [
            'cliente_nombre' => $client['name'] ?? '',
            'servicio_nombre' => $service['name'] ?? '',
            'dominio' => ($service['service_type'] ?? '') === 'dominio' ? ($service['name'] ?? '') : '',
            'hosting' => ($service['service_type'] ?? '') === 'hosting' ? ($service['name'] ?? '') : '',
            'monto_total' => number_format((float)($service['cost'] ?? 0), 0, ',', '.'),
            'fecha_vencimiento' => $service['due_date'] ?? '',
            'fecha_eliminacion' => $service['delete_date'] ?? '',
            'link_pago' => '',
        ];

        $this->queue->create([
            'client_id' => $client['id'],
            'template_id' => $this->getTemplateId('Registro de servicio'),
            'subject' => 'Registro del servicio con éxito',
            'body_html' => $this->renderTemplateOrFallback(
                'Registro de servicio',
                $this->renderServiceEmail(
                    'Registro del servicio con éxito',
                    'Hemos registrado tu servicio correctamente. Te mantendremos informado sobre los próximos vencimientos.',
                    '#166534',
                    '#dcfce7',
                    $company,
                    $context
                ),
                $context
            ),
            'type' => 'informativo',
            'status' => 'pending',
            'scheduled_at' => $scheduledNow,
            'tries' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (!empty($service['due_date'])) {
            $dueDate = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $service['due_date'] . ' ' . $sendTime, new DateTimeZone($timezone))
                ?: new DateTimeImmutable($service['due_date'] . ' ' . $sendTime, new DateTimeZone($timezone));

            $reminders = [
                ['days' => 15, 'subject' => 'Primer aviso: vence en 15 días', 'template' => 'Cobranza 15 días'],
                ['days' => 10, 'subject' => 'Segundo aviso: vence en 10 días', 'template' => 'Cobranza 10 días'],
                ['days' => 5, 'subject' => 'Tercer aviso: vence en 5 días', 'template' => 'Cobranza 5 días'],
            ];

            foreach ($reminders as $reminder) {
                $scheduledAt = $dueDate->sub(new DateInterval('P' . $reminder['days'] . 'D'))->format('Y-m-d H:i:s');
                $this->queue->create([
                    'client_id' => $client['id'],
                    'template_id' => $this->getTemplateId($reminder['template']),
                    'subject' => $reminder['subject'],
                    'body_html' => $this->renderTemplateOrFallback(
                        $reminder['template'],
                        $this->renderServiceEmail(
                            $reminder['subject'],
                            'Te recordamos que tu servicio está próximo a vencer. Evita la suspensión realizando el pago a tiempo.',
                            '#9a3412',
                            '#ffedd5',
                            $company,
                            $context
                        ),
                        $context
                    ),
                    'type' => 'cobranza',
                    'status' => 'pending',
                    'scheduled_at' => $scheduledAt,
                    'tries' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $suspensionSubject = 'Servicio suspendido por vencimiento';
            $this->queue->create([
                'client_id' => $client['id'],
                'template_id' => $this->getTemplateId('Servicio suspendido'),
                'subject' => $suspensionSubject,
                'body_html' => $this->renderTemplateOrFallback(
                    'Servicio suspendido',
                    $this->renderServiceEmail(
                        $suspensionSubject,
                        'Debido al no pago, el servicio se encuentra vencido y será suspendido en la fecha indicada.',
                        '#7f1d1d',
                        '#fee2e2',
                        $company,
                        $context
                    ),
                    $context
                ),
                'type' => 'cobranza',
                'status' => 'pending',
                'scheduled_at' => $dueDate->format('Y-m-d H:i:s'),
                'tries' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function renderServiceEmail(
        string $title,
        string $intro,
        string $accentColor,
        string $accentBackground,
        array $company,
        array $context
    ): string {
        $companyName = $company['name'] ?? 'Go Creative';
        $companyRut = $company['rut'] ?? '';
        $companyBank = $company['bank'] ?? '';
        $companyAccountType = $company['account_type'] ?? '';
        $companyAccountNumber = $company['account_number'] ?? '';
        $companyEmail = $company['email'] ?? 'cobranza@gocreative.cl';
        $signature = $company['signature'] ?? 'Equipo Go Creative';

        $html = '
<p>&nbsp;</p>
<div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
  Aviso de eliminación: su sitio web, correos del dominio y presencia en Google asociados a {{dominio}} serán dados de baja por no pago.
</div>

<table style="background:#f6f7f9; padding:28px 16px;" role="presentation" width="100%" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td align="center">
        <table style="max-width:640px;" role="presentation" width="640" cellspacing="0" cellpadding="0">
          <tbody>

            <tr>
              <td style="color:#6b7280; font-size:13px; letter-spacing:.08em; text-transform:uppercase; padding-bottom:12px;">
                ' . e($companyName) . ' · Cobranza
              </td>
            </tr>

            <tr>
              <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;">

                <h1 style="margin:0 0 12px 0; font-size:20px; color:' . e($accentColor) . ';">
                  ' . e($title) . ' – {{dominio}}
                </h1>

                <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#374151;">
                  Estimado/a {{cliente_nombre}},<br /><br />
                  ' . e($intro) . '
                </p>

                <div style="background:' . e($accentBackground) . '; border:1px solid #fecaca; border-radius:12px; padding:14px; margin-bottom:18px;">
                  <p style="margin:0; font-size:14px; line-height:1.6; color:' . e($accentColor) . ';">
                    <strong>Consecuencias de la eliminación:</strong><br />
                    &bull; <strong>Baja definitiva del sitio web</strong> (la página dejará de estar disponible).<br />
                    &bull; <strong>Desactivación de los correos asociados al dominio</strong> (ej.: contacto@{{dominio}}).<br />
                    &bull; Pérdida de continuidad en la <strong>presencia en Google y en la web</strong>.
                  </p>
                </div>

                <h2 style="font-size:14px; margin:0 0 8px 0; color:#111827;">
                  Detalle de servicios
                </h2>

                <table style="border-collapse:collapse; margin-bottom:16px;" width="100%" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td style="padding:10px; border:1px solid #e5e7eb; background:#f9fafb;">{{servicio_nombre}}</td>
                      <td style="padding:10px; border:1px solid #e5e7eb; text-align:right;">$ {{monto_total}}</td>
                    </tr>
                    <tr>
                      <td style="padding:10px; border:1px solid #e5e7eb; background:#f3f4f6; font-weight:bold;">
                        Total adeudado
                      </td>
                      <td style="padding:10px; border:1px solid #e5e7eb; text-align:right; font-weight:bold;">
                        $ {{monto_total}}
                      </td>
                    </tr>
                  </tbody>
                </table>

                <p style="font-size:14px; margin:0 0 16px 0; color:#111827;">
                  <strong>Fecha de vencimiento:</strong> {{fecha_vencimiento}}
                </p>

                <h2 style="font-size:14px; margin:0 0 8px 0; color:#111827;">
                  Datos para realizar el pago
                </h2>

                <table style="border-collapse:separate; border-spacing:0; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; margin-bottom:16px;" width="100%" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td style="padding:12px; font-size:14px; line-height:1.7; color:#111827;">
                        <strong>Beneficiario:</strong> ' . e($companyName) . '<br />
                        <strong>RUT:</strong> ' . e($companyRut) . '<br />
                        <strong>Banco:</strong> ' . e($companyBank) . '<br />
                        <strong>Tipo de cuenta:</strong> ' . e($companyAccountType) . '<br />
                        <strong>Número de cuenta:</strong> ' . e($companyAccountNumber) . '<br />
                        <strong>Email de confirmación:</strong>
                        <a href="mailto:' . e($companyEmail) . '" style="color:#0ea5e9; text-decoration:none;">
                          ' . e($companyEmail) . '
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div style="text-align:center; margin-bottom:10px;">
                  <a href="mailto:' . e($companyEmail) . '?subject=Comprobante%20de%20pago%20-%20{{dominio}}"
                     style="background:' . e($accentColor) . '; color:#ffffff; padding:12px 18px; border-radius:10px;
                            text-decoration:none; font-size:14px; font-weight:bold; display:inline-block;">
                    Enviar comprobante de pago
                  </a>
                </div>

                <p style="margin:0 0 6px 0; font-size:12px; line-height:1.6; color:#6b7280;">
                  Una vez realizado el pago, envíe el comprobante para confirmar y evitar la eliminación definitiva.
                </p>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:18px 0;" />

                <p style="font-size:12px; color:#6b7280; line-height:1.6; margin:0;">
                  Saludos cordiales,<br />
                  <strong>' . e($signature) . '</strong><br />
                  Área de Cobranza ·
                  <a href="mailto:' . e($companyEmail) . '" style="color:#6b7280; text-decoration:underline;">
                    ' . e($companyEmail) . '
                  </a>
                </p>

              </td>
            </tr>

            <tr>
              <td style="height:14px;">&nbsp;</td>
            </tr>

            <tr>
              <td style="font-size:11px; color:#9ca3af; line-height:1.6; padding:0 6px;">
                Nota: la eliminación del servicio puede implicar pérdida de información alojada y la interrupción total de los correos del dominio.
              </td>
            </tr>

          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>';

        return render_template_vars($html, $context);
    }

    private function renderTemplateOrFallback(string $name, string $fallback, array $context): string
    {
        $template = $this->db->fetch('SELECT body_html FROM email_templates WHERE name = :name AND deleted_at IS NULL', [
            'name' => $name,
        ]);
        if (!$template) {
            return $fallback;
        }

        return render_template_vars($template['body_html'], $context);
    }

    private function getTemplateId(string $name): ?int
    {
        $template = $this->db->fetch('SELECT id FROM email_templates WHERE name = :name AND deleted_at IS NULL', [
            'name' => $name,
        ]);

        return $template ? (int)$template['id'] : null;
    }
}
