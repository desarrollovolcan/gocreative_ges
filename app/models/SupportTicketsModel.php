<?php

class SupportTicketsModel extends Model
{
    protected string $table = 'support_tickets';

    public function allWithClient(): array
    {
        return $this->db->fetchAll(
            'SELECT support_tickets.*,
                    clients.name AS client_name
             FROM support_tickets
             JOIN clients ON support_tickets.client_id = clients.id
             ORDER BY support_tickets.updated_at DESC'
        );
    }

    public function findWithClient(int $id): ?array
    {
        return $this->db->fetch(
            'SELECT support_tickets.*,
                    clients.name AS client_name,
                    clients.email AS client_email
             FROM support_tickets
             JOIN clients ON support_tickets.client_id = clients.id
             WHERE support_tickets.id = :id',
            ['id' => $id]
        );
    }

    public function forClient(int $clientId): array
    {
        return $this->db->fetchAll(
            'SELECT *
             FROM support_tickets
             WHERE client_id = :client_id
             ORDER BY updated_at DESC',
            ['client_id' => $clientId]
        );
    }
}
