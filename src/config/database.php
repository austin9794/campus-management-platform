<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function connect(): PDO {
        if (self::$instance === null) {
            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_DRIVER'] ?? 'mysql',
                $_ENV['DB_HOST']   ?? '127.0.0.1',
                $_ENV['DB_PORT']   ?? '3306',
                $_ENV['DB_NAME']   ?? 'campus_db'
            );
            try {
                self::$instance = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                // Log and die — never expose raw DB errors
                error_log('DB connection failed: ' . $e->getMessage());
                http_response_code(500);
                die(json_encode(['error' => 'Database connection failed.']));
            }
        }
        return self::$instance;
    }

    /** Run a query with bound parameters and return all rows */
    public static function query(string $sql, array $params = []): array {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Run a query and return a single row */
    public static function queryOne(string $sql, array $params = []): ?array {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Execute INSERT / UPDATE / DELETE and return affected rows */
    public static function execute(string $sql, array $params = []): int {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /** Return the last inserted ID */
    public static function lastInsertId(): string {
        return self::connect()->lastInsertId();
    }

    public static function beginTransaction(): void  { self::connect()->beginTransaction(); }
    public static function commit(): void             { self::connect()->commit(); }
    public static function rollback(): void           { self::connect()->rollBack(); }
}
