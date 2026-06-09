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
