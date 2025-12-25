<?php

class ClientsModel extends Model
{
    protected string $table = 'clients';

    public function active(): array
    {
        return $this->db->fetchAll('SELECT * FROM clients WHERE deleted_at IS NULL ORDER BY id DESC');
    }
}
