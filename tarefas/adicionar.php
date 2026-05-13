<?php
// =============================================
// Arquivo: adicionar.php
// Função: Formulário para criar uma nova tarefa
// O criador pode atribuir a tarefa a qualquer membro da equipe
// =============================================

session_start();
include('../config/conexao.php');

// Proteção: só acessa se estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../projeto/login.php");
    exit;
}

// Busca todos os usuários para preencher o campo "Responsável"
$usuarios = mysqli_query($conexao, "SELECT id, nome FROM usuarios");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Tarefa | Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <h2><a href="../projeto/dashboard.php">Gerenciador de Tarefas</a></h2>
            <a href="listar.php" class="btn btn-secondary">Voltar</a>
        </nav>
    </header>

    <main>
        <div class="auth-container">
            <div class="card">
                <h2>Criar Nova Tarefa</h2>
                <p>Preencha os detalhes da atividade abaixo.</p>
                <br>
                <!-- Formulário envia dados via POST para salvar_tarefa.php -->
                <form action="salvar_tarefa.php" method="POST">
                    <label>Título:</label>
                    <input type="text" name="titulo" placeholder="Ex: Estudar PHP" required>

                    <label>Descrição:</label>
                    <textarea name="descricao" rows="4" placeholder="O que precisa ser feito?" required></textarea>

                    <label>Data Limite:</label>
                    <input type="date" name="data_limite">

                    <label>Responsável:</label>
                    <select name="usuario_id">
                        <!-- Laço while para listar todos os usuários cadastrados -->
                        <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                            <option value="<?php echo $usuario['id']; ?>"
                                <?php echo ($usuario['id'] == $_SESSION['usuario_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($usuario['nome']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <br>
                    <button type="submit" class="btn-block">Salvar Tarefa</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <small>&copy; <?php echo date('Y'); ?> Gerenciador de Tarefas</small>
    </footer>
</body>
</html>