<?php

class ServicesModel extends Model
{
    protected string $table = 'services';

    public function active(): array
    {
        return $this->db->fetchAll('SELECT services.*, clients.name as client_name FROM services JOIN clients ON services.client_id = clients.id WHERE services.deleted_at IS NULL ORDER BY services.id DESC');
    }
}
