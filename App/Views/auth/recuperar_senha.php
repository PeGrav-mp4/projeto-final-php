<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h2>Recuperar Senha</h2>
    <p>Para recuperar sua senha, valide seus dados informando o CPF e Data de Nascimento.</p>
    <br>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/recuperar_senha" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="14" required placeholder="000.000.000-00">
        </div>
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
        </div>
        <div class="form-group">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>
        </div>
        <button type="submit" class="btn-primary">Atualizar Senha</button>
    </form>
    <div style="margin-top: 15px;">
        <a href="/login">Voltar ao Login</a>
    </div>
</div>
