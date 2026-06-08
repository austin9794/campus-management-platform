<?php
/**
 * REST API Router — /api/v1/*
 * Handles JSON responses only. All endpoints require a valid session.
 */

use App\Middleware\AuthMiddleware;
use App\Middleware\CorsMiddleware;
use App\Helpers\ResponseHelper;

header('Content-Type: application/json');
CorsMiddleware::handle();

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Strip /api/v1 prefix
$path = preg_replace('#^/api/v1#', '', $uri);

// Public routes (no auth needed)
$publicRoutes = ['/auth/login', '/auth/forgot-password', '/auth/reset-password'];

if (!in_array($path, $publicRoutes, true)) {
    AuthMiddleware::require(); // validates session, returns 401 JSON if not logged in
}
