<?php

class HrAttendanceModel extends Model
{
    protected string $table = 'hr_attendance';

    public function byCompany(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT a.*, e.rut, e.first_name, e.last_name
             FROM hr_attendance a
             INNER JOIN hr_employees e ON a.employee_id = e.id
             WHERE a.company_id = :company_id
             ORDER BY a.date DESC, a.check_in DESC',
            ['company_id' => $companyId]
        );
    }

    public function findForCompany(int $id, int $companyId): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM hr_attendance WHERE id = :id AND company_id = :company_id',
            ['id' => $id, 'company_id' => $companyId]
        );
    }
}
