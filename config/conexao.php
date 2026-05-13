<?php
// =============================================
// Arquivo: conexao.php
// Função: Conectar ao banco de dados MySQL
// =============================================

// Dados de acesso ao banco
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "gerenciador_tarefas";

// mysqli_connect() cria a conexão com o banco usando os dados acima
$conexao = mysqli_connect($host, $usuario, $senha, $banco);

// Verifica se a conexão falhou; se sim, encerra o script com a mensagem de erro
if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>