<?php
$host = "localhost:3306";
$usuario = "root";
$senha = "";

$conexao = mysqli_connect($host, $usuario, $senha);

if (!$conexao) {
    die("Falha na conexao: " . mysqli_connect_error() . "\n");
}

$sql = file_get_contents(__DIR__ . '/database/banco.sql');

if (mysqli_multi_query($conexao, $sql)) {
    echo "Banco de dados e tabelas criados com sucesso!\n";
} else {
    echo "Erro ao criar banco/tabelas: " . mysqli_error($conexao) . "\n";
}

mysqli_close($conexao);
?>
