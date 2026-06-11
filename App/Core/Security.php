<?php
namespace App\Core;

class Security {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function generateCSRFToken() {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken($token) {
        self::startSession();
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            die("Erro CSRF: Token inválido ou expirado.");
        }
        return true;
    }

    public static function checkAuth() {
        self::startSession();
        if (!isset($_SESSION['user_id'])) {
            // Base URL helper
            $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1));
            header("Location: " . $basepath . "/login");
            exit;
        }
    }
}
