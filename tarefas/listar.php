<?php
// =============================================
// Arquivo: listar.php
// Função: Exibir TODAS as tarefas do sistema com filtros
// Filtros enviados via GET: responsável, status e data limite
// =============================================

session_start();
include('../config/conexao.php');

// Proteção: só acessa se estiver logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../projeto/login.php");
    exit;
}

// Recebe os filtros da URL (GET) - se não existir, usa string vazia
$filtro_usuario = isset($_GET['usuario_id']) ? intval($_GET['usuario_id']) : '';
$filtro_status  = isset($_GET['status']) ? $_GET['status'] : '';
$filtro_data    = isset($_GET['data_limite']) ? $_GET['data_limite'] : '';

// Monta a query base com JOIN para trazer o nome do responsável
$sql = "SELECT t.*, u.nome as responsavel FROM tarefas t 
        JOIN usuarios u ON t.usuario_id = u.id WHERE 1=1";

// Adiciona filtros dinamicamente à query, se foram preenchidos
if ($filtro_usuario != '') {
    $sql .= " AND t.usuario_id = " . $filtro_usuario;
}
if ($filtro_status != '') {
    $sql .= " AND t.status = '" . mysqli_real_escape_string($conexao, $filtro_status) . "'";
}
if ($filtro_data != '') {
    $sql .= " AND t.data_limite = '" . mysqli_real_escape_string($conexao, $filtro_data) . "'";
}

$sql .= " ORDER BY t.created_at DESC"; // Ordena do mais recente para o mais antigo
$resultado = mysqli_query($conexao, $sql);

// Busca todos os usuários para o select do filtro
$usuarios_res = mysqli_query($conexao, "SELECT id, nome FROM usuarios");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas | Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <h2><a href="../projeto/dashboard.php">Gerenciador de Tarefas</a></h2>
            <div>
                <a href="../projeto/dashboard.php" class="btn btn-secondary">Voltar</a>
            </div>
        </nav>
    </header>

    <main>
        <!-- Seção de Filtros (usa GET para enviar os parâmetros na URL) -->
        <section class="card mb-10">
            <h3>Filtros</h3>
            <br>
            <form method="GET" class="filtros">
                <div class="form-group">
                    <label>Responsável:</label>
                    <select name="usuario_id">
                        <option value="">Todos</option>
                        <!-- Laço while para popular o select com os usuários -->
                        <?php while ($u = mysqli_fetch_assoc($usuarios_res)) { ?>
                            <option value="<?php echo $u['id']; ?>"
                                <?php echo ($filtro_usuario == $u['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($u['nome']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status">
                        <option value="">Todos</option>
                        <option value="pendente" <?php echo ($filtro_status == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                        <option value="andamento" <?php echo ($filtro_status == 'andamento') ? 'selected' : ''; ?>>Andamento</option>
                        <option value="concluida" <?php echo ($filtro_status == 'concluida') ? 'selected' : ''; ?>>Concluída</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Data Limite:</label>
                    <input type="date" name="data_limite" value="<?php echo htmlspecialchars($filtro_data); ?>">
                </div>
                <div class="form-group">
                    <button type="submit">Filtrar</button>
                    <a href="listar.php" class="btn btn-secondary">Limpar</a>
                </div>
            </form>
        </section>

        <!-- Lista de tarefas -->
        <section>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1>Lista de Tarefas</h1>
                <a href="adicionar.php" class="btn">+ Adicionar Nova Tarefa</a>
            </div>
            <br>
            <div class="grid-tarefas">
                <?php if (mysqli_num_rows($resultado) > 0) { ?>
                    <!-- Laço while para percorrer cada tarefa retornada do banco -->
                    <?php while ($tarefa = mysqli_fetch_assoc($resultado)) {
                        // Define a classe CSS do badge conforme o status
                        if ($tarefa['status'] == 'concluida') $badge = "badge-concluida";
                        elseif ($tarefa['status'] == 'andamento') $badge = "badge-andamento";
                        else $badge = "badge-pendente";
                    ?>
                        <article class="card">
                            <span class="badge <?php echo $badge; ?>"><?php echo ucfirst($tarefa['status']); ?></span>
                            <small>Prazo: <?php echo $tarefa['data_limite'] ? date('d/m/Y', strtotime($tarefa['data_limite'])) : 'N/A'; ?></small>
                            <h3><?php echo htmlspecialchars($tarefa['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                            <p><strong>Responsável:</strong> <?php echo htmlspecialchars($tarefa['responsavel']); ?></p>
                            <br>
                            <!-- Editar usa GET (id na URL), Excluir pede confirmação -->
                            <a href="editar.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="excluir.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </article>
                    <?php } ?>
                <?php } else { ?>
                    <article class="card text-center">
                        <p>Nenhuma tarefa encontrada.</p>
                        <br>
                        <a href="adicionar.php" class="btn">Criar Nova Tarefa</a>
                    </article>
                <?php } ?>
            </div>
        </section>
    </main>

    <footer>
        <small>&copy; <?php echo date('Y'); ?> Gerenciador de Tarefas</small>
    </footer>
</body>
</html>