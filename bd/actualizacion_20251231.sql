START TRANSACTION;

SET @company_id_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'service_types'
      AND COLUMN_NAME = 'company_id'
);

SET @sql := IF(
    @company_id_exists = 0,
    'ALTER TABLE service_types ADD COLUMN company_id INT NULL AFTER id;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE service_types
SET company_id = (SELECT id FROM companies ORDER BY id LIMIT 1)
WHERE company_id IS NULL;

SET @fk_service_types_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA = DATABASE()
      AND TABLE_NAME = 'service_types'
      AND CONSTRAINT_TYPE = 'FOREIGN KEY'
      AND CONSTRAINT_NAME = 'fk_service_types_company'
);

SET @sql := IF(
    @fk_service_types_exists = 0,
    'ALTER TABLE service_types MODIFY company_id INT NOT NULL, ADD CONSTRAINT fk_service_types_company FOREIGN KEY (company_id) REFERENCES companies(id);',
    'ALTER TABLE service_types MODIFY company_id INT NOT NULL;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @company_id_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'system_services'
      AND COLUMN_NAME = 'company_id'
);

SET @sql := IF(
    @company_id_exists = 0,
    'ALTER TABLE system_services ADD COLUMN company_id INT NULL AFTER id;',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE system_services
SET company_id = (SELECT id FROM companies ORDER BY id LIMIT 1)
WHERE company_id IS NULL;

SET @fk_system_services_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA = DATABASE()
      AND TABLE_NAME = 'system_services'
      AND CONSTRAINT_TYPE = 'FOREIGN KEY'
      AND CONSTRAINT_NAME = 'fk_system_services_company'
);

