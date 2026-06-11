<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    private $host = '127.0.0.1';
    private $db_name = 'gerenciador_tarefas';
    private $username = 'root';
    private $password = '';

    private function __construct() {}

    public static function getConnection() {
        if (self::$instance === null) {
            $db = new Database();
            try {
                self::$instance = new PDO(
                    "mysql:host=" . $db->host . ";dbname=" . $db->db_name . ";charset=utf8mb4",
                    $db->username,
                    $db->password
                );
                // Configuração PDO para tratar erros como exceptions
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
