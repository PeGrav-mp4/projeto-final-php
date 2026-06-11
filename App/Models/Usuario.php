<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function cadastrar($nome, $cpf, $data_nascimento, $email, $senha) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, cpf, data_nascimento, email, senha) VALUES (:nome, :cpf, :data_nascimento, :email, :senha)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':data_nascimento' => $data_nascimento,
            ':email' => $email,
            ':senha' => $hash
        ]);
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function listarTodos() {
        $sql = "SELECT id, nome, email FROM usuarios ORDER BY nome";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function validarParaRecuperacao($cpf, $data_nascimento) {
        $sql = "SELECT * FROM usuarios WHERE cpf = :cpf AND data_nascimento = :data_nascimento";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':cpf' => $cpf,
            ':data_nascimento' => $data_nascimento
        ]);
        return $stmt->fetch();
    }

    public function atualizarSenha($id, $nova_senha) {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':senha' => $hash,
            ':id' => $id
        ]);
    }
    
    public function deletar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
