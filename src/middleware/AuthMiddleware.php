<?php
namespace App\Middleware;

use App\Helpers\SessionHelper;
use App\Helpers\ResponseHelper;

class AuthMiddleware {
    /**
     * Require an authenticated session.
     * Optionally restrict to one or more roles.
     *
     * Usage:
     *   AuthMiddleware::require();                        // any logged-in user
     *   AuthMiddleware::require(['admin']);                // admin only
     *   AuthMiddleware::require(['faculty', 'admin']);    // faculty OR admin
     */
    public static function require(array $roles = []): void {
        if (!SessionHelper::isLoggedIn()) {
            SessionHelper::flash('error', 'You must be logged in to access this page.');
            ResponseHelper::redirect('/login');
            exit;
        }

        if (!empty($roles) && !in_array(SessionHelper::userRole(), $roles, true)) {
            http_response_code(403);
            require_once ROOT_PATH . '/views/shared/403.php';
            exit;
        }
    }

    /** Prevent logged-in users from accessing guest-only pages (e.g. login) */
    public static function guest(): void {
        if (SessionHelper::isLoggedIn()) {
            ResponseHelper::redirect(SessionHelper::dashboardUrl());
            exit;
        }
    }
}
