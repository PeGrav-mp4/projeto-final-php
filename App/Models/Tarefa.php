<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Tarefa {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function criar($titulo, $descricao, $data_limite, $status, $usuario_id, $criado_por) {
        $sql = "INSERT INTO tarefas (titulo, descricao, data_limite, status, usuario_id, criado_por) 
                VALUES (:titulo, :descricao, :data_limite, :status, :usuario_id, :criado_por)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':data_limite' => $data_limite,
            ':status' => $status,
            ':usuario_id' => $usuario_id,
            ':criado_por' => $criado_por
        ]);
    }

    public function listar() {
        $sql = "SELECT t.*, u.nome as responsavel_nome, c.nome as criador_nome 
                FROM tarefas t 
                JOIN usuarios u ON t.usuario_id = u.id
                JOIN usuarios c ON t.criado_por = c.id
                ORDER BY t.data_limite ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function atualizar($id, $titulo, $descricao, $data_limite, $status, $usuario_id) {
        $sql = "UPDATE tarefas SET titulo = :titulo, descricao = :descricao, 
                data_limite = :data_limite, status = :status, usuario_id = :usuario_id 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':data_limite' => $data_limite,
            ':status' => $status,
            ':usuario_id' => $usuario_id,
            ':id' => $id
        ]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM tarefas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
