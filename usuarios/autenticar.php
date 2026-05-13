<?php
// =============================================
// Arquivo: autenticar.php
// Função: Recebe email e senha do formulário de login (POST)
//         e verifica se o usuário existe no banco
// =============================================

session_start(); // Inicia a sessão para poder salvar dados do usuário
include('../config/conexao.php'); // Importa a conexão com o banco

// Recebe os dados enviados via POST pelo formulário de login
$email = $_POST['email'];
$senha = $_POST['senha'];

// Busca o usuário pelo e-mail informado
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conexao, $sql);

// mysqli_num_rows() conta quantos registros foram encontrados
if (mysqli_num_rows($resultado) > 0) {
    // mysqli_fetch_assoc() transforma o resultado em um array associativo
    $usuario = mysqli_fetch_assoc($resultado);

    // password_verify() compara a senha digitada com a senha criptografada do banco
    if (password_verify($senha, $usuario['senha'])) {
        // Cria as variáveis de sessão para manter o login ativo
        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header("Location: ../projeto/dashboard.php"); // Redireciona para o painel
        exit;
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}
?>