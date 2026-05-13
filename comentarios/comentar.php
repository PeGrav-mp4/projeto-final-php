<?php
// =============================================
// Arquivo: comentar.php
// Função: Recebe o texto do comentário via POST
//         e salva na tabela 'comentarios' do banco
// =============================================

session_start();
include('../config/conexao.php');

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para comentar.");
}

// Só processa se a requisição for POST (veio do formulário)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarefa_id  = intval($_POST['tarefa_id']);
    $usuario_id = $_SESSION['usuario_id']; // Pega o ID do usuário da sessão
    $comentario = mysqli_real_escape_string($conexao, $_POST['comentario']);

    // Só insere se o comentário não estiver vazio
    if (!empty($comentario)) {
        $sql = "INSERT INTO comentarios (tarefa_id, usuario_id, comentario) 
                VALUES ($tarefa_id, $usuario_id, '$comentario')";

        if (mysqli_query($conexao, $sql)) {
            // Redireciona de volta para a página de detalhes da tarefa
            header("Location: ../tarefas/editar.php?id=$tarefa_id");
            exit;
        } else {
            echo "Erro ao comentar: " . mysqli_error($conexao);
        }
    } else {
        header("Location: ../tarefas/editar.php?id=$tarefa_id");
        exit;
    }
}
?>
