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
	<!--  table start  -->
	<div class="row">
		<div class="col-md-12">
            <div class="table-wrap">
                <?= $table; ?>
            </div>
		</div>
	</div>
	<!--  table end  -->
    <!-- adding theme form start -->
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="input-group mb-3">
                <input id="add-input" class="form-control" name="theme" type="text" placeholder="Добавить новую тему..." aria-label="Добавить новую тему..." aria-describedby="button-add">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="button-add" disabled>Добавить</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- adding theme form end -->
    <!--  counting start  -->
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="button-block text-center">
                <button class="btn btn-danger btn-lg" id="counting-btn" data-toggle="modal" data-target="#counting-modal">Посчитать баллы</button>
                <button class="btn btn-success btn-lg" id="task-btn" data-toggle="modal" data-target="#counting-modal">Быстрое задание</button>
            </div>
        </div>
    </div>
    <br>
    <!--  counting end  -->
    <!--  adding student start  -->
    <br>
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="input-group mb-3">
				<input id="name-input" class="form-control" name="name" type="text" placeholder="Имя нового ученика...">
				<input id="nick-input" class="form-control" name="nick" type="text" placeholder="Ник нового ученика...">
				<div class="input-group-append">
					<button class="btn btn-success" id="button-add2" disabled>Добавить</button>
				</div>
			</div>
		</div>
	</div>
    <!--  adding student end  -->
</div>

<!-- Modal -->
<div class="modal fade" id="counting-modal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-table">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>