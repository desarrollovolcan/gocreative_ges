<?php

class SystemServicesModel extends Model
{
    protected string $table = 'system_services';

    public function allWithType(): array
    {
        return $this->db->fetchAll(
            'SELECT system_services.*, service_types.name as type_name FROM system_services JOIN service_types ON system_services.service_type_id = service_types.id ORDER BY system_services.id DESC'
        );
    }
}
