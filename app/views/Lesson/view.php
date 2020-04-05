<div class="single">
	<div class="row">
		<div class="col-md-6">
			<h4 class="text-center"><span class="text-muted">Группа </span><?= $group->name; ?></h4>
		</div>
		<div class="col-md-6">
			<h4 class="text-center"><span class="text-muted">Дата </span><?= $lesson->date; ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="lesson-header">
				<h2 class="text-center"><span class="text-muted">Урок: </span><?= $lesson->name; ?></h2>
			</div>
		</div>
	</div>
	<!-- table start -->
	<div class="row">
		<div class="col-md-10 offset-md-1">
            <?= $table; ?>
		</div>
	</div>
    <!--					<tr>-->
    <!--						<th scope="row">2</th>-->
    <!--						<td>Даниил Толбатов</td>-->
    <!--						<td>Dima Tolbatov</td>-->
    <!--						<td>3</td>-->
    <!--						<td><button class="btn btn-success">+</button></td>-->
    <!--					</tr>-->
    <!--					<tr>-->
    <!--						<th scope="row">3</th>-->
    <!--						<td>Борисов Алексей</td>-->
    <!--						<td>Алексей</td>-->
    <!--						<td>2</td>-->
    <!--						<td><button class="btn btn-success">+</button></td>-->
    <!--					</tr>-->
    <!--					<tr>-->
    <!--						<th scope="row">4</th>-->
    <!--						<td>Фомичев Никита</td>-->
    <!--						<td>Axrip</td>-->
    <!--						<td>4</td>-->
    <!--						<td><button class="btn btn-success">+</button></td>-->
    <!--					</tr>-->
	<!-- table end -->
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
	<!-- adding form end -->
</div>