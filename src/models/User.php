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

    
