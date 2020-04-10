<div class="signup">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php getErrors(); ?>
            <h2 class="text-center">Регистрация</h2>
            <br>
            <form action="user/signup" method="POST">
                <div class="form-group">
                    <label for="name-signup-input">Ваше имя</label>
                    <input id="name-signup-input" name="name" class="form-control signup-input" type="text"
                           placeholder="Тони Старк" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="login-signup-input">Ваш логин</label>
                    <input id="login-signup-input" name="login" class="form-control signup-input" type="text"
                           placeholder="Iron Man" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="email-signup-input">Ваш email</label>
                    <input id="email-signup-input" name="email" class="form-control signup-input" type="text"
                           placeholder="ironman@ya.ru" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="password-signup-input">Ваш пароль</label>
                    <input id="password-signup-input" name="password" class="form-control signup-input" type="password" placeholder="••••••••" required maxlength="50">
                </div>
                <br>
                <div class="form-group text-center">
                    <button class="btn btn-success btn-lg">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
</div>