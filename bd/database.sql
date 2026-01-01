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

CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE product_families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE product_subfamilies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    family_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (family_id) REFERENCES product_families(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    supplier_id INT NULL,
    family_id INT NULL,
    subfamily_id INT NULL,
    name VARCHAR(150) NOT NULL,
    sku VARCHAR(100) NULL,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    cost DECIMAL(12,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    stock_min INT NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
    FOREIGN KEY (family_id) REFERENCES product_families(id),
    FOREIGN KEY (subfamily_id) REFERENCES product_subfamilies(id)
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
    company_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE system_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    service_type_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    cost DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (service_type_id) REFERENCES service_types(id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
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

CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    supplier_id INT NOT NULL,
    reference VARCHAR(100) NULL,
    purchase_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE purchase_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (purchase_id) REFERENCES purchases(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE pos_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    user_id INT NOT NULL,
    opening_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    closing_amount DECIMAL(12,2) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'abierto',
    opened_at DATETIME NOT NULL,
    closed_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NULL,
    pos_session_id INT NULL,
    channel VARCHAR(20) NOT NULL DEFAULT 'venta',
    numero VARCHAR(50) NOT NULL,
    sale_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pagado',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (pos_session_id) REFERENCES pos_sessions(id)
);

CREATE TABLE sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE sale_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    method VARCHAR(50) NOT NULL,
    amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id)
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

CREATE TABLE commercial_briefs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NULL,
    contact_email VARCHAR(150) NULL,
    contact_phone VARCHAR(50) NULL,
    service_summary VARCHAR(150) NULL,
    expected_budget DECIMAL(12,2) NULL,
    desired_start_date DATE NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'nuevo',
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE sales_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    brief_id INT NULL,
    order_number VARCHAR(50) NOT NULL,
    order_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    total DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (brief_id) REFERENCES commercial_briefs(id)
);

CREATE TABLE service_renewals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    client_id INT NOT NULL,
    service_id INT NULL,
    renewal_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'CLP',
    reminder_days INT NOT NULL DEFAULT 15,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
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
CREATE INDEX idx_product_families_company ON product_families(company_id);
CREATE INDEX idx_product_subfamilies_company ON product_subfamilies(company_id);
CREATE INDEX idx_products_company ON products(company_id);
CREATE INDEX idx_products_supplier ON products(supplier_id);
CREATE INDEX idx_purchases_company ON purchases(company_id);
CREATE INDEX idx_sales_company ON sales(company_id);
CREATE INDEX idx_pos_sessions_company_user ON pos_sessions(company_id, user_id);

INSERT INTO roles (name, created_at, updated_at) VALUES
('admin', NOW(), NOW());

INSERT INTO companies (name, rut, email, created_at, updated_at) VALUES
('GoCreative', '', 'contacto@gocreative.cl', NOW(), NOW());

INSERT INTO users (company_id, name, email, password, role_id, created_at, updated_at) VALUES
(1, 'E Isla', 'eisla@gocreative.cl', '$2y$12$Aa7Lucu.iaa3mUMBZjxAyO96KI0d6yNaKuOD/Rdru1FsOhn9Kmtga', 1, NOW(), NOW());

INSERT INTO user_companies (user_id, company_id, created_at) VALUES
(1, 1, NOW());
