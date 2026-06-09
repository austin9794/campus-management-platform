<?php
namespace App\Controllers;

use App\Models\User;
use App\Services\AuthService;
use App\Helpers\SessionHelper;
use App\Helpers\ValidationHelper;
use App\Helpers\ResponseHelper;
use App\Services\EmailService;

class AuthController {
    /** GET /login */
    public static function showLogin(): void {
        if (SessionHelper::isLoggedIn()) {
            ResponseHelper::redirect(SessionHelper::dashboardUrl());
        }
        require_once ROOT_PATH . '/views/auth/login.php';
    }

    /** POST /login */
    public static function login(): void {
        $email    = filter_input(INPUT_POST, 'email',    FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

        $errors = ValidationHelper::validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], ['email' => $email, 'password' => $password]);

        if ($errors) {
            SessionHelper::flash('errors', $errors);
            ResponseHelper::redirect('/login');
            return;
        }

        $user = User::findByEmail($email);

        if (!$user || !User::verifyPassword($password, $user['password_hash'])) {
            SessionHelper::flash('error', 'Invalid email or password.');
            ResponseHelper::redirect('/login');
            return;
        }

        if (!$user['is_active']) {
            SessionHelper::flash('error', 'Your account has been deactivated. Contact support.');
            ResponseHelper::redirect('/login');
            return;
        }

        AuthService::createSession($user);
        ResponseHelper::redirect(SessionHelper::dashboardUrl());
    }

    /** POST /logout */
    public static function logout(): void {
        AuthService::destroySession();
        ResponseHelper::redirect('/login');
    }

    /** GET /forgot-password */
    public static function showForgotPassword(): void {
        require_once ROOT_PATH . '/views/auth/forgot-password.php';
    }

    /** POST /forgot-password */
    public static function forgotPassword(): void {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $user  = User::findByEmail($email);

        // Always show success to prevent email enumeration
        if ($user) {
            $token = bin2hex(random_bytes(32));
            User::saveResetToken($user['id'], $token);
            EmailService::sendPasswordReset($user['email'], $user['name'], $token);
        }

        SessionHelper::flash('success', 'If that email exists, a reset link has been sent.');
        ResponseHelper::redirect('/forgot-password');
    }

    /** GET /reset-password?token=xxx */
    public static function showResetPassword(): void {
        $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
        $user  = User::findByResetToken($token);
        if (!$user) {
            SessionHelper::flash('error', 'This reset link is invalid or has expired.');
            ResponseHelper::redirect('/forgot-password');
            return;
        }
        require_once ROOT_PATH . '/views/auth/reset-password.php';
    }

    /** POST /reset-password */
    public static function resetPassword(): void {
        $token    = filter_input(INPUT_POST, 'token',    FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
        $confirm  = filter_input(INPUT_POST, 'confirm',  FILTER_DEFAULT);

        $user = User::findByResetToken($token);
        if (!$user || $password !== $confirm || strlen($password) < 8) {
            SessionHelper::flash('error', 'Invalid request or passwords do not match (min 8 chars).');
            ResponseHelper::redirect('/reset-password?token=' . urlencode($token));
            return;
        }

        User::updatePassword($user['id'], $password);
        SessionHelper::flash('success', 'Password updated. Please log in.');
        ResponseHelper::redirect('/login');
    }
}





