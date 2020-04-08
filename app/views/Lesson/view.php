<div class="single">
    <?php getErrors(); ?>
	<div class="row">
		<div class="col-md-6">
			<h4 class="text-center"><span class="text-muted">Группа </span><?= safeHtmlChars($group->name); ?></h4>
		</div>
		<div class="col-md-6">
			<h4 class="text-center"><span class="text-muted">Дата </span><?= safeHtmlChars($lesson->date); ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="lesson-header">
				<h2 class="text-center"><span class="text-muted">Урок: </span><?= safeHtmlChars($lesson->name); ?></h2>
			</div>
		</div>
	</div>
	<!-- table start -->
	<div class="row">
		<div class="col-md-12">
            <?= $table; ?>
		</div>
	</div>
	<!-- adding form start -->
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="input-group mb-3">
				<input type="text" class="form-control" placeholder="Добавить новую тему..." aria-label="Добавить новую тему..." aria-describedby="button-add" id="add-input">
				<div class="input-group-append">
					<button class="btn btn-primary" id="button-add" disabled>Добавить</button>
				</div>
			</div>
		</div>
	</div>
    <br>
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="input-group mb-3">
				<input type="text" class="form-control" placeholder="Имя нового ученика..." aria-label="Имя нового ученика..." aria-describedby="button-add2" id="name-input">
				<input type="text" class="form-control" placeholder="Ник нового ученика..." aria-label="Ник нового ученика..." aria-describedby="button-add2" id="nick-input">
				<div class="input-group-append">
					<button class="btn btn-success" id="button-add2">Добавить</button>
				</div>
			</div>
		</div>
	</div>
	<!-- adding form end -->
</div>