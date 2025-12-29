<?php

class QuotesModel extends Model
{
    protected string $table = 'quotes';

    public function allWithClient(): array
    {
        return $this->db->fetchAll('SELECT quotes.*, clients.name as client_name FROM quotes JOIN clients ON quotes.client_id = clients.id ORDER BY quotes.id DESC');
    }

    public function nextNumber(string $prefix): string
    {
        $row = $this->db->fetch('SELECT MAX(id) as max_id FROM quotes');
        $next = (int)($row['max_id'] ?? 0) + 1;
        return $prefix . str_pad((string)$next, 6, '0', STR_PAD_LEFT);
    }
}
