<?php

class UsersModel extends Model
{
    protected string $table = 'users';

    public function allActive(): array
    {
        return $this->db->fetchAll('SELECT users.*, roles.name as role FROM users JOIN roles ON users.role_id = roles.id WHERE users.deleted_at IS NULL ORDER BY users.id DESC');
    }
}
