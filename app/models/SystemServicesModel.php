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

    public function popularHostingAndDomain(int $limit = 10): array
    {
        return $this->db->fetchAll(
            'SELECT system_services.*, service_types.name as type_name
             FROM system_services
             JOIN service_types ON system_services.service_type_id = service_types.id
             WHERE LOWER(service_types.name) IN ("hosting", "dominio")
             ORDER BY system_services.id DESC
             LIMIT :limit',
            ['limit' => $limit]
        );
    }
}
