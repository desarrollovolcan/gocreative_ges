<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct(array $config)
    {
        $socket = $config['socket'] ?? '';
        $host = $config['host'] ?? 'localhost';
        $port = (int)($config['port'] ?? 3306);
        $charset = $config['charset'] ?? 'utf8mb4';
        $name = $config['name'];
        $user = $config['user'];
        $pass = $config['pass'];

        $this->pdo = null;
        if (!empty($socket)) {
            $this->pdo = $this->connectSocket($socket, $name, $charset, $user, $pass);
        }
        if (!$this->pdo) {
            $this->pdo = $this->connect($host, $port, $name, $charset, $user, $pass);
        }
        if (!$this->pdo && $host === 'localhost') {
            // Fallback to TCP to avoid socket issues on some setups.
            $this->pdo = $this->connect('127.0.0.1', $port, $name, $charset, $user, $pass, true);
        }
        if (!$this->pdo) {
            throw new PDOException('Unable to establish database connection.');
        }
    }

    public static function getInstance(array $config): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database($config);
        }

        return self::$instance;
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    private function connect(string $host, int $port, string $name, string $charset, string $user, string $pass, bool $isFallback = false): ?PDO
    {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $host, $port, $name, $charset);
        try {
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            $tag = $isFallback ? 'fallback' : 'primary';
            log_message('error', sprintf('DB %s connection failed (%s): %s', $tag, $host, $e->getMessage()));
            return null;
        }
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    private function connectSocket(string $socket, string $name, string $charset, string $user, string $pass): ?PDO
    {
        $dsn = sprintf('mysql:unix_socket=%s;dbname=%s;charset=%s', $socket, $name, $charset);
        try {
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            log_message('error', sprintf('DB socket connection failed (%s): %s', $socket, $e->getMessage()));
            return null;
        }
    }
}
