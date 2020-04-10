<?php
if (!key_exists('user', $_SESSION) or empty($_SESSION['user'])) {
    $dropdownLink = "Войти в аккаунт";
    $entered = false;
} else {
    $dropdownLink = "Добро пожаловать, " . safeHtmlChars($_SESSION['user']['name']) . "!";
    $entered = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <base href="/">
    <title><?= $meta['title']; ?></title>
    <meta name="description" content="<?= $meta['description']; ?>">
    <meta name="keywords" content="<?= $meta['keywords']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
<!-- start header -->
<div class="header">
    <div class="container">
        <div class="header-box">
            <h1 class="display-1 text-center"><?= \gradebook\App::$app->getProperty('site_header'); ?></h1>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Главная</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--                <div class="btn-group">-->
            <!--                    <a class="dropdown-toggle" data-toggle="dropdown">Account <span class="caret"></span></a>-->
            <!--                    <ul class="dropdown-menu">-->
            <!--                       --><?php //if(!empty($_SESSION['user'])): ?>
            <!--                          <li><a href="#">Добро пожаловать, -->
            <? //=htmlspecialchars($_SESSION['user']['name']);?><!--</a></li>-->
            <!--                          <li><a href="--><? //= PATH; ?><!--/user/logout">Выход</a></li>-->
            <!--                       --><?php //else: ?>
            <!--                          <li><a href="--><? //= PATH; ?><!--/user/login">Вход</a></li>-->
            <!--                          <li><a href="--><? //= PATH; ?><!--/user/signup">Регистрация</a></li>-->
            <!--                       --><?php //endif; ?>
            <!--                    </ul>-->
            <!--                 </div>-->
            <!--------- Меню --------->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false"><?= $dropdownLink; ?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if ($entered): ?>
                                <a class="dropdown-item" href="user/logout/">Выйти</a>
                            <?php else: ?>
                                <a class="dropdown-item" href="user/login/">Вход</a>
                                <a class="dropdown-item" href="user/signup/">Регистрация</a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <!--                        <li class="nav-item active">-->
                    <!--                            <a class="nav-link" href="/">Item</a>-->
                    <!--                        </li>-->
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- end header -->
<!-- start main -->
<div class="main">
    <div class="container">
        <div class="main-content">
            <?= $content . PHP_EOL; ?>
        </div>
    </div>
</div>
<!-- end main -->
<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<?php
foreach ($scripts as $script) {
    echo $script;
}
?>
</body>
</html>