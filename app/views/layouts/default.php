<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <base href="<?= PATH; ?>">
	<title><?= $meta['title']; ?></title>
	<meta name="description" content="<?= $meta['description']; ?>">
	<meta name="keywords" content="<?= $meta['keywords']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Item</a>
                        </li>
                    </ul>
                </div> -->
            </nav>
        </div>
    </div>
    <!-- end header -->
    <!-- start main -->
    <div class="main">
        <div class="container">
            <div class="main-content">
                <?= $content; ?>
            </div>
        </div>
    </div>
    <!-- end main -->
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
    <?php
     foreach ($scripts as $script) {
         echo $script;
     }
    ?>
</body>
</html>