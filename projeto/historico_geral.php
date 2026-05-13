<?php
// =============================================
// Arquivo: historico_geral.php
// Função: Exibir log de TODAS as alterações do sistema
//         em formato de tabela (auditoria global)
// =============================================

session_start();
include('../config/conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// JOIN triplo: histórico + nome do usuário que alterou + título da tarefa
$sql = "SELECT h.*, u.nome as usuario_nome, t.titulo as tarefa_titulo 
        FROM historico h 
        JOIN usuarios u ON h.usuario_id = u.id 
        JOIN tarefas t ON h.tarefa_id = t.id 
        ORDER BY h.data_alteracao DESC";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico | Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <h2><a href="dashboard.php">Gerenciador de Tarefas</a></h2>
            <a href="dashboard.php" class="btn btn-secondary">Voltar</a>
        </nav>
    </header>

    <main>
        <h1>Histórico do Sistema</h1>
        <p>Todas as modificações realizadas nas tarefas.</p>
        <br>

        <section class="card">
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Usuário</th>
                        <th>Tarefa</th>
                        <th>Campo</th>
                        <th>Alteração</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0) { ?>
                        <!-- Laço while para percorrer cada registro do histórico -->
                        <?php while ($log = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($log['data_alteracao'])); ?></td>
                                <td><strong><?php echo htmlspecialchars($log['usuario_nome']); ?></strong></td>
                                <td>
                                    <a href="../tarefas/editar.php?id=<?php echo $log['tarefa_id']; ?>">
                                        <?php echo htmlspecialchars($log['tarefa_titulo']); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($log['campo_alterado']); ?></td>
                                <td>
                                    <span style="text-decoration: line-through; color: #999;">
                                        <?php echo htmlspecialchars($log['valor_antigo']); ?>
                                    </span>
                                    &rarr;
                                    <span style="color: #155724; font-weight: bold;">
                                        <?php echo htmlspecialchars($log['valor_novo']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma alteração registrada ainda.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <small>&copy; <?php echo date('Y'); ?> Gerenciador de Tarefas</small>
    </footer>
</body>
</html>
