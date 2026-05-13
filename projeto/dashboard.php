<?php
// =============================================
// Arquivo: dashboard.php
// Função: Painel principal do usuário logado
// Mostra estatísticas e links de navegação
// =============================================

session_start(); // Inicia a sessão para acessar os dados do usuário logado
include('../config/conexao.php'); // Importa a conexão com o banco

// Se não estiver logado, redireciona para o login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id']; // ID do usuário logado (salvo na sessão)

// Conta o total de tarefas atribuídas ao usuário logado
$total_tarefas = mysqli_fetch_assoc(
    mysqli_query($conexao, "SELECT COUNT(*) as total FROM tarefas WHERE usuario_id = $usuario_id")
)['total'];

// Conta quantas estão pendentes
$pendentes = mysqli_fetch_assoc(
    mysqli_query($conexao, "SELECT COUNT(*) as total FROM tarefas WHERE usuario_id = $usuario_id AND status = 'pendente'")
)['total'];

// Conta quantas estão concluídas
$concluidas = mysqli_fetch_assoc(
    mysqli_query($conexao, "SELECT COUNT(*) as total FROM tarefas WHERE usuario_id = $usuario_id AND status = 'concluida'")
)['total'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Cabeçalho com nome do sistema e botão de sair -->
    <header>
        <nav>
            <h2><a href="dashboard.php">Gerenciador de Tarefas</a></h2>
            <div>
                <!-- htmlspecialchars() previne ataques XSS ao exibir dados do usuário -->
                <span>Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></strong></span>
                <a href="logout.php" class="btn btn-secondary">Sair</a>
            </div>
        </nav>
    </header>

    <main>
        <h1>Seu Painel</h1>
        <p>Gerencie suas atividades e acompanhe seu progresso.</p>
        <br>

        <!-- Cards de estatísticas usando tags semânticas (section + article) -->
        <section class="stats">
            <article class="card text-center">
                <p>Total de Tarefas</p>
                <h2><?php echo $total_tarefas; ?></h2>
            </article>
            <article class="card text-center" style="border-left: 4px solid #856404;">
                <p>Pendentes</p>
                <h2 style="color: #856404;"><?php echo $pendentes; ?></h2>
            </article>
            <article class="card text-center" style="border-left: 4px solid #155724;">
                <p>Concluídas</p>
                <h2 style="color: #155724;"><?php echo $concluidas; ?></h2>
            </article>
        </section>

        <!-- Navegação rápida -->
        <section class="card">
            <h3>O que vamos fazer hoje?</h3>
            <p>Gerencie as tarefas ou veja as alterações no sistema.</p>
            <br>
            <a href="historico_geral.php" class="btn btn-secondary">Logs do Sistema</a>
            <a href="../tarefas/listar.php" class="btn btn-secondary">Ver Todas</a>
            <a href="../tarefas/adicionar.php" class="btn">Nova Tarefa</a>
        </section>
    </main>

    <footer>
        <small>&copy; <?php echo date('Y'); ?> Gerenciador de Tarefas</small>
    </footer>
</body>
</html>