CREATE DATABASE IF NOT EXISTS gocreative_ges CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gocreative_ges;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    logo_color VARCHAR(255) NULL,
    logo_black VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_key VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    avatar_path VARCHAR(255) NULL,
    signature TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE user_companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(50) NULL,
    email VARCHAR(150) NOT NULL,
    billing_email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    contact VARCHAR(150) NULL,
    mandante_name VARCHAR(150) NULL,
    mandante_rut VARCHAR(50) NULL,
    mandante_phone VARCHAR(50) NULL,
    mandante_email VARCHAR(150) NULL,
    avatar_path VARCHAR(255) NULL,
    portal_token VARCHAR(64) NULL,
    portal_password VARCHAR(255) NULL,
    notes TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    status VARCHAR(50) NOT NULL,
    start_date DATE NULL,
    delivery_date DATE NULL,
    value DECIMAL(12,2) NULL,
    mandante_name VARCHAR(150) NULL,
    mandante_rut VARCHAR(50) NULL,
    mandante_phone VARCHAR(50) NULL,
    mandante_email VARCHAR(150) NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE project_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    progress_percent TINYINT UNSIGNED NOT NULL DEFAULT 0,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    name VARCHAR(150) NOT NULL,
    cost DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    billing_cycle VARCHAR(20) NOT NULL DEFAULT 'mensual',
    start_date DATE NULL,
    due_date DATE NULL,
    delete_date DATE NULL,
    notice_days_1 INT NOT NULL DEFAULT 15,
    notice_days_2 INT NOT NULL DEFAULT 5,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    auto_invoice TINYINT(1) NOT NULL DEFAULT 1,
    auto_email TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE service_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE system_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_type_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    cost DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (service_type_id) REFERENCES service_types(id)
);

CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_id INT NULL,
    project_id INT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha_emision DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    estado VARCHAR(20) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    impuestos DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    notas TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_id INT NULL,
    system_service_id INT NULL,
    project_id INT NULL,
    numero VARCHAR(50) NOT NULL,
    fecha_emision DATE NOT NULL,
    estado VARCHAR(20) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    impuestos DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    notas TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (system_service_id) REFERENCES system_services(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE quote_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_id INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE chat_threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    subject VARCHAR(150) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT NOT NULL,
    sender_type VARCHAR(20) NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (thread_id) REFERENCES chat_threads(id)
);

CREATE TABLE support_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    subject VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    priority VARCHAR(20) NOT NULL DEFAULT 'media',
    assigned_user_id INT NULL,
    created_by_type VARCHAR(20) NOT NULL DEFAULT 'client',
    created_by_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    closed_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (assigned_user_id) REFERENCES users(id)
);

CREATE TABLE support_ticket_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    sender_type VARCHAR(20) NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES support_tickets(id)
);

INSERT INTO service_types (name, created_at, updated_at) VALUES
('hosting', NOW(), NOW()),
('dominio', NOW(), NOW());

INSERT INTO system_services (service_type_id, name, description, cost, currency, created_at, updated_at) VALUES
((SELECT id FROM service_types WHERE name = 'hosting'), 'Hosting Básico', 'Plan básico de hosting compartido', 15000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'hosting'), 'Hosting Profesional', 'Plan profesional con mayor almacenamiento', 25000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'hosting'), 'Hosting Premium', 'Plan premium con soporte prioritario', 35000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'hosting'), 'Hosting Corporativo', 'Plan corporativo con alta disponibilidad', 45000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'hosting'), 'Hosting Ecommerce', 'Plan optimizado para tiendas online', 55000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'dominio'), 'Dominio .cl', 'Registro anual de dominio .cl', 12000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'dominio'), 'Dominio .com', 'Registro anual de dominio .com', 14000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'dominio'), 'Dominio .net', 'Registro anual de dominio .net', 16000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'dominio'), 'Dominio .org', 'Registro anual de dominio .org', 15000, 'CLP', NOW(), NOW()),
((SELECT id FROM service_types WHERE name = 'dominio'), 'Dominio .io', 'Registro anual de dominio .io', 42000, 'CLP', NOW(), NOW());

CREATE TABLE invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    monto DECIMAL(12,2) NOT NULL,
    fecha_pago DATE NOT NULL,
    metodo VARCHAR(50) NOT NULL,
    referencia VARCHAR(150) NULL,
    comprobante VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);

CREATE TABLE email_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'cobranza',
    created_by INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NULL,
    template_id INT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'cobranza',
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    scheduled_at DATETIME NOT NULL,
    tries INT NOT NULL DEFAULT 0,
    last_error TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (template_id) REFERENCES email_templates(id)
);

CREATE TABLE email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NULL,
    type VARCHAR(20) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    status VARCHAR(20) NOT NULL,
    error TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NULL,
    `key` VARCHAR(100) NOT NULL,
    value MEDIUMTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NULL,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(20) NOT NULL,
    read_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NULL,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    entity VARCHAR(50) NOT NULL,
    entity_id INT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX idx_clients_status ON clients(status);
CREATE UNIQUE INDEX idx_clients_portal_token ON clients(portal_token);
CREATE INDEX idx_services_status ON services(status);
CREATE INDEX idx_services_due_date ON services(due_date);
CREATE INDEX idx_invoices_estado ON invoices(estado);
CREATE INDEX idx_invoices_numero ON invoices(numero);
CREATE INDEX idx_email_queue_status ON email_queue(status);
CREATE UNIQUE INDEX idx_settings_key_company ON settings(company_id, `key`);
CREATE UNIQUE INDEX idx_user_companies_unique ON user_companies(user_id, company_id);

INSERT INTO roles (name, created_at, updated_at) VALUES
('admin', NOW(), NOW()),
('operador', NOW(), NOW());

INSERT INTO companies (name, rut, email, created_at, updated_at) VALUES
('GoCreative', '', 'contacto@gocreative.cl', NOW(), NOW());

