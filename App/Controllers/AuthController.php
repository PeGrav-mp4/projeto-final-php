<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Security;
use App\Models\Usuario;

class AuthController extends Controller {
    public function login() {
        Security::startSession();
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login', [
            'title' => 'Login', 
            'csrf_token' => Security::generateCSRFToken(),
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['error']);
    }

    public function postLogin() {
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $usuarioModel = new Usuario();
        $user = $usuarioModel->buscarPorEmail($email);

        if ($user && password_verify($senha, $user['senha'])) {
            Security::startSession();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            // Requisito 4: Uso de cookies - Lembrar-me
            if (isset($_POST['lembrar'])) {
                setcookie('usuario_email', $email, time() + (86400 * 30), "/"); // 30 dias
            }
            $this->redirect('/dashboard');
        } else {
            Security::startSession();
            $_SESSION['error'] = "Credenciais inválidas.";
            $this->redirect('/login');
        }
    }

    public function cadastro() {
        $this->view('auth/cadastro', [
            'title' => 'Cadastro',
            'csrf_token' => Security::generateCSRFToken(),
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['error']);
    }

    public function postCadastro() {
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');
        $nome = $_POST['nome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $data_nascimento = $_POST['data_nascimento'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (empty($nome) || empty($cpf) || empty($data_nascimento) || empty($email) || empty($senha)) {
            Security::startSession();
            $_SESSION['error'] = "Preencha todos os campos.";
            $this->redirect('/cadastro');
        }

        $usuarioModel = new Usuario();
        if ($usuarioModel->buscarPorEmail($email)) {
            Security::startSession();
            $_SESSION['error'] = "E-mail já está em uso.";
            $this->redirect('/cadastro');
        }

        if ($usuarioModel->cadastrar($nome, $cpf, $data_nascimento, $email, $senha)) {
            $this->redirect('/login');
        } else {
            Security::startSession();
            $_SESSION['error'] = "Erro ao cadastrar usuário.";
            $this->redirect('/cadastro');
        }
    }

    public function recuperarSenha() {
        $this->view('auth/recuperar_senha', [
            'title' => 'Recuperar Senha',
            'csrf_token' => Security::generateCSRFToken(),
            'error' => $_SESSION['error'] ?? null,
            'success' => $_SESSION['success'] ?? null
        ]);
        unset($_SESSION['error'], $_SESSION['success']);
    }

    public function postRecuperarSenha() {
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');
        $cpf = $_POST['cpf'] ?? '';
        $data_nascimento = $_POST['data_nascimento'] ?? '';
        $nova_senha = $_POST['nova_senha'] ?? '';

        if (empty($cpf) || empty($data_nascimento) || empty($nova_senha)) {
            Security::startSession();
            $_SESSION['error'] = "Preencha todos os campos.";
            $this->redirect('/recuperar_senha');
        }

        $usuarioModel = new Usuario();
        $user = $usuarioModel->validarParaRecuperacao($cpf, $data_nascimento);

        if ($user) {
            $usuarioModel->atualizarSenha($user['id'], $nova_senha);
            Security::startSession();
            $_SESSION['success'] = "Senha atualizada com sucesso. Faça o login.";
            $this->redirect('/login');
        } else {
            Security::startSession();
            $_SESSION['error'] = "Dados inválidos.";
            $this->redirect('/recuperar_senha');
        }
    }

    public function logout() {
        Security::startSession();
        session_destroy();
        $this->redirect('/login');
    }
}
