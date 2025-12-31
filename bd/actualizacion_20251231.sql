START TRANSACTION;

ALTER TABLE service_types
    ADD COLUMN company_id INT NULL AFTER id;

UPDATE service_types
SET company_id = (SELECT id FROM companies ORDER BY id LIMIT 1)
WHERE company_id IS NULL;

ALTER TABLE service_types
    MODIFY company_id INT NOT NULL,
    ADD CONSTRAINT fk_service_types_company
        FOREIGN KEY (company_id) REFERENCES companies(id);

ALTER TABLE system_services
    ADD COLUMN company_id INT NULL AFTER id;

UPDATE system_services
SET company_id = (SELECT id FROM companies ORDER BY id LIMIT 1)
WHERE company_id IS NULL;

ALTER TABLE system_services
    MODIFY company_id INT NOT NULL,
    ADD CONSTRAINT fk_system_services_company
        FOREIGN KEY (company_id) REFERENCES companies(id);

COMMIT;
