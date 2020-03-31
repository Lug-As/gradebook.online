<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Error Development</title>
</head>
<body>

    <h1>Произошла ошибка</h1>
    <p><b>Код ошибки:</b> <?= $errno; ?></p>
    <p><b>Текст ошибки:</b> <?= $errstr; ?></p>
    <p><b>Файл:</b> <?= $errfile; ?></p>
    <p><b>Строка:</b> <?= $errline; ?></p>
    <p><a href="<?= PATH; ?>">На главную</a></p>

</body>
</html>
