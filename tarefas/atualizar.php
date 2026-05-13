<?php
// =============================================
// Arquivo: atualizar.php
// Função: Recebe os dados editados via POST, verifica permissão,
//         registra o histórico e atualiza a tarefa no banco
// =============================================

session_start();
include('../config/conexao.php');
include('../historico/registrar.php'); // Função registrarHistorico()

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../projeto/login.php");
    exit;
}

// Recebe os dados enviados via POST
$id     = intval($_POST['id']);
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$status = $_POST['status'];
$usuario_logado = $_SESSION['usuario_id'];

// PASSO 1: Busca os dados ANTIGOS da tarefa (para comparar no histórico)
$tarefa_antiga = mysqli_fetch_assoc(
    mysqli_query($conexao, "SELECT * FROM tarefas WHERE id = $id")
);

if (!$tarefa_antiga) {
    die("Tarefa não encontrada.");
}

// PASSO 2: Verifica PERMISSÃO - só o criador ou o responsável podem editar
if ($tarefa_antiga['criado_por'] != $usuario_logado && $tarefa_antiga['usuario_id'] != $usuario_logado) {
    die("Você não tem permissão para editar esta tarefa.");
}

// PASSO 3: Registra no histórico ANTES de atualizar (compara antigo vs novo)
registrarHistorico($conexao, $id, $usuario_logado, 'titulo', $tarefa_antiga['titulo'], $titulo);
registrarHistorico($conexao, $id, $usuario_logado, 'descricao', $tarefa_antiga['descricao'], $descricao);
registrarHistorico($conexao, $id, $usuario_logado, 'status', $tarefa_antiga['status'], $status);

// PASSO 4: Sanitiza os dados e executa o UPDATE
$titulo    = mysqli_real_escape_string($conexao, $titulo);
$descricao = mysqli_real_escape_string($conexao, $descricao);
$status    = mysqli_real_escape_string($conexao, $status);

$sql = "UPDATE tarefas SET titulo='$titulo', descricao='$descricao', status='$status' WHERE id=$id";

if (mysqli_query($conexao, $sql)) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro: " . mysqli_error($conexao);
}
?>