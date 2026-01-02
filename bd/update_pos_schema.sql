-- Actualización segura para habilitar el POS.
-- Crea tablas y columnas requeridas solo si faltan.

START TRANSACTION;

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
    deleted_at DATETIME NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
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

ALTER TABLE sales
    ADD COLUMN IF NOT EXISTS pos_session_id INT NULL AFTER client_id;

SET @has_fk_pos := (
    SELECT COUNT(*)
    FROM information_schema.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'sales'
      AND CONSTRAINT_NAME = 'fk_sales_pos_session'
);
SET @sql := IF(
    @has_fk_pos = 0,
    'ALTER TABLE sales ADD CONSTRAINT fk_sales_pos_session FOREIGN KEY (pos_session_id) REFERENCES pos_sessions(id);',
    'SELECT 1;'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE INDEX IF NOT EXISTS idx_pos_sessions_company_user ON pos_sessions(company_id, user_id);

COMMIT;
