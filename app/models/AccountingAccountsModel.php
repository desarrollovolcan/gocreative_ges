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
}
