CREATE DATABASE IF NOT EXISTS gocreative_ges CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gocreative_ges;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    signature TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    portal_token VARCHAR(64) NULL,
    portal_password VARCHAR(255) NULL,
    notes TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE project_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

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
    name VARCHAR(150) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'cobranza',
    created_by INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL
);

CREATE TABLE email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (template_id) REFERENCES email_templates(id)
);

CREATE TABLE email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NULL,
    type VARCHAR(20) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    status VARCHAR(20) NOT NULL,
    error TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    value MEDIUMTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(20) NOT NULL,
    read_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    entity VARCHAR(50) NOT NULL,
    entity_id INT NULL,
    created_at DATETIME NOT NULL
);

CREATE INDEX idx_clients_status ON clients(status);
CREATE UNIQUE INDEX idx_clients_portal_token ON clients(portal_token);
CREATE INDEX idx_services_status ON services(status);
CREATE INDEX idx_services_due_date ON services(due_date);
CREATE INDEX idx_invoices_estado ON invoices(estado);
CREATE INDEX idx_invoices_numero ON invoices(numero);
CREATE INDEX idx_email_queue_status ON email_queue(status);

INSERT INTO roles (name, created_at, updated_at) VALUES
('admin', NOW(), NOW()),
('operador', NOW(), NOW());

INSERT INTO users (name, email, password, role_id, created_at, updated_at) VALUES
('E Isla', 'eisla@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 1, NOW(), NOW());

INSERT INTO settings (`key`, value, created_at, updated_at) VALUES
('company', '{"name":"GoCreative","rut":"","bank":"","account_type":"","account_number":"","email":"contacto@gocreative.cl","signature":"Saludos"}', NOW(), NOW()),
('billing_defaults', '{"notice_days_1":15,"notice_days_2":5,"send_time":"09:00","timezone":"America/Santiago","invoice_prefix":"FAC-"}', NOW(), NOW()),
('invoice_prefix', 'FAC-', NOW(), NOW()),
('smtp_cobranza', '{"host":"mail.gocreative.cl","port":465,"security":"ssl","username":"cobranza@gocreative.cl","password":"O38LP_3c?GefV6z&","from_name":"Cobranza","from_email":"cobranza@gocreative.cl","reply_to":"cobranza@gocreative.cl"}', NOW(), NOW()),
('smtp_info', '{"host":"mail.gocreative.cl","port":465,"security":"ssl","username":"informevolcan@gocreative.cl","password":"#(3-QiWGI;l}oJW_","from_name":"Información","from_email":"informevolcan@gocreative.cl","reply_to":"informevolcan@gocreative.cl"}', NOW(), NOW());

INSERT INTO email_templates (name, subject, body_html, type, created_by, created_at, updated_at) VALUES
('Registro de servicio', 'Registro del servicio con éxito', '<p>&nbsp;</p>
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
('Cobranza 15 días', 'Primer aviso: vence en 15 días', '<p>&nbsp;</p>
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
('Cobranza 10 días', 'Segundo aviso: vence en 10 días', '<p>&nbsp;</p>
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
('Cobranza 5 días', 'Tercer aviso: vence en 5 días', '<p>&nbsp;</p>
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
('Servicio suspendido', 'Servicio suspendido por vencimiento', '<p>&nbsp;</p>
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
