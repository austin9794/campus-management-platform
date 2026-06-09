<?php
namespace App\Helpers;

class ResponseHelper {
    public static function redirect(string $url, int $code = 302): void {
        http_response_code($code);
        header('Location: ' . $url);
        exit;
    }

    public static function json(mixed $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function error(string $message, int $code = 400): void {
        self::json(['success' => false, 'error' => $message], $code);
    }

    public static function success(mixed $data = null, string $message = 'OK'): void {
        self::json(['success' => true, 'message' => $message, 'data' => $data]);
    }
}
