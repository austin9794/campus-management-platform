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

        // Error reporting based on env
        if (($_ENV['APP_DEBUG'] ?? 'false') === 'true') {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        // Set timezone
        date_default_timezone_set('UTC');
    }
}
