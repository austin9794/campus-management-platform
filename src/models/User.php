<?php
namespace App\Models;

use App\Config\Database;

class User {
    // ── Finders ──────────────────────────────────────────────────────────────
    public static function findById(int $id): ?array {
        return Database::queryOne(
            'SELECT id, name, email, role, avatar, is_active, created_at FROM users WHERE id = ?',
            [$id]
        );
    }

    public static function findByEmail(string $email): ?array {
        return Database::queryOne(
            'SELECT * FROM users WHERE email = ?',
            [strtolower(trim($email))]
        );
    }

    // ── Auth ──────────────────────────────────────────────────────────────────
    public static function create(array $data): int {
        Database::execute(
            'INSERT INTO users (name, email, password_hash, role, created_at)
             VALUES (?, ?, ?, ?, NOW())',
            [
                $data['name'],
                strtolower(trim($data['email'])),
                password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
                $data['role'],
            ]
        );
        return (int) Database::lastInsertId();
    }

    public static function verifyPassword(string $plain, string $hash): bool {
        return password_verify($plain, $hash);
    }

    public static function updatePassword(int $id, string $newPassword): void {
        Database::execute(
            'UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?',
            [password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]), $id]
        );
    }

    // ── Tokens ────────────────────────────────────────────────────────────────
    public static function saveResetToken(int $id, string $token): void {
        Database::execute(
            'UPDATE users SET reset_token = ?, reset_token_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?',
            [hash('sha256', $token), $id]
        );
    }

    public static function findByResetToken(string $token): ?array {
        return Database::queryOne(
            'SELECT * FROM users WHERE reset_token = ? AND reset_token_expires > NOW()',
            [hash('sha256', $token)]
        );
    }

    // ── Status ───────────────────────────────────────────────────────────────
    public static function setActive(int $id, bool $active): void {
        Database::execute(
            'UPDATE users SET is_active = ? WHERE id = ?',
            [(int) $active, $id]
        );
    }

    // ── Listing ───────────────────────────────────────────────────────────────
    public static function all(string $role = null, int $page = 1, int $perPage = 20): array {
        $offset = ($page - 1) * $perPage;
        $where  = $role ? 'WHERE role = ?' : '';
        $params = $role ? [$role, $perPage, $offset] : [$perPage, $offset];
        return Database::query(
            "SELECT id, name, email, role, is_active, created_at FROM users $where
             ORDER BY created_at DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public static function count(string $role = null): int {
        $where  = $role ? 'WHERE role = ?' : '';
        $params = $role ? [$role] : [];
        $row    = Database::queryOne("SELECT COUNT(*) AS cnt FROM users $where", $params);
        return (int) ($row['cnt'] ?? 0);
    }
}






