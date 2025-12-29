<?php

class ChatModel
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getThreadsForAdmin(): array
    {
        return $this->db->fetchAll(
            'SELECT chat_threads.*,
                    clients.name AS client_name,
                    clients.email AS client_email,
                    latest.message AS last_message,
                    latest.created_at AS last_message_at
             FROM chat_threads
             JOIN clients ON chat_threads.client_id = clients.id
             LEFT JOIN (
                 SELECT thread_id, message, created_at
                 FROM chat_messages
                 WHERE id IN (
                     SELECT MAX(id) FROM chat_messages GROUP BY thread_id
                 )
             ) AS latest ON latest.thread_id = chat_threads.id
             ORDER BY chat_threads.updated_at DESC'
        );
    }

    public function getThreadsForClient(int $clientId): array
    {
        return $this->db->fetchAll(
            'SELECT chat_threads.*,
                    latest.message AS last_message,
                    latest.created_at AS last_message_at
             FROM chat_threads
             LEFT JOIN (
                 SELECT thread_id, message, created_at
                 FROM chat_messages
                 WHERE id IN (
                     SELECT MAX(id) FROM chat_messages GROUP BY thread_id
                 )
             ) AS latest ON latest.thread_id = chat_threads.id
             WHERE chat_threads.client_id = :client_id
             ORDER BY chat_threads.updated_at DESC',
            ['client_id' => $clientId]
        );
    }

    public function getThread(int $threadId): ?array
    {
        return $this->db->fetch(
            'SELECT chat_threads.*, clients.name AS client_name, clients.email AS client_email
             FROM chat_threads
             JOIN clients ON chat_threads.client_id = clients.id
             WHERE chat_threads.id = :id',
            ['id' => $threadId]
        );
    }

    public function getThreadForClient(int $threadId, int $clientId): ?array
    {
        return $this->db->fetch(
            'SELECT chat_threads.*
             FROM chat_threads
             WHERE chat_threads.id = :id AND chat_threads.client_id = :client_id',
            ['id' => $threadId, 'client_id' => $clientId]
        );
    }

    public function getMessages(int $threadId): array
    {
        return $this->db->fetchAll(
            'SELECT chat_messages.*,
                    CASE
                        WHEN chat_messages.sender_type = "user" THEN users.name
                        ELSE clients.name
                    END AS sender_name
             FROM chat_messages
             LEFT JOIN users ON chat_messages.sender_type = "user" AND chat_messages.sender_id = users.id
             LEFT JOIN clients ON chat_messages.sender_type = "client" AND chat_messages.sender_id = clients.id
             WHERE chat_messages.thread_id = :thread_id
             ORDER BY chat_messages.created_at ASC',
            ['thread_id' => $threadId]
        );
    }

    public function createThread(int $clientId, string $subject): int
    {
        $now = date('Y-m-d H:i:s');
        $this->db->execute(
            'INSERT INTO chat_threads (client_id, subject, status, created_at, updated_at)
             VALUES (:client_id, :subject, :status, :created_at, :updated_at)',
            [
                'client_id' => $clientId,
                'subject' => $subject,
                'status' => 'abierto',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        return (int)$this->db->lastInsertId();
    }

    public function addMessage(int $threadId, string $senderType, int $senderId, string $message): void
    {
        $now = date('Y-m-d H:i:s');
        $this->db->execute(
            'INSERT INTO chat_messages (thread_id, sender_type, sender_id, message, created_at)
             VALUES (:thread_id, :sender_type, :sender_id, :message, :created_at)',
            [
                'thread_id' => $threadId,
                'sender_type' => $senderType,
                'sender_id' => $senderId,
                'message' => $message,
                'created_at' => $now,
            ]
        );
        $this->db->execute(
            'UPDATE chat_threads SET updated_at = :updated_at WHERE id = :id',
            ['updated_at' => $now, 'id' => $threadId]
        );
    }
}
