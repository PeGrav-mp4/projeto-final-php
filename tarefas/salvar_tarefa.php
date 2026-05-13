<?php
// =============================================
// Arquivo: salvar_tarefa.php
// Função: Recebe os dados do formulário de criação (POST)
//         e insere a nova tarefa no banco de dados
// =============================================

session_start();
include('../config/conexao.php');

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado.");
}

// Recebe os campos enviados via POST pelo formulário
$titulo     = mysqli_real_escape_string($conexao, $_POST['titulo']);
$descricao  = mysqli_real_escape_string($conexao, $_POST['descricao']);
$data_limite = mysqli_real_escape_string($conexao, $_POST['data_limite']);
$usuario_id = intval($_POST['usuario_id']);   // Responsável pela tarefa
$criado_por = $_SESSION['usuario_id'];        // Quem criou (pego da sessão)

// Insere a tarefa no banco com status inicial 'pendente'
$sql = "INSERT INTO tarefas (titulo, descricao, status, usuario_id, data_limite, criado_por)
        VALUES ('$titulo', '$descricao', 'pendente', $usuario_id, '$data_limite', $criado_por)";

if (mysqli_query($conexao, $sql)) {
    header("Location: listar.php"); // Volta para a lista após salvar
    exit;
} else {
    echo "Erro: " . mysqli_error($conexao);
}
?>