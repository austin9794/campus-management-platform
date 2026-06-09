<?php
namespace App\Helpers;

class SessionHelper {
    public static function isLoggedIn(): bool {
        return !empty($_SESSION['user_id']);
    }

    public static function userId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public static function userRole(): ?string {
        return $_SESSION['role'] ?? null;
    }

    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public static function dashboardUrl(): string {
        return match (self::userRole()) {
            'admin'   => '/admin/dashboard',
            'faculty' => '/faculty/dashboard',
            'student' => '/student/dashboard',
            default   => '/login',
        };
    }

    public static function flash(string $key, mixed $value): void {
        $_SESSION['flash'][$key] = $value;
    }

    public static function getFlash(string $key): mixed {
        $val = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $val;
    }

    public static function destroy(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }
}