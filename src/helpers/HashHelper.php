<?php
namespace App\Helpers;

class HashHelper {
    public static function make(string $value): string {
        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verify(string $value, string $hash): bool {
        return password_verify($value, $hash);
    }

    public static function token(int $bytes = 32): string {
        return bin2hex(random_bytes($bytes));
    }

    public static function sha256(string $value): string {
        return hash('sha256', $value);
    }
}
