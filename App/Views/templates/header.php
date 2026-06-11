<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gerenciador de Tarefas' ?> - GT</title>
    <!-- CSS Nativo e Simples -->
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <h1><a href="/">Gerenciador de Tarefas</a></h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="/logout">Sair (<?= htmlspecialchars($_SESSION['user_nome'] ?? '') ?>)</a></li>
                    <?php else: ?>
                        <li><a href="/">Início</a></li>
                        <li><a href="/sobre">Sobre</a></li>
                        <li><a href="/contato">Contato</a></li>
                        <li><a href="/login" class="btn-primary">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container content">
