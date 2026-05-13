<?php
// =============================================
// Arquivo: index.php (ARQUIVO PRINCIPAL)
// Função: Página inicial do sistema - tela de boas-vindas
// =============================================

/*
 * Gerenciador de Tarefas Colaborativo
 * Trabalho de PHP - 2026
 *
 * Integrantes:
 * Gustavo Henrique Garcia Cavalli  - RGM: 43635563
 * Luana Brotto de Jesus             - RGM: 41940270
 * Pedro Henrique Policeno           - RGM: 41829964
 */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- CSS próprio, sem bibliotecas externas -->
</head>
<body>
    <!-- Container centralizado para a tela inicial -->
    <div class="auth-container">
        <div class="card text-center">
            <h1>Gerenciador de Tarefas</h1>
            <p>Organize sua rotina com simplicidade.</p>
            <br>
            <!-- Links para login e cadastro -->
            <a href="login.php" class="btn btn-block">Entrar no Sistema</a>
            <br>
            <a href="cadastro.php" class="btn btn-secondary btn-block">Criar Nova Conta</a>
        </div>
    </div>
</body>
</html>