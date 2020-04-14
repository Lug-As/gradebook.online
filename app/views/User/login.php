<div class="signup">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <p class="lead text-center">Для начала необходимо <a href="user/login">войти</a> или <a href="user/signup">зарегистрироваться</a> на нашем сервисе</p>
            <?php getErrors(); ?>
            <h2 class="text-center">Вход</h2>
            <br>
            <form action="user/login" method="POST">
                <div class="form-group">
                    <label for="login-signin-input">Ваш логин</label>
                    <input id="login-signin-input" name="login" class="form-control signin-input" type="text"
                           placeholder="IronMan1965" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="password-signin-input">Ваш пароль</label>
                    <input id="password-signin-input" name="password" class="form-control signin-input" type="password"
                           placeholder="••••••••" required maxlength="50">
                </div>
                <br>
                <div class="form-group text-center">
                    <button class="btn btn-success btn-lg">Войти</button>
                </div>
            </form>
        </div>
    </div>
</div>