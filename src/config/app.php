<?php
namespace App\Config;

class App {
    public static function init(): void {
        // Load constants
        require_once dirname(__DIR__) . '/config/constants.php';

        // Session setup
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure',   isset($_SERVER['HTTPS']) ? 1 : 0);
        ini_set('session.use_strict_mode', 1);
        session_name($_ENV['SESSION_NAME'] ?? 'campus_session');
        session_start();
