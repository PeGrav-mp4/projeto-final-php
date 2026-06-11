<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Comentario {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function criar($tarefa_id, $usuario_id, $comentario) {
        $sql = "INSERT INTO comentarios (tarefa_id, usuario_id, comentario) VALUES (:tarefa_id, :usuario_id, :comentario)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':tarefa_id' => $tarefa_id,
            ':usuario_id' => $usuario_id,
            ':comentario' => $comentario
        ]);
    }

    public function listarPorTarefa($tarefa_id) {
        $sql = "SELECT c.*, u.nome FROM comentarios c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.tarefa_id = :tarefa_id 
                ORDER BY c.data_comentario DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tarefa_id' => $tarefa_id]);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM comentarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function atualizar($id, $comentario) {
        $sql = "UPDATE comentarios SET comentario = :comentario WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':comentario' => $comentario,
            ':id' => $id
        ]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM comentarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
