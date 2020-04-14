<!--
Author: W3layouts
Author URL: http://w3layouts.com
-->
<?php
	if ($response == 404) {
		$subheader = "Такой страницы не существует";
	} elseif ($response == 403){
	    $subheader = "Запрашиваемый урок принадлежит не вам";
    } else {
		$subheader = "К сожалению, произошла ошибка";
	}
	$back = $_SERVER['HTTP_REFERER'] ?? PATH;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title><?= $subheader; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="/errors/prod/css/style.css" type="text/css" media="all" /><!-- Style-CSS -->
</head>

<body>
    <!-- error -->
	<section class="w3l-error-9">
		<div class="error-page">
			<div class="wrapper-full">
				<div class="main-content">
					<h2>Извините</h2>
					<h4><?= $subheader; ?></h4>
                    <p>Вы можете вернуться на главную страницу либо на предыдущую</p>
                    <p>Код ошибки <strong><?=$response?></strong></p>
					<!-- buttons -->
					<div class="buttons">
						<a href="<?=PATH; ?>" class="btn brk-btn-bg brk-btn">На главную</a>
						<a href="<?=$back; ?>" class="btn brk-btn">На предыдущую</a>
					</div>
				</div>
				<div class="bottom-header">
					<!-- copyright -->
					<div class="copyrights text-center">
						<p>© 2020 Pug Error Page. All rights reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- //error -->
</body>

</html>