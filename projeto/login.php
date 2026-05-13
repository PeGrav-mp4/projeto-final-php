<?php
// =============================================
// Arquivo: login.php
// Função: Formulário de autenticação do usuário
// Envia os dados via POST para autenticar.php
// =============================================
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="card">
            <h2 class="text-center">Login</h2>
            <p class="text-center">Acesse sua conta para gerenciar suas tarefas.</p>
            <br>
            <!-- Formulário envia email e senha via POST para autenticar.php -->
            <form action="../usuarios/autenticar.php" method="POST">
                <label>E-mail:</label>
                <input type="email" name="email" placeholder="seu@email.com" required>

                <label>Senha:</label>
                <input type="password" name="senha" placeholder="Sua senha" required>

                <button type="submit" class="btn-block">Entrar</button>
            </form>
            <br>
            <p class="text-center">Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
        </div>
    </div>
</body>
</html>