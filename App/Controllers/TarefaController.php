<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Security;
use App\Models\Tarefa;
use App\Models\Usuario;
use App\Models\Comentario;

class TarefaController extends Controller {
    public function dashboard() {
        Security::checkAuth();
        $tarefaModel = new Tarefa();
        $tarefas = $tarefaModel->listar();
        
        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'tarefas' => $tarefas
        ]);
    }

    public function criar() {
        Security::checkAuth();
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        $this->view('tarefas/form', [
            'title' => 'Nova Tarefa',
            'usuarios' => $usuarios,
            'csrf_token' => Security::generateCSRFToken(),
            'tarefa' => null
        ]);
    }

    public function postCriar() {
        Security::checkAuth();
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');
        
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $data_limite = $_POST['data_limite'] ?? '';
        $status = $_POST['status'] ?? 'pendente';
        $usuario_id = $_POST['usuario_id'] ?? '';
        $criado_por = $_SESSION['user_id'];

        $tarefaModel = new Tarefa();
        $tarefaModel->criar($titulo, $descricao, $data_limite, $status, $usuario_id, $criado_por);
        
        $this->redirect('/dashboard');
    }

    public function editar() {
        Security::checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/dashboard');
        }

        $tarefaModel = new Tarefa();
        $tarefa = $tarefaModel->buscarPorId($id);

        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        $this->view('tarefas/form', [
            'title' => 'Editar Tarefa',
            'usuarios' => $usuarios,
            'tarefa' => $tarefa,
            'csrf_token' => Security::generateCSRFToken()
        ]);
    }

    public function postEditar() {
        Security::checkAuth();
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');

        $id = $_POST['id'] ?? '';
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $data_limite = $_POST['data_limite'] ?? '';
        $status = $_POST['status'] ?? '';
        $usuario_id = $_POST['usuario_id'] ?? '';

        $tarefaModel = new Tarefa();
        $tarefaModel->atualizar($id, $titulo, $descricao, $data_limite, $status, $usuario_id);

        $this->redirect('/dashboard');
    }

    public function excluir() {
        Security::checkAuth();
        // Em um sistema real o ideal seria POST para exclusão com CSRF, mas para simplificar vamos aceitar GET se protegido pela auth, ou melhor, faremos um formulário com POST
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');
        
        $id = $_POST['id'] ?? null;
        if ($id) {
            $tarefaModel = new Tarefa();
            $tarefaModel->excluir($id);
        }
        $this->redirect('/dashboard');
    }

    // CRUD de Comentários embutido no visual da tarefa
    public function detalhes() {
        Security::checkAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/dashboard');
        }

        $tarefaModel = new Tarefa();
        $tarefa = $tarefaModel->buscarPorId($id);

        $comentarioModel = new Comentario();
        $comentarios = $comentarioModel->listarPorTarefa($id);

        $this->view('tarefas/detalhes', [
            'title' => 'Detalhes da Tarefa',
            'tarefa' => $tarefa,
            'comentarios' => $comentarios,
            'csrf_token' => Security::generateCSRFToken()
        ]);
    }

    public function postComentario() {
        Security::checkAuth();
        Security::validateCSRFToken($_POST['csrf_token'] ?? '');

        $tarefa_id = $_POST['tarefa_id'] ?? '';
        $comentario = $_POST['comentario'] ?? '';
        $usuario_id = $_SESSION['user_id'];

        if (!empty($comentario) && !empty($tarefa_id)) {
            $comentarioModel = new Comentario();
            $comentarioModel->criar($tarefa_id, $usuario_id, $comentario);
        }

        $this->redirect('/tarefa?id=' . $tarefa_id);
    }
}
