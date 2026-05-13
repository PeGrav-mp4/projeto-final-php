<?php
// =============================================
// Arquivo: editar.php
// Função: Exibir detalhes de uma tarefa com:
//         - Formulário de edição (só para criador/responsável)
//         - Seção de comentários
//         - Histórico de alterações
// =============================================

session_start();
include('../config/conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../projeto/login.php");
    exit;
}

$id = intval($_GET['id']); // intval() converte para inteiro (segurança)
$usuario_logado = $_SESSION['usuario_id'];

// JOIN duplo: busca o nome do responsável E do criador da tarefa
$sql = "SELECT t.*, u_resp.nome as responsavel_nome, u_criador.nome as criador_nome 
        FROM tarefas t 
        JOIN usuarios u_resp ON t.usuario_id = u_resp.id 
        JOIN usuarios u_criador ON t.criado_por = u_criador.id 
        WHERE t.id = $id";
$tarefa = mysqli_fetch_assoc(mysqli_query($conexao, $sql));

// Se a tarefa não existir, volta para a lista
if (!$tarefa) {
    header("Location: listar.php");
    exit;
}

// Verifica permissão: só pode editar quem criou OU quem é o responsável
$pode_editar = ($tarefa['criado_por'] == $usuario_logado || $tarefa['usuario_id'] == $usuario_logado);

// Busca todos os comentários desta tarefa (JOIN com usuarios para pegar o nome)
$comentarios_res = mysqli_query($conexao, 
    "SELECT c.*, u.nome FROM comentarios c 
     JOIN usuarios u ON c.usuario_id = u.id 
     WHERE c.tarefa_id = $id ORDER BY c.data_comentario DESC");

// Busca todo o histórico de alterações desta tarefa
$historico_res = mysqli_query($conexao, 
    "SELECT h.*, u.nome FROM historico h 
     JOIN usuarios u ON h.usuario_id = u.id 
     WHERE h.tarefa_id = $id ORDER BY h.data_alteracao DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Tarefa | Gerenciador de Tarefas</title>
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
        <!-- Layout em duas colunas: edição à esquerda, comentários/histórico à direita -->
        <div class="layout-duas-colunas">

            <!-- COLUNA ESQUERDA: Formulário de edição -->
            <section>
                <div class="card">
                    <h2><?php echo $pode_editar ? 'Editar Tarefa' : 'Detalhes da Tarefa'; ?></h2>

                    <!-- Alerta de permissão se o usuário não pode editar -->
                    <?php if (!$pode_editar) { ?>
                        <div class="alert">Apenas o criador ou responsável podem editar.</div>
                    <?php } ?>

                    <!-- Formulário envia via POST para atualizar.php -->
                    <form action="atualizar.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>">

                        <label>Título:</label>
                        <!-- disabled: campo aparece mas não envia dados -->
                        <input type="text" name="titulo" value="<?php echo htmlspecialchars($tarefa['titulo']); ?>"
                            <?php echo !$pode_editar ? 'disabled' : 'required'; ?>>

                        <label>Descrição:</label>
                        <textarea name="descricao" rows="4"
                            <?php echo !$pode_editar ? 'disabled' : 'required'; ?>><?php echo htmlspecialchars($tarefa['descricao']); ?></textarea>

                        <label>Status:</label>
                        <select name="status" <?php echo !$pode_editar ? 'disabled' : ''; ?>>
                            <option value="pendente" <?php if($tarefa['status']=="pendente") echo "selected"; ?>>Pendente</option>
                            <option value="andamento" <?php if($tarefa['status']=="andamento") echo "selected"; ?>>Em Andamento</option>
                            <option value="concluida" <?php if($tarefa['status']=="concluida") echo "selected"; ?>>Concluída</option>
                        </select>

                        <label>Responsável:</label>
                        <input type="text" value="<?php echo htmlspecialchars($tarefa['responsavel_nome']); ?>" disabled>

                        <?php if ($pode_editar) { ?>
                            <br>
                            <button type="submit" class="btn-block">Atualizar Tarefa</button>
                        <?php } ?>
                    </form>
                </div>
            </section>

            <!-- COLUNA DIREITA: Comentários + Histórico -->
            <section>

                <!-- COMENTÁRIOS -->
                <div class="card mb-10">
                    <h3>Comentários</h3>
                    <br>
                    <!-- Formulário de novo comentário (POST) -->
                    <form action="../comentarios/comentar.php" method="POST">
                        <input type="hidden" name="tarefa_id" value="<?php echo $id; ?>">
                        <textarea name="comentario" rows="2" placeholder="Escreva um comentário..." required></textarea>
                        <button type="submit" class="btn btn-secondary btn-block">Enviar Comentário</button>
                    </form>
                    <br>
                    <!-- Lista de comentários existentes -->
                    <div class="scroll-box">
                        <?php if (mysqli_num_rows($comentarios_res) > 0) { ?>
                            <?php while ($com = mysqli_fetch_assoc($comentarios_res)) { ?>
                                <div class="comentario">
                                    <strong><?php echo htmlspecialchars($com['nome']); ?></strong>
                                    <small> - <?php echo date('d/m/Y H:i', strtotime($com['data_comentario'])); ?></small>
                                    <!-- nl2br() converte quebras de linha (\n) em <br> -->
                                    <p><?php echo nl2br(htmlspecialchars($com['comentario'])); ?></p>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-center">Nenhum comentário ainda.</p>
                        <?php } ?>
                    </div>
                </div>

                <!-- HISTÓRICO DE ALTERAÇÕES -->
                <div class="card">
                    <h3>Histórico de Alterações</h3>
                    <br>
                    <div class="scroll-box">
                        <?php if (mysqli_num_rows($historico_res) > 0) { ?>
                            <?php while ($hist = mysqli_fetch_assoc($historico_res)) { ?>
                                <div class="historico-item">
                                    <p>
                                        <strong><?php echo htmlspecialchars($hist['nome']); ?></strong>
                                        alterou <strong><?php echo $hist['campo_alterado']; ?></strong>
                                        em <?php echo date('d/m/Y H:i', strtotime($hist['data_alteracao'])); ?>
                                    </p>
                                    <p>
                                        <!-- Valor antigo riscado, valor novo em destaque -->
                                        <span class="antigo"><?php echo htmlspecialchars($hist['valor_antigo']); ?></span>
                                        &rarr;
                                        <span class="novo"><?php echo htmlspecialchars($hist['valor_novo']); ?></span>
                                    </p>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-center">Nenhuma alteração registrada.</p>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <small>&copy; <?php echo date('Y'); ?> Gerenciador de Tarefas</small>
    </footer>
</body>
</html>