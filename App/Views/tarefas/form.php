<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2><?= htmlspecialchars($title) ?></h2>
    <form action="<?= isset($tarefa) ? '/tarefa/editar' : '/tarefa/criar' ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <?php if (isset($tarefa)): ?>
            <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($tarefa['titulo'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($tarefa['descricao'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="data_limite">Data Limite:</label>
            <input type="date" id="data_limite" name="data_limite" value="<?= htmlspecialchars($tarefa['data_limite'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="pendente" <?= (isset($tarefa) && $tarefa['status'] == 'pendente') ? 'selected' : '' ?>>Pendente</option>
                <option value="andamento" <?= (isset($tarefa) && $tarefa['status'] == 'andamento') ? 'selected' : '' ?>>Em Andamento</option>
                <option value="concluida" <?= (isset($tarefa) && $tarefa['status'] == 'concluida') ? 'selected' : '' ?>>Concluída</option>
            </select>
        </div>
        <div class="form-group">
            <label for="usuario_id">Responsável:</label>
            <select id="usuario_id" name="usuario_id" required>
                <option value="">Selecione um responsável</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>" <?= (isset($tarefa) && $tarefa['usuario_id'] == $usuario['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($usuario['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn-primary">Salvar</button>
        <a href="/dashboard" class="btn-secondary" style="margin-left: 10px;">Cancelar</a>
    </form>
</div>
