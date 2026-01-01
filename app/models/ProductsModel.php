<?php

class ProductsModel extends Model
{
    protected string $table = 'products';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT p.*, s.name AS supplier_name
             FROM products p
             LEFT JOIN suppliers s ON p.supplier_id = s.id
             WHERE p.company_id = :company_id AND p.deleted_at IS NULL
             ORDER BY p.name ASC',
            ['company_id' => $companyId]
        );
    }

    public function findForCompany(int $id, int $companyId): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM products WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $id, 'company_id' => $companyId]
        );
    }

    public function adjustStock(int $id, int $difference): void
    {
        $this->db->execute(
            'UPDATE products SET stock = GREATEST(0, stock + :difference), updated_at = NOW() WHERE id = :id',
            [
                'difference' => $difference,
                'id' => $id,
            ]
        );
    }
}
