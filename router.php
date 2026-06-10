<?php
/**
 * Front Controller / Router
 * All HTTP requests are routed through here via .htaccess
 */

define('ROOT_PATH', dirname(__FILE__));
define('SRC_PATH',  ROOT_PATH . '/src');

require_once ROOT_PATH . '/vendor/autoload.php';

use App\Config\App;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\LoggingMiddleware;
use App\Middleware\RateLimitMiddleware;

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Bootstrap app config
App::init();

// Run middleware stack
LoggingMiddleware::handle();
RateLimitMiddleware::handle();
CsrfMiddleware::handle();

// Parse the request
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route to API or web
if (str_starts_with($uri, '/api/')) {
    require_once SRC_PATH . '/api/routes.php';
} else {
    require_once SRC_PATH . '/web_routes.php';
}

