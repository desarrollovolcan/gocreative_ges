<?php

class SettingsModel extends Model
{
    protected string $table = 'settings';

    public function get(string $key, $default = null)
    {
        $row = $this->db->fetch('SELECT value FROM settings WHERE `key` = :key', ['key' => $key]);
        if (!$row) {
            return $default;
        }
        $value = json_decode($row['value'], true);
        return $value === null ? $row['value'] : $value;
    }

    public function set(string $key, $value): void
    {
        $payload = is_array($value) ? json_encode($value) : $value;
        $exists = $this->db->fetch('SELECT id FROM settings WHERE `key` = :key', ['key' => $key]);
        if ($exists) {
            $this->db->execute('UPDATE settings SET value = :value, updated_at = NOW() WHERE `key` = :key', [
                'value' => $payload,
                'key' => $key,
            ]);
        } else {
            $this->db->execute('INSERT INTO settings (`key`, value, created_at, updated_at) VALUES (:key, :value, NOW(), NOW())', [
                'key' => $key,
                'value' => $payload,
            ]);
        }
    }
}
