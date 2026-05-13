<?php
// =============================================
// Arquivo: cadastrar_usuario.php
// Função: Recebe os dados do formulário de cadastro (POST)
//         e insere o novo usuário no banco de dados
// =============================================

include('../config/conexao.php'); // Importa a conexão com o banco

// Verifica se todos os campos obrigatórios foram enviados via POST
if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    die("Erro: dados não recebidos do formulário.");
}

// mysqli_real_escape_string() protege contra SQL Injection nos textos
$nome  = mysqli_real_escape_string($conexao, $_POST['nome']);
$email = mysqli_real_escape_string($conexao, $_POST['email']);

// password_hash() criptografa a senha antes de salvar no banco (segurança)
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Insere o novo usuário na tabela 'usuarios'
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

if (mysqli_query($conexao, $sql)) {
    header('Location: ../projeto/login.php'); // Redireciona para login após cadastro
    exit;
} else {
    echo "Erro: " . mysqli_error($conexao); // Mostra erro se falhar
}
?>