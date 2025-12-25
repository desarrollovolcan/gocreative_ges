<?php

class InvoicesModel extends Model
{
    protected string $table = 'invoices';

    public function allWithClient(): array
    {
        return $this->db->fetchAll('SELECT invoices.*, clients.name as client_name FROM invoices JOIN clients ON invoices.client_id = clients.id WHERE invoices.deleted_at IS NULL ORDER BY invoices.id DESC');
    }

    public function nextNumber(string $prefix): string
    {
        $row = $this->db->fetch('SELECT MAX(id) as max_id FROM invoices');
        $next = (int)($row['max_id'] ?? 0) + 1;
        return $prefix . str_pad((string)$next, 6, '0', STR_PAD_LEFT);
    }
}
