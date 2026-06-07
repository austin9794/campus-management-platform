<?php
namespace App\Services;

use App\Helpers\SessionHelper;

class AuthService {
    public static function createSession(array $user): void {
        session_regenerate_id(true); // prevent session fixation
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['user']    = [
            'id'     => $user['id'],
            'name'   => $user['name'],
            'email'  => $user['email'],
            'role'   => $user['role'],
            'avatar' => $user['avatar'] ?? null,
        ];
    }

    public static function destroySession(): void {
        SessionHelper::destroy();
    }
}
