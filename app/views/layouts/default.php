<!DOCTYPE html>
<html>
<head>
	<title><?= $meta['title']; ?></title>
	<meta name="description" content="<?= $meta['description']; ?>">
	<meta name="keywords" content="<?= $meta['keywords']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="<?= PATH; ?>/css/style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>

	<?= $content; ?>
	<!-- scripts -->

    <?php
    // foreach ($scripts as $script) {
    //     echo $script;
    // }
    ?>
</body>
</html>