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



