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
