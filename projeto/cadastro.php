<?php
// =============================================
// Arquivo: cadastro.php
// Função: Formulário de criação de novo usuário
// Envia os dados via POST para cadastrar_usuario.php
// =============================================
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="card">
            <h2 class="text-center">Criar Conta</h2>
            <p class="text-center">Junte-se ao sistema e organize suas tarefas.</p>
            <br>
            <!-- Formulário envia nome, email e senha via POST -->
            <form action="../usuarios/cadastrar_usuario.php" method="POST">
                <label>Nome Completo:</label>
                <input type="text" name="nome" placeholder="Seu nome" required>

                <label>E-mail:</label>
                <input type="email" name="email" placeholder="seu@email.com" required>

                <label>Senha:</label>
                <input type="password" name="senha" placeholder="Crie uma senha" required>

                <button type="submit" class="btn-block">Cadastrar</button>
            </form>
            <br>
            <p class="text-center">Já possui uma conta? <a href="login.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>