INSERT INTO users (company_id, name, email, password, role_id, created_at, updated_at) VALUES
(1, 'E Isla', 'eisla@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 1, NOW(), NOW());

INSERT INTO user_companies (user_id, company_id, created_at) VALUES
(1, 1, NOW());

INSERT INTO settings (company_id, `key`, value, created_at, updated_at) VALUES
(1, 'company', '{"name":"GoCreative","rut":"","bank":"","account_type":"","account_number":"","email":"contacto@gocreative.cl","signature":"Saludos"}', NOW(), NOW()),
(1, 'billing_defaults', '{"notice_days_1":15,"notice_days_2":5,"send_time":"09:00","timezone":"America/Santiago","invoice_prefix":"FAC-"}', NOW(), NOW()),
(1, 'invoice_prefix', 'FAC-', NOW(), NOW()),
(1, 'smtp_cobranza', '{"host":"mail.gocreative.cl","port":465,"security":"ssl","username":"cobranza@gocreative.cl","password":"O38LP_3c?GefV6z&","from_name":"Cobranza","from_email":"cobranza@gocreative.cl","reply_to":"cobranza@gocreative.cl"}', NOW(), NOW()),
(1, 'smtp_info', '{"host":"mail.gocreative.cl","port":465,"security":"ssl","username":"informevolcan@gocreative.cl","password":"#(3-QiWGI;l}oJW_","from_name":"Información","from_email":"informevolcan@gocreative.cl","reply_to":"informevolcan@gocreative.cl"}', NOW(), NOW());

INSERT INTO email_templates (company_id, name, subject, body_html, type, created_by, created_at, updated_at) VALUES
(1, 'Registro de servicio', 'Registro del servicio con éxito', '<p>&nbsp;</p>
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
                Go Creative · Información
              </td>
            </tr>

            <tr>
              <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;">

                <h1 style="margin:0 0 12px 0; font-size:20px; color:#166534;">
                  Registro del servicio con éxito – {{dominio}}
                </h1>

                <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#374151;">
                  Estimado/a {{cliente_nombre}},<br /><br />
                  Hemos registrado tu servicio correctamente. Te mantendremos informado sobre los próximos vencimientos.
                </p>

                <div style="background:#dcfce7; border:1px solid #bbf7d0; border-radius:12px; padding:14px; margin-bottom:18px;">
                  <p style="margin:0; font-size:14px; line-height:1.6; color:#166534;">
                    <strong>Gracias por confiar en nosotros.</strong> Si necesitas actualizar datos o realizar cambios, contáctanos.
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
                        Total
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

                <p style="margin:0 0 6px 0; font-size:12px; line-height:1.6; color:#6b7280;">
                  Cualquier duda puedes escribirnos a cobranza@gocreative.cl.
                </p>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:18px 0;" />

                <p style="font-size:12px; color:#6b7280; line-height:1.6; margin:0;">
                  Saludos cordiales,<br />
                  <strong>Equipo Go Creative</strong><br />
                  Área de Información ·
                  <a href="mailto:info@gocreative.cl" style="color:#6b7280; text-decoration:underline;">
                    info@gocreative.cl
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
</table>', 'informativo', 1, NOW(), NOW()),
(1, 'Cobranza 15 días', 'Primer aviso: vence en 15 días', '<p>&nbsp;</p>
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
                Go Creative · Cobranza
              </td>
            </tr>

            <tr>
              <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;">

                <h1 style="margin:0 0 12px 0; font-size:20px; color:#9a3412;">
                  Primer aviso de cobranza – {{dominio}}
                </h1>

                <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#374151;">
                  Estimado/a {{cliente_nombre}},<br /><br />
                  Le informamos que su servicio está próximo a vencer el <strong>{{fecha_vencimiento}}</strong>.
                  Evite la suspensión realizando el pago antes de la fecha indicada.
                </p>

                <div style="background:#ffedd5; border:1px solid #fed7aa; border-radius:12px; padding:14px; margin-bottom:18px;">
                  <p style="margin:0; font-size:14px; line-height:1.6; color:#9a3412;">
                    <strong>Recordatorio:</strong> Aún estás a tiempo de regularizar el pago y evitar interrupciones.
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

                <p style="margin:0 0 6px 0; font-size:12px; line-height:1.6; color:#6b7280;">
                  Una vez realizado el pago, envíe el comprobante para confirmar y evitar la eliminación definitiva.
                </p>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:18px 0;" />

                <p style="font-size:12px; color:#6b7280; line-height:1.6; margin:0;">
                  Saludos cordiales,<br />
                  <strong>Equipo Go Creative</strong><br />
                  Área de Cobranza ·
                  <a href="mailto:cobranza@gocreative.cl" style="color:#6b7280; text-decoration:underline;">
                    cobranza@gocreative.cl
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
</table>', 'cobranza', 1, NOW(), NOW()),
(1, 'Cobranza 10 días', 'Segundo aviso: vence en 10 días', '<p>&nbsp;</p>
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
                Go Creative · Cobranza
              </td>
            </tr>

            <tr>
              <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;">

                <h1 style="margin:0 0 12px 0; font-size:20px; color:#9a3412;">
                  Segundo aviso de cobranza – {{dominio}}
                </h1>

                <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#374151;">
                  Estimado/a {{cliente_nombre}},<br /><br />
                  Su servicio vence el <strong>{{fecha_vencimiento}}</strong>. Evite la suspensión realizando el pago.
                </p>

                <div style="background:#ffedd5; border:1px solid #fed7aa; border-radius:12px; padding:14px; margin-bottom:18px;">
                  <p style="margin:0; font-size:14px; line-height:1.6; color:#9a3412;">
                    <strong>Recordatorio:</strong> Quedan pocos días para regularizar el pago.
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

                <p style="margin:0 0 6px 0; font-size:12px; line-height:1.6; color:#6b7280;">
                  Una vez realizado el pago, envíe el comprobante para confirmar y evitar la eliminación definitiva.
                </p>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:18px 0;" />

                <p style="font-size:12px; color:#6b7280; line-height:1.6; margin:0;">
                  Saludos cordiales,<br />
                  <strong>Equipo Go Creative</strong><br />
                  Área de Cobranza ·
                  <a href="mailto:cobranza@gocreative.cl" style="color:#6b7280; text-decoration:underline;">
                    cobranza@gocreative.cl
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
</table>', 'cobranza', 1, NOW(), NOW()),
(1, 'Cobranza 5 días', 'Tercer aviso: vence en 5 días', '<p>&nbsp;</p>
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
                Go Creative · Cobranza
              </td>
            </tr>

            <tr>
              <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;">

                <h1 style="margin:0 0 12px 0; font-size:20px; color:#9a3412;">
                  Tercer aviso de cobranza – {{dominio}}
                </h1>

                <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#374151;">
                  Estimado/a {{cliente_nombre}},<br /><br />
                  Su servicio vence el <strong>{{fecha_vencimiento}}</strong>. Evite la suspensión realizando el pago.
                </p>

                <div style="background:#ffedd5; border:1px solid #fed7aa; border-radius:12px; padding:14px; margin-bottom:18px;">
                  <p style="margin:0; font-size:14px; line-height:1.6; color:#9a3412;">
                    <strong>Último recordatorio:</strong> Estamos a 5 días del vencimiento.
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

                <p style="margin:0 0 6px 0; font-size:12px; line-height:1.6; color:#6b7280;">
                  Una vez realizado el pago, envíe el comprobante para confirmar y evitar la eliminación definitiva.
                </p>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:18px 0;" />

                <p style="font-size:12px; color:#6b7280; line-height:1.6; margin:0;">
                  Saludos cordiales,<br />
                  <strong>Equipo Go Creative</strong><br />
                  Área de Cobranza ·
                  <a href="mailto:cobranza@gocreative.cl" style="color:#6b7280; text-decoration:underline;">
                    cobranza@gocreative.cl
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
</table>', 'cobranza', 1, NOW(), NOW()),
(1, 'Servicio suspendido', 'Servicio suspendido por vencimiento', '<p>&nbsp;</p>
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
                Go Creative · Cobranza
              </td>
            </tr>

            <tr>
              <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;">

                <h1 style="margin:0 0 12px 0; font-size:20px; color:#7f1d1d;">
                  Servicio suspendido por vencimiento – {{dominio}}
                </h1>

                <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#374151;">
                  Estimado/a {{cliente_nombre}},<br /><br />
                  Le informamos que, debido al <strong>no pago</strong> de los servicios contratados, el dominio
                  <strong>{{dominio}}</strong> se encuentra en proceso de <strong>eliminación</strong>.
                  En caso de no regularizar el pago, se procederá a la baja definitiva de los servicios asociados.
                </p>

                <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:14px; margin-bottom:18px;">
                  <p style="margin:0; font-size:14px; line-height:1.6; color:#7f1d1d;">
                    <strong>Consecuencias de la eliminación:</strong><br />
                    &bull; <strong>Baja definitiva del sitio web</strong> (la página dejará de estar disponible).<br />
                    &bull; <strong>Desactivación de los correos asociados al dominio</strong> (ej.: contacto@{{dominio}}).<br />
                    &bull; Pérdida de continuidad en la <strong>presencia en Google y en la web</strong>, afectando la visibilidad
                    del negocio y provocando que <strong>potenciales clientes no puedan encontrar ni contactar a su empresa</strong>.
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
                  <strong>Fecha de eliminación definitiva:</strong> {{fecha_eliminacion}}
                </p>

                <h2 style="font-size:14px; margin:0 0 8px 0; color:#111827;">
                  Datos para realizar el pago
                </h2>

                <table style="border-collapse:separate; border-spacing:0; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; margin-bottom:16px;" width="100%" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td style="padding:12px; font-size:14px; line-height:1.7; color:#111827;">
                        <strong>Beneficiario:</strong> Go Creative<br />
                        <strong>RUT:</strong> 15.626.773-2<br />
                        <strong>Banco:</strong> Banco Estado<br />
                        <strong>Tipo de cuenta:</strong> Ahorro<br />
                        <strong>Número de cuenta:</strong> 55164309630<br />
                        <strong>Email de confirmación:</strong>
                        <a href="mailto:cobranza@gocreative.cl" style="color:#0ea5e9; text-decoration:none;">
                          cobranza@gocreative.cl
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div style="text-align:center; margin-bottom:10px;">
                  <a href="mailto:cobranza@gocreative.cl?subject=Comprobante%20de%20pago%20-%20{{dominio}}"
                     style="background:#7f1d1d; color:#ffffff; padding:12px 18px; border-radius:10px;
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
                  <strong>Equipo Go Creative</strong><br />
                  Área de Cobranza ·
                  <a href="mailto:cobranza@gocreative.cl" style="color:#6b7280; text-decoration:underline;">
                    cobranza@gocreative.cl
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
</table>', 'cobranza', 1, NOW(), NOW());

-- Datos de prueba (15 registros por formulario principal)
INSERT INTO users (company_id, name, email, password, role_id, signature, created_at, updated_at) VALUES
(1, 'Usuario 01', 'usuario01@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 01', NOW(), NOW()),
(1, 'Usuario 02', 'usuario02@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 02', NOW(), NOW()),
(1, 'Usuario 03', 'usuario03@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 03', NOW(), NOW()),
(1, 'Usuario 04', 'usuario04@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 04', NOW(), NOW()),
(1, 'Usuario 05', 'usuario05@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 05', NOW(), NOW()),
(1, 'Usuario 06', 'usuario06@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 06', NOW(), NOW()),
(1, 'Usuario 07', 'usuario07@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 07', NOW(), NOW()),
(1, 'Usuario 08', 'usuario08@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 08', NOW(), NOW()),
(1, 'Usuario 09', 'usuario09@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 09', NOW(), NOW()),
(1, 'Usuario 10', 'usuario10@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 10', NOW(), NOW()),
(1, 'Usuario 11', 'usuario11@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 11', NOW(), NOW()),
(1, 'Usuario 12', 'usuario12@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 12', NOW(), NOW()),
(1, 'Usuario 13', 'usuario13@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 13', NOW(), NOW()),
(1, 'Usuario 14', 'usuario14@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 14', NOW(), NOW()),
(1, 'Usuario 15', 'usuario15@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 2, 'Firma 15', NOW(), NOW());

INSERT INTO clients (company_id, name, rut, email, billing_email, phone, address, contact, mandante_name, mandante_rut, mandante_phone, mandante_email, portal_token, portal_password, notes, status, created_at, updated_at) VALUES
(1, 'Cliente Portal', '76.000.016-6', 'cliente@cliente.cl', 'cobranza@cliente.cl', '+56 9 2222 0000', 'Av. Cliente 100', 'Contacto Cliente', 'Mandante Cliente', '77.000.016-6', '+56 9 2222 0001', 'mandante@cliente.cl', 'tokencliente', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Perfil de cliente para portal', 'activo', NOW(), NOW()),
(1, 'Cliente 01', '76.000.001-1', 'cliente01@example.com', 'cobranza01@example.com', '+56 9 1111 0001', 'Av. Demo 101', 'Contacto 01', 'Mandante 01', '77.000.001-1', '+56 9 2111 0001', 'mandante01@example.com', 'token01', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 01', 'activo', NOW(), NOW()),
(1, 'Cliente 02', '76.000.002-2', 'cliente02@example.com', 'cobranza02@example.com', '+56 9 1111 0002', 'Av. Demo 102', 'Contacto 02', 'Mandante 02', '77.000.002-2', '+56 9 2111 0002', 'mandante02@example.com', 'token02', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 02', 'activo', NOW(), NOW()),
(1, 'Cliente 03', '76.000.003-3', 'cliente03@example.com', 'cobranza03@example.com', '+56 9 1111 0003', 'Av. Demo 103', 'Contacto 03', 'Mandante 03', '77.000.003-3', '+56 9 2111 0003', 'mandante03@example.com', 'token03', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 03', 'activo', NOW(), NOW()),
(1, 'Cliente 04', '76.000.004-4', 'cliente04@example.com', 'cobranza04@example.com', '+56 9 1111 0004', 'Av. Demo 104', 'Contacto 04', 'Mandante 04', '77.000.004-4', '+56 9 2111 0004', 'mandante04@example.com', 'token04', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 04', 'activo', NOW(), NOW()),
(1, 'Cliente 05', '76.000.005-5', 'cliente05@example.com', 'cobranza05@example.com', '+56 9 1111 0005', 'Av. Demo 105', 'Contacto 05', 'Mandante 05', '77.000.005-5', '+56 9 2111 0005', 'mandante05@example.com', 'token05', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 05', 'activo', NOW(), NOW()),
(1, 'Cliente 06', '76.000.006-6', 'cliente06@example.com', 'cobranza06@example.com', '+56 9 1111 0006', 'Av. Demo 106', 'Contacto 06', 'Mandante 06', '77.000.006-6', '+56 9 2111 0006', 'mandante06@example.com', 'token06', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 06', 'activo', NOW(), NOW()),
(1, 'Cliente 07', '76.000.007-7', 'cliente07@example.com', 'cobranza07@example.com', '+56 9 1111 0007', 'Av. Demo 107', 'Contacto 07', 'Mandante 07', '77.000.007-7', '+56 9 2111 0007', 'mandante07@example.com', 'token07', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 07', 'activo', NOW(), NOW()),
(1, 'Cliente 08', '76.000.008-8', 'cliente08@example.com', 'cobranza08@example.com', '+56 9 1111 0008', 'Av. Demo 108', 'Contacto 08', 'Mandante 08', '77.000.008-8', '+56 9 2111 0008', 'mandante08@example.com', 'token08', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 08', 'activo', NOW(), NOW()),
(1, 'Cliente 09', '76.000.009-9', 'cliente09@example.com', 'cobranza09@example.com', '+56 9 1111 0009', 'Av. Demo 109', 'Contacto 09', 'Mandante 09', '77.000.009-9', '+56 9 2111 0009', 'mandante09@example.com', 'token09', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 09', 'activo', NOW(), NOW()),
(1, 'Cliente 10', '76.000.010-0', 'cliente10@example.com', 'cobranza10@example.com', '+56 9 1111 0010', 'Av. Demo 110', 'Contacto 10', 'Mandante 10', '77.000.010-0', '+56 9 2111 0010', 'mandante10@example.com', 'token10', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 10', 'activo', NOW(), NOW()),
(1, 'Cliente 11', '76.000.011-1', 'cliente11@example.com', 'cobranza11@example.com', '+56 9 1111 0011', 'Av. Demo 111', 'Contacto 11', 'Mandante 11', '77.000.011-1', '+56 9 2111 0011', 'mandante11@example.com', 'token11', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 11', 'activo', NOW(), NOW()),
(1, 'Cliente 12', '76.000.012-2', 'cliente12@example.com', 'cobranza12@example.com', '+56 9 1111 0012', 'Av. Demo 112', 'Contacto 12', 'Mandante 12', '77.000.012-2', '+56 9 2111 0012', 'mandante12@example.com', 'token12', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 12', 'activo', NOW(), NOW()),
(1, 'Cliente 13', '76.000.013-3', 'cliente13@example.com', 'cobranza13@example.com', '+56 9 1111 0013', 'Av. Demo 113', 'Contacto 13', 'Mandante 13', '77.000.013-3', '+56 9 2111 0013', 'mandante13@example.com', 'token13', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 13', 'activo', NOW(), NOW()),
(1, 'Cliente 14', '76.000.014-4', 'cliente14@example.com', 'cobranza14@example.com', '+56 9 1111 0014', 'Av. Demo 114', 'Contacto 14', 'Mandante 14', '77.000.014-4', '+56 9 2111 0014', 'mandante14@example.com', 'token14', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 14', 'activo', NOW(), NOW()),
(1, 'Cliente 15', '76.000.015-5', 'cliente15@example.com', 'cobranza15@example.com', '+56 9 1111 0015', 'Av. Demo 115', 'Contacto 15', 'Mandante 15', '77.000.015-5', '+56 9 2111 0015', 'mandante15@example.com', 'token15', '$2y$12$nUf/9qZQktkbS6ZRrWmWSOZKICU21yL0COcoaZiPmFwgegTGomdQW', 'Notas cliente 15', 'activo', NOW(), NOW());

INSERT INTO projects (company_id, client_id, name, description, status, start_date, delivery_date, value, mandante_name, mandante_rut, mandante_phone, mandante_email, notes, created_at, updated_at) VALUES
(1, 1, 'Proyecto 01', 'Descripción proyecto 01', 'activo', '2024-01-05', '2024-03-05', 1200000.00, 'Mandante 01', '77.000.001-1', '+56 9 2111 0001', 'mandante01@example.com', 'Notas proyecto 01', NOW(), NOW()),
(1, 2, 'Proyecto 02', 'Descripción proyecto 02', 'activo', '2024-01-06', '2024-03-06', 1300000.00, 'Mandante 02', '77.000.002-2', '+56 9 2111 0002', 'mandante02@example.com', 'Notas proyecto 02', NOW(), NOW()),
(1, 3, 'Proyecto 03', 'Descripción proyecto 03', 'activo', '2024-01-07', '2024-03-07', 1400000.00, 'Mandante 03', '77.000.003-3', '+56 9 2111 0003', 'mandante03@example.com', 'Notas proyecto 03', NOW(), NOW()),
(1, 4, 'Proyecto 04', 'Descripción proyecto 04', 'activo', '2024-01-08', '2024-03-08', 1500000.00, 'Mandante 04', '77.000.004-4', '+56 9 2111 0004', 'mandante04@example.com', 'Notas proyecto 04', NOW(), NOW()),
(1, 5, 'Proyecto 05', 'Descripción proyecto 05', 'activo', '2024-01-09', '2024-03-09', 1600000.00, 'Mandante 05', '77.000.005-5', '+56 9 2111 0005', 'mandante05@example.com', 'Notas proyecto 05', NOW(), NOW()),
(1, 6, 'Proyecto 06', 'Descripción proyecto 06', 'activo', '2024-01-10', '2024-03-10', 1700000.00, 'Mandante 06', '77.000.006-6', '+56 9 2111 0006', 'mandante06@example.com', 'Notas proyecto 06', NOW(), NOW()),
(1, 7, 'Proyecto 07', 'Descripción proyecto 07', 'activo', '2024-01-11', '2024-03-11', 1800000.00, 'Mandante 07', '77.000.007-7', '+56 9 2111 0007', 'mandante07@example.com', 'Notas proyecto 07', NOW(), NOW()),
(1, 8, 'Proyecto 08', 'Descripción proyecto 08', 'activo', '2024-01-12', '2024-03-12', 1900000.00, 'Mandante 08', '77.000.008-8', '+56 9 2111 0008', 'mandante08@example.com', 'Notas proyecto 08', NOW(), NOW()),
(1, 9, 'Proyecto 09', 'Descripción proyecto 09', 'activo', '2024-01-13', '2024-03-13', 2000000.00, 'Mandante 09', '77.000.009-9', '+56 9 2111 0009', 'mandante09@example.com', 'Notas proyecto 09', NOW(), NOW()),
(1, 10, 'Proyecto 10', 'Descripción proyecto 10', 'activo', '2024-01-14', '2024-03-14', 2100000.00, 'Mandante 10', '77.000.010-0', '+56 9 2111 0010', 'mandante10@example.com', 'Notas proyecto 10', NOW(), NOW()),
(1, 11, 'Proyecto 11', 'Descripción proyecto 11', 'activo', '2024-01-15', '2024-03-15', 2200000.00, 'Mandante 11', '77.000.011-1', '+56 9 2111 0011', 'mandante11@example.com', 'Notas proyecto 11', NOW(), NOW()),
(1, 12, 'Proyecto 12', 'Descripción proyecto 12', 'activo', '2024-01-16', '2024-03-16', 2300000.00, 'Mandante 12', '77.000.012-2', '+56 9 2111 0012', 'mandante12@example.com', 'Notas proyecto 12', NOW(), NOW()),
(1, 13, 'Proyecto 13', 'Descripción proyecto 13', 'activo', '2024-01-17', '2024-03-17', 2400000.00, 'Mandante 13', '77.000.013-3', '+56 9 2111 0013', 'mandante13@example.com', 'Notas proyecto 13', NOW(), NOW()),
(1, 14, 'Proyecto 14', 'Descripción proyecto 14', 'activo', '2024-01-18', '2024-03-18', 2500000.00, 'Mandante 14', '77.000.014-4', '+56 9 2111 0014', 'mandante14@example.com', 'Notas proyecto 14', NOW(), NOW()),
(1, 15, 'Proyecto 15', 'Descripción proyecto 15', 'activo', '2024-01-19', '2024-03-19', 2600000.00, 'Mandante 15', '77.000.015-5', '+56 9 2111 0015', 'mandante15@example.com', 'Notas proyecto 15', NOW(), NOW());

INSERT INTO project_tasks (project_id, title, start_date, end_date, progress_percent, completed, created_at, updated_at) VALUES
(1, 'Tarea 01', '2024-01-05', '2024-01-12', 25, 0, NOW(), NOW()),
(2, 'Tarea 02', '2024-01-06', '2024-01-20', 100, 1, NOW(), NOW()),
(3, 'Tarea 03', '2024-01-07', '2024-01-18', 50, 0, NOW(), NOW()),
(4, 'Tarea 04', '2024-01-08', '2024-01-22', 100, 1, NOW(), NOW()),
(5, 'Tarea 05', '2024-01-09', '2024-01-16', 15, 0, NOW(), NOW()),
(6, 'Tarea 06', '2024-01-10', '2024-01-24', 100, 1, NOW(), NOW()),
(7, 'Tarea 07', '2024-01-11', '2024-01-19', 40, 0, NOW(), NOW()),
(8, 'Tarea 08', '2024-01-12', '2024-01-26', 100, 1, NOW(), NOW()),
(9, 'Tarea 09', '2024-01-13', '2024-01-21', 60, 0, NOW(), NOW()),
(10, 'Tarea 10', '2024-01-14', '2024-01-28', 100, 1, NOW(), NOW()),
(11, 'Tarea 11', '2024-01-15', '2024-01-23', 35, 0, NOW(), NOW()),
(12, 'Tarea 12', '2024-01-16', '2024-01-30', 100, 1, NOW(), NOW()),
(13, 'Tarea 13', '2024-01-17', '2024-01-25', 10, 0, NOW(), NOW()),
(14, 'Tarea 14', '2024-01-18', '2024-02-01', 100, 1, NOW(), NOW()),
(15, 'Tarea 15', '2024-01-19', '2024-01-27', 20, 0, NOW(), NOW());

INSERT INTO services (company_id, client_id, service_type, name, cost, currency, billing_cycle, start_date, due_date, delete_date, notice_days_1, notice_days_2, status, auto_invoice, auto_email, created_at, updated_at) VALUES
(1, 1, 'hosting', 'Servicio 01', 12000.00, 'CLP', 'mensual', '2024-02-01', '2024-03-01', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 2, 'hosting', 'Servicio 02', 13000.00, 'CLP', 'mensual', '2024-02-02', '2024-03-02', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 3, 'hosting', 'Servicio 03', 14000.00, 'CLP', 'mensual', '2024-02-03', '2024-03-03', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 4, 'hosting', 'Servicio 04', 15000.00, 'CLP', 'mensual', '2024-02-04', '2024-03-04', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 5, 'hosting', 'Servicio 05', 16000.00, 'CLP', 'mensual', '2024-02-05', '2024-03-05', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 6, 'hosting', 'Servicio 06', 17000.00, 'CLP', 'mensual', '2024-02-06', '2024-03-06', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 7, 'hosting', 'Servicio 07', 18000.00, 'CLP', 'mensual', '2024-02-07', '2024-03-07', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 8, 'hosting', 'Servicio 08', 19000.00, 'CLP', 'mensual', '2024-02-08', '2024-03-08', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 9, 'hosting', 'Servicio 09', 20000.00, 'CLP', 'mensual', '2024-02-09', '2024-03-09', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 10, 'hosting', 'Servicio 10', 21000.00, 'CLP', 'mensual', '2024-02-10', '2024-03-10', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 11, 'hosting', 'Servicio 11', 22000.00, 'CLP', 'mensual', '2024-02-11', '2024-03-11', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 12, 'hosting', 'Servicio 12', 23000.00, 'CLP', 'mensual', '2024-02-12', '2024-03-12', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 13, 'hosting', 'Servicio 13', 24000.00, 'CLP', 'mensual', '2024-02-13', '2024-03-13', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 14, 'hosting', 'Servicio 14', 25000.00, 'CLP', 'mensual', '2024-02-14', '2024-03-14', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW()),
(1, 15, 'hosting', 'Servicio 15', 26000.00, 'CLP', 'mensual', '2024-02-15', '2024-03-15', NULL, 15, 5, 'activo', 1, 1, NOW(), NOW());

INSERT INTO invoices (company_id, client_id, service_id, project_id, numero, fecha_emision, fecha_vencimiento, estado, subtotal, impuestos, total, notas, created_at, updated_at) VALUES
(1, 1, 1, 1, 'FAC-0001', '2024-02-01', '2024-02-15', 'pendiente', 12000.00, 2280.00, 14280.00, 'Factura demo 01', NOW(), NOW()),
(1, 2, 2, 2, 'FAC-0002', '2024-02-02', '2024-02-16', 'pendiente', 13000.00, 2470.00, 15470.00, 'Factura demo 02', NOW(), NOW()),
(1, 3, 3, 3, 'FAC-0003', '2024-02-03', '2024-02-17', 'pendiente', 14000.00, 2660.00, 16660.00, 'Factura demo 03', NOW(), NOW()),
(1, 4, 4, 4, 'FAC-0004', '2024-02-04', '2024-02-18', 'pendiente', 15000.00, 2850.00, 17850.00, 'Factura demo 04', NOW(), NOW()),
(1, 5, 5, 5, 'FAC-0005', '2024-02-05', '2024-02-19', 'pendiente', 16000.00, 3040.00, 19040.00, 'Factura demo 05', NOW(), NOW()),
(1, 6, 6, 6, 'FAC-0006', '2024-02-06', '2024-02-20', 'pendiente', 17000.00, 3230.00, 20230.00, 'Factura demo 06', NOW(), NOW()),
(1, 7, 7, 7, 'FAC-0007', '2024-02-07', '2024-02-21', 'pendiente', 18000.00, 3420.00, 21420.00, 'Factura demo 07', NOW(), NOW()),
(1, 8, 8, 8, 'FAC-0008', '2024-02-08', '2024-02-22', 'pendiente', 19000.00, 3610.00, 22610.00, 'Factura demo 08', NOW(), NOW()),
(1, 9, 9, 9, 'FAC-0009', '2024-02-09', '2024-02-23', 'pendiente', 20000.00, 3800.00, 23800.00, 'Factura demo 09', NOW(), NOW()),
(1, 10, 10, 10, 'FAC-0010', '2024-02-10', '2024-02-24', 'pendiente', 21000.00, 3990.00, 24990.00, 'Factura demo 10', NOW(), NOW()),
(1, 11, 11, 11, 'FAC-0011', '2024-02-11', '2024-02-25', 'pendiente', 22000.00, 4180.00, 26180.00, 'Factura demo 11', NOW(), NOW()),
(1, 12, 12, 12, 'FAC-0012', '2024-02-12', '2024-02-26', 'pendiente', 23000.00, 4370.00, 27370.00, 'Factura demo 12', NOW(), NOW()),
(1, 13, 13, 13, 'FAC-0013', '2024-02-13', '2024-02-27', 'pendiente', 24000.00, 4560.00, 28560.00, 'Factura demo 13', NOW(), NOW()),
(1, 14, 14, 14, 'FAC-0014', '2024-02-14', '2024-02-28', 'pendiente', 25000.00, 4750.00, 29750.00, 'Factura demo 14', NOW(), NOW()),
(1, 15, 15, 15, 'FAC-0015', '2024-02-15', '2024-02-29', 'pendiente', 26000.00, 4940.00, 30940.00, 'Factura demo 15', NOW(), NOW());

INSERT INTO invoice_items (invoice_id, descripcion, cantidad, precio_unitario, total, created_at, updated_at) VALUES
(1, 'Item factura 01', 1, 12000.00, 12000.00, NOW(), NOW()),
(2, 'Item factura 02', 1, 13000.00, 13000.00, NOW(), NOW()),
(3, 'Item factura 03', 1, 14000.00, 14000.00, NOW(), NOW()),
(4, 'Item factura 04', 1, 15000.00, 15000.00, NOW(), NOW()),
(5, 'Item factura 05', 1, 16000.00, 16000.00, NOW(), NOW()),
(6, 'Item factura 06', 1, 17000.00, 17000.00, NOW(), NOW()),
(7, 'Item factura 07', 1, 18000.00, 18000.00, NOW(), NOW()),
(8, 'Item factura 08', 1, 19000.00, 19000.00, NOW(), NOW()),
(9, 'Item factura 09', 1, 20000.00, 20000.00, NOW(), NOW()),
(10, 'Item factura 10', 1, 21000.00, 21000.00, NOW(), NOW()),
(11, 'Item factura 11', 1, 22000.00, 22000.00, NOW(), NOW()),
(12, 'Item factura 12', 1, 23000.00, 23000.00, NOW(), NOW()),
(13, 'Item factura 13', 1, 24000.00, 24000.00, NOW(), NOW()),
(14, 'Item factura 14', 1, 25000.00, 25000.00, NOW(), NOW()),
(15, 'Item factura 15', 1, 26000.00, 26000.00, NOW(), NOW());

INSERT INTO payments (invoice_id, monto, fecha_pago, metodo, referencia, comprobante, created_at, updated_at) VALUES
(1, 14280.00, '2024-02-10', 'transferencia', 'REF-0001', NULL, NOW(), NOW()),
(2, 15470.00, '2024-02-11', 'transferencia', 'REF-0002', NULL, NOW(), NOW()),
(3, 16660.00, '2024-02-12', 'transferencia', 'REF-0003', NULL, NOW(), NOW()),
(4, 17850.00, '2024-02-13', 'transferencia', 'REF-0004', NULL, NOW(), NOW()),
(5, 19040.00, '2024-02-14', 'transferencia', 'REF-0005', NULL, NOW(), NOW()),
(6, 20230.00, '2024-02-15', 'transferencia', 'REF-0006', NULL, NOW(), NOW()),
(7, 21420.00, '2024-02-16', 'transferencia', 'REF-0007', NULL, NOW(), NOW()),
(8, 22610.00, '2024-02-17', 'transferencia', 'REF-0008', NULL, NOW(), NOW()),
(9, 23800.00, '2024-02-18', 'transferencia', 'REF-0009', NULL, NOW(), NOW()),
(10, 24990.00, '2024-02-19', 'transferencia', 'REF-0010', NULL, NOW(), NOW()),
(11, 26180.00, '2024-02-20', 'transferencia', 'REF-0011', NULL, NOW(), NOW()),
(12, 27370.00, '2024-02-21', 'transferencia', 'REF-0012', NULL, NOW(), NOW()),
(13, 28560.00, '2024-02-22', 'transferencia', 'REF-0013', NULL, NOW(), NOW()),
(14, 29750.00, '2024-02-23', 'transferencia', 'REF-0014', NULL, NOW(), NOW()),
(15, 30940.00, '2024-02-24', 'transferencia', 'REF-0015', NULL, NOW(), NOW());

INSERT INTO email_templates (company_id, name, subject, body_html, type, created_by, created_at, updated_at) VALUES
(1, 'Template Demo 01', 'Asunto demo 01', '<p>Contenido demo 01</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 02', 'Asunto demo 02', '<p>Contenido demo 02</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 03', 'Asunto demo 03', '<p>Contenido demo 03</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 04', 'Asunto demo 04', '<p>Contenido demo 04</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 05', 'Asunto demo 05', '<p>Contenido demo 05</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 06', 'Asunto demo 06', '<p>Contenido demo 06</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 07', 'Asunto demo 07', '<p>Contenido demo 07</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 08', 'Asunto demo 08', '<p>Contenido demo 08</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 09', 'Asunto demo 09', '<p>Contenido demo 09</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 10', 'Asunto demo 10', '<p>Contenido demo 10</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 11', 'Asunto demo 11', '<p>Contenido demo 11</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 12', 'Asunto demo 12', '<p>Contenido demo 12</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 13', 'Asunto demo 13', '<p>Contenido demo 13</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 14', 'Asunto demo 14', '<p>Contenido demo 14</p>', 'info', 1, NOW(), NOW()),
(1, 'Template Demo 15', 'Asunto demo 15', '<p>Contenido demo 15</p>', 'info', 1, NOW(), NOW());

INSERT INTO email_queue (company_id, client_id, template_id, subject, body_html, type, status, scheduled_at, tries, last_error, created_at, updated_at) VALUES
(1, 1, NULL, 'Cola demo 01', '<p>Correo programado 01</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 2, NULL, 'Cola demo 02', '<p>Correo programado 02</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 3, NULL, 'Cola demo 03', '<p>Correo programado 03</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 4, NULL, 'Cola demo 04', '<p>Correo programado 04</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 5, NULL, 'Cola demo 05', '<p>Correo programado 05</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 6, NULL, 'Cola demo 06', '<p>Correo programado 06</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 7, NULL, 'Cola demo 07', '<p>Correo programado 07</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 8, NULL, 'Cola demo 08', '<p>Correo programado 08</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 9, NULL, 'Cola demo 09', '<p>Correo programado 09</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 10, NULL, 'Cola demo 10', '<p>Correo programado 10</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 11, NULL, 'Cola demo 11', '<p>Correo programado 11</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 12, NULL, 'Cola demo 12', '<p>Correo programado 12</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 13, NULL, 'Cola demo 13', '<p>Correo programado 13</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 14, NULL, 'Cola demo 14', '<p>Correo programado 14</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW()),
(1, 15, NULL, 'Cola demo 15', '<p>Correo programado 15</p>', 'info', 'pending', NOW(), 0, NULL, NOW(), NOW());

INSERT INTO email_logs (company_id, client_id, type, subject, body_html, status, error, created_at, updated_at) VALUES
(1, 1, 'info', 'Log 01', '<p>Log demo 01</p>', 'sent', NULL, NOW(), NOW()),
(1, 2, 'info', 'Log 02', '<p>Log demo 02</p>', 'sent', NULL, NOW(), NOW()),
(1, 3, 'info', 'Log 03', '<p>Log demo 03</p>', 'sent', NULL, NOW(), NOW()),
(1, 4, 'info', 'Log 04', '<p>Log demo 04</p>', 'sent', NULL, NOW(), NOW()),
(1, 5, 'info', 'Log 05', '<p>Log demo 05</p>', 'sent', NULL, NOW(), NOW()),
(1, 6, 'info', 'Log 06', '<p>Log demo 06</p>', 'sent', NULL, NOW(), NOW()),
(1, 7, 'info', 'Log 07', '<p>Log demo 07</p>', 'sent', NULL, NOW(), NOW()),
(1, 8, 'info', 'Log 08', '<p>Log demo 08</p>', 'sent', NULL, NOW(), NOW()),
(1, 9, 'info', 'Log 09', '<p>Log demo 09</p>', 'sent', NULL, NOW(), NOW()),
(1, 10, 'info', 'Log 10', '<p>Log demo 10</p>', 'sent', NULL, NOW(), NOW()),
(1, 11, 'info', 'Log 11', '<p>Log demo 11</p>', 'sent', NULL, NOW(), NOW()),
(1, 12, 'info', 'Log 12', '<p>Log demo 12</p>', 'sent', NULL, NOW(), NOW()),
(1, 13, 'info', 'Log 13', '<p>Log demo 13</p>', 'sent', NULL, NOW(), NOW()),
(1, 14, 'info', 'Log 14', '<p>Log demo 14</p>', 'sent', NULL, NOW(), NOW()),
(1, 15, 'info', 'Log 15', '<p>Log demo 15</p>', 'sent', NULL, NOW(), NOW());

INSERT INTO notifications (company_id, title, message, type, read_at, created_at, updated_at) VALUES
(1, 'Notificación 01', 'Mensaje demo 01', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 02', 'Mensaje demo 02', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 03', 'Mensaje demo 03', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 04', 'Mensaje demo 04', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 05', 'Mensaje demo 05', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 06', 'Mensaje demo 06', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 07', 'Mensaje demo 07', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 08', 'Mensaje demo 08', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 09', 'Mensaje demo 09', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 10', 'Mensaje demo 10', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 11', 'Mensaje demo 11', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 12', 'Mensaje demo 12', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 13', 'Mensaje demo 13', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 14', 'Mensaje demo 14', 'info', NULL, NOW(), NOW()),
(1, 'Notificación 15', 'Mensaje demo 15', 'info', NULL, NOW(), NOW());

INSERT INTO audit_logs (company_id, user_id, action, entity, entity_id, created_at) VALUES
(1, 1, 'create', 'clients', 1, NOW()),
(1, 1, 'create', 'clients', 2, NOW()),
(1, 1, 'create', 'clients', 3, NOW()),
(1, 1, 'create', 'clients', 4, NOW()),
(1, 1, 'create', 'clients', 5, NOW()),
(1, 1, 'create', 'clients', 6, NOW()),
(1, 1, 'create', 'clients', 7, NOW()),
(1, 1, 'create', 'clients', 8, NOW()),
(1, 1, 'create', 'clients', 9, NOW()),
(1, 1, 'create', 'clients', 10, NOW()),
(1, 1, 'create', 'clients', 11, NOW()),
(1, 1, 'create', 'clients', 12, NOW()),
(1, 1, 'create', 'clients', 13, NOW()),
(1, 1, 'create', 'clients', 14, NOW()),
(1, 1, 'create', 'clients', 15, NOW());
