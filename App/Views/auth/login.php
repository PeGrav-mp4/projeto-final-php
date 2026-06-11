<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="lembrar" value="1"> Lembrar-me
            </label>
        </div>
        <button type="submit" class="btn-primary">Entrar</button>
    </form>
    <div style="margin-top: 15px;">
        <a href="/recuperar_senha">Esqueci minha senha</a> | <a href="/cadastro">Não tenho conta</a>
    </div>
</div>
