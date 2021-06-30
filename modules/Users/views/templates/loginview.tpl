<div class="login-box">
    <form method="POST">
        <input type="hidden" name="module" value="Users" />
        <input type="hidden" name="action" value="auth" />

        <div class="input-wrapper">
            <label>Логин</label>
            <input type="text" name="login" />
        </div>
        <div class="input-wrapper">
            <label>Пароль</label>
            <input type="password" name="password" />
        </div>
        <div class="actions">
            <input type="submit" name="submit" class="primary" value="Войти"/>
        </div>
    </form>
</div>