<?php

class HrEmployeesModel extends Model
{
    protected string $table = 'hr_employees';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT e.*, d.name AS department_name, p.name AS position_name
             FROM hr_employees e
             LEFT JOIN hr_departments d ON e.department_id = d.id
             LEFT JOIN hr_positions p ON e.position_id = p.id
             WHERE e.company_id = :company_id AND e.deleted_at IS NULL
             ORDER BY e.last_name ASC, e.first_name ASC',
            ['company_id' => $companyId]
        );
    }

    public function findForCompany(int $id, int $companyId): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM hr_employees WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $id, 'company_id' => $companyId]
        );
    }
}