SET @sql := IF(
    @fk_system_services_exists = 0,
    'ALTER TABLE system_services MODIFY company_id INT NOT NULL, ADD CONSTRAINT fk_system_services_company FOREIGN KEY (company_id) REFERENCES companies(id);',
    'ALTER TABLE system_services MODIFY company_id INT NOT NULL;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS commercial_briefs (
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

CREATE TABLE IF NOT EXISTS sales_orders (
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

CREATE TABLE IF NOT EXISTS service_renewals (
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

CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NULL,
    tax_id VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    website VARCHAR(150) NULL,
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

ALTER TABLE suppliers
    ADD COLUMN IF NOT EXISTS contact_name VARCHAR(150) NULL AFTER name,
    ADD COLUMN IF NOT EXISTS tax_id VARCHAR(50) NULL AFTER contact_name,
    ADD COLUMN IF NOT EXISTS website VARCHAR(150) NULL AFTER address,
    ADD COLUMN IF NOT EXISTS notes TEXT NULL AFTER website;

CREATE TABLE IF NOT EXISTS product_families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE IF NOT EXISTS product_subfamilies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    family_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (family_id) REFERENCES product_families(id)
);

CREATE TABLE IF NOT EXISTS products (
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
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE IF NOT EXISTS purchases (
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

CREATE TABLE IF NOT EXISTS purchase_items (
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

CREATE TABLE IF NOT EXISTS pos_sessions (
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

CREATE TABLE IF NOT EXISTS sales (
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

CREATE TABLE IF NOT EXISTS sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NULL,
    service_id INT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

CREATE TABLE IF NOT EXISTS sale_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    method VARCHAR(50) NOT NULL,
    amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id)
);

SET @idx_products_company := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND INDEX_NAME = 'idx_products_company'
);
SET @sql := IF(@idx_products_company = 0, 'CREATE INDEX idx_products_company ON products(company_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @idx_products_supplier := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND INDEX_NAME = 'idx_products_supplier'
);
SET @sql := IF(@idx_products_supplier = 0, 'CREATE INDEX idx_products_supplier ON products(supplier_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @family_exists := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'products'
      AND COLUMN_NAME = 'family_id'
);
SET @sql := IF(@family_exists = 0, 'ALTER TABLE products ADD COLUMN family_id INT NULL AFTER supplier_id;', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @subfamily_exists := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'products'
      AND COLUMN_NAME = 'subfamily_id'
);
SET @sql := IF(@subfamily_exists = 0, 'ALTER TABLE products ADD COLUMN subfamily_id INT NULL AFTER family_id;', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @idx_purchases_company := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'purchases' AND INDEX_NAME = 'idx_purchases_company'
);
SET @sql := IF(@idx_purchases_company = 0, 'CREATE INDEX idx_purchases_company ON purchases(company_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @idx_sales_company := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sales' AND INDEX_NAME = 'idx_sales_company'
);
SET @sql := IF(@idx_sales_company = 0, 'CREATE INDEX idx_sales_company ON sales(company_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @idx_product_families_company := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'product_families' AND INDEX_NAME = 'idx_product_families_company'
);
SET @sql := IF(@idx_product_families_company = 0, 'CREATE INDEX idx_product_families_company ON product_families(company_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @idx_product_subfamilies_company := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'product_subfamilies' AND INDEX_NAME = 'idx_product_subfamilies_company'
);
SET @sql := IF(@idx_product_subfamilies_company = 0, 'CREATE INDEX idx_product_subfamilies_company ON product_subfamilies(company_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @idx_pos_sessions_company_user := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pos_sessions' AND INDEX_NAME = 'idx_pos_sessions_company_user'
);
SET @sql := IF(@idx_pos_sessions_company_user = 0, 'CREATE INDEX idx_pos_sessions_company_user ON pos_sessions(company_id, user_id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sale_pos_col := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sales' AND COLUMN_NAME = 'pos_session_id'
);
SET @sql := IF(@sale_pos_col = 0, 'ALTER TABLE sales ADD COLUMN pos_session_id INT NULL AFTER client_id, ADD CONSTRAINT fk_sales_pos_session FOREIGN KEY (pos_session_id) REFERENCES pos_sessions(id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sale_items_service_col := (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sale_items' AND COLUMN_NAME = 'service_id'
);
SET @sql := IF(@sale_items_service_col = 0, 'ALTER TABLE sale_items ADD COLUMN service_id INT NULL AFTER product_id, MODIFY product_id INT NULL, ADD CONSTRAINT fk_sale_items_service FOREIGN KEY (service_id) REFERENCES services(id);', 'SELECT 1;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS hr_departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE IF NOT EXISTS hr_positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE IF NOT EXISTS hr_contract_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    max_duration_months INT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE IF NOT EXISTS hr_work_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    weekly_hours INT NOT NULL DEFAULT 45,
    start_time TIME NULL,
    end_time TIME NULL,
    lunch_break_minutes INT NOT NULL DEFAULT 60,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE IF NOT EXISTS hr_payroll_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    item_type VARCHAR(20) NOT NULL DEFAULT 'haber',
    taxable TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE IF NOT EXISTS hr_employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    department_id INT NULL,
    position_id INT NULL,
    rut VARCHAR(50) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    hire_date DATE NOT NULL,
    termination_date DATE NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'activo',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (department_id) REFERENCES hr_departments(id),
    FOREIGN KEY (position_id) REFERENCES hr_positions(id)
);

CREATE TABLE IF NOT EXISTS hr_contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    contract_type_id INT NULL,
    department_id INT NULL,
    position_id INT NULL,
    schedule_id INT NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    salary DECIMAL(12,2) NOT NULL,
    weekly_hours INT NOT NULL DEFAULT 45,
    status VARCHAR(20) NOT NULL DEFAULT 'vigente',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (employee_id) REFERENCES hr_employees(id),
    FOREIGN KEY (contract_type_id) REFERENCES hr_contract_types(id),
    FOREIGN KEY (department_id) REFERENCES hr_departments(id),
    FOREIGN KEY (position_id) REFERENCES hr_positions(id),
    FOREIGN KEY (schedule_id) REFERENCES hr_work_schedules(id)
);

CREATE TABLE IF NOT EXISTS hr_attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    check_in TIME NULL,
    check_out TIME NULL,
    worked_hours DECIMAL(5,2) NULL,
    overtime_hours DECIMAL(5,2) NOT NULL DEFAULT 0,
    absence_type VARCHAR(100) NULL,
    notes VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (employee_id) REFERENCES hr_employees(id)
);

CREATE TABLE IF NOT EXISTS hr_payrolls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    base_salary DECIMAL(12,2) NOT NULL,
    bonuses DECIMAL(12,2) NOT NULL DEFAULT 0,
    deductions DECIMAL(12,2) NOT NULL DEFAULT 0,
    net_pay DECIMAL(12,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'borrador',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (employee_id) REFERENCES hr_employees(id)
);

CREATE TABLE IF NOT EXISTS hr_payroll_lines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payroll_id INT NOT NULL,
    payroll_item_id INT NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (payroll_id) REFERENCES hr_payrolls(id),
    FOREIGN KEY (payroll_item_id) REFERENCES hr_payroll_items(id)
);

COMMIT;
