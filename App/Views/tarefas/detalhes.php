<div class="card">
    <h2>Tarefa #<?= htmlspecialchars($tarefa['id']) ?> - <?= htmlspecialchars($tarefa['titulo']) ?></h2>
    <p><strong>Status:</strong> <?= htmlspecialchars($tarefa['status']) ?></p>
    <p><strong>Data Limite:</strong> <?= date('d/m/Y', strtotime($tarefa['data_limite'])) ?></p>
    <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($tarefa['descricao'])) ?></p>
    <br>
    <a href="/dashboard" class="btn-secondary">Voltar</a>
    <a href="/tarefa/editar?id=<?= $tarefa['id'] ?>" class="btn-primary">Editar Tarefa</a>
</div>

<div class="card">
    <h3>Comentários (CRUD)</h3>
    <div style="margin-top: 15px;">
        <form action="/comentario/criar" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <input type="hidden" name="tarefa_id" value="<?= $tarefa['id'] ?>">
            <div class="form-group">
                <label for="comentario">Adicionar Comentário:</label>
                <textarea id="comentario" name="comentario" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn-primary">Comentar</button>
        </form>
    </div>

    <div style="margin-top: 20px;">
        <?php if (empty($comentarios)): ?>
            <p>Nenhum comentário ainda.</p>
        <?php else: ?>
            <?php foreach ($comentarios as $c): ?>
                <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                    <p><strong><?= htmlspecialchars($c['nome']) ?></strong> <span style="color: #888; font-size: 12px;">(<?= date('d/m/Y H:i', strtotime($c['data_comentario'])) ?>)</span></p>
                    <p><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
