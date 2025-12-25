<?php

class EmailQueueModel extends Model
{
    protected string $table = 'email_queue';

    public function pending(): array
    {
        return $this->db->fetchAll('SELECT * FROM email_queue WHERE status = "pending" ORDER BY scheduled_at ASC');
    }
}
