<?php

class AccountingAccountsModel extends Model
{
    protected string $table = 'accounting_accounts';

    public function byCompany(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM accounting_accounts WHERE company_id = :company_id ORDER BY code ASC',
            ['company_id' => $companyId]
        );
    }

    public function byParent(int $companyId, int $parentId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM accounting_accounts WHERE company_id = :company_id AND parent_id = :parent_id ORDER BY code ASC',
            ['company_id' => $companyId, 'parent_id' => $parentId]
        );
    }

    public function findByCode(int $companyId, string $code, ?int $excludeId = null): ?array
    {
        $sql = 'SELECT * FROM accounting_accounts WHERE company_id = :company_id AND code = :code';
        $params = ['company_id' => $companyId, 'code' => $code];
        if ($excludeId !== null) {
            $sql .= ' AND id != :exclude_id';
            $params['exclude_id'] = $excludeId;
        }
        return $this->db->fetch($sql, $params);
    }
}
