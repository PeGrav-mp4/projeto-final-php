<?php
// Script para configuração inicial rápida do banco de dados
// Pode ser rodado no terminal via `php setup_db.php`

$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents(__DIR__ . '/database/banco.sql');
    
    $pdo->exec($sql);
    
    echo "Banco de dados 'gerenciador_tarefas' criado/atualizado com sucesso com as novas colunas CPF e Data de Nascimento!\n";

} catch (PDOException $e) {
    echo "Erro ao configurar o banco de dados: " . $e->getMessage() . "\n";
}
