<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Dashboard - Suas Tarefas</h2>
        <a href="/tarefa/criar" class="btn-primary">Nova Tarefa</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Status</th>
                <th>Responsável</th>
                <th>Criador</th>
                <th>Data Limite</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tarefas)): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhuma tarefa encontrada.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($tarefas as $tarefa): ?>
                    <tr>
                        <td><?= htmlspecialchars($tarefa['id']) ?></td>
                        <td><?= htmlspecialchars($tarefa['titulo']) ?></td>
                        <td>
                            <?php 
                                $statusMap = [
                                    'pendente' => 'Pendente',
                                    'andamento' => 'Em Andamento',
                                    'concluida' => 'Concluída'
                                ];
                                echo $statusMap[$tarefa['status']] ?? $tarefa['status'];
                            ?>
                        </td>
                        <td><?= htmlspecialchars($tarefa['responsavel_nome']) ?></td>
                        <td><?= htmlspecialchars($tarefa['criador_nome']) ?></td>
                        <td><?= date('d/m/Y', strtotime($tarefa['data_limite'])) ?></td>
                        <td>
                            <a href="/tarefa?id=<?= $tarefa['id'] ?>" class="btn-secondary" style="padding: 4px 8px; font-size: 12px;">Detalhes</a>
                            <a href="/tarefa/editar?id=<?= $tarefa['id'] ?>" class="btn-primary" style="padding: 4px 8px; font-size: 12px;">Editar</a>
                            <form action="/tarefa/excluir" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                <button type="submit" class="btn-danger" style="padding: 4px 8px; font-size: 12px;">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
