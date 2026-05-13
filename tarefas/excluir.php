<?php
// =============================================
// Arquivo: excluir.php
// Função: Excluir uma tarefa do banco
// Apenas o criador ou o responsável podem excluir
// Recebe o ID da tarefa via GET (na URL)
// =============================================

session_start();
include('../config/conexao.php');

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../projeto/login.php");
    exit;
}

$id = intval($_GET['id']); // Recebe o ID via GET e converte para inteiro
$usuario_logado = $_SESSION['usuario_id'];

// Busca a tarefa para verificar quem é o dono
$tarefa = mysqli_fetch_assoc(
    mysqli_query($conexao, "SELECT * FROM tarefas WHERE id = $id")
);

if (!$tarefa) {
    die("Tarefa não encontrada.");
}

// Verifica permissão: só criador ou responsável podem excluir
if ($tarefa['criado_por'] != $usuario_logado && $tarefa['usuario_id'] != $usuario_logado) {
    die("Você não tem permissão para excluir esta tarefa.");
}

// Executa o DELETE no banco
if (mysqli_query($conexao, "DELETE FROM tarefas WHERE id = $id")) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao excluir: " . mysqli_error($conexao);
}
?>