<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3>Добавить учеников к уроку</h3>
        <form action="add/visits" method="post">
            <div class="student-list">
                <?php
                if ($students):
                    foreach ($students as $student): ?>
                        <div class="student">
                            <input name="student-<?= $student->id; ?>" class="student-radio" type="checkbox" value="<?= $student->id; ?>" id="student-<?= $student->id; ?>">
                            <label for="student-<?= $student->id; ?>"><?= $student->name; ?> (<?= $student->nick; ?>)</label>
                        </div>
                    <?php endforeach;
                else: ?>
                    <p class="no-students">Пока нет учеников в группе</p>
                <?php
                endif;
                ?>
            </div>
            <br>
            <button class="btn btn-success btn-lg" id="create-btn">Создать урок</button>
        </form>
        <div class="add-student">
            <h5>Добавить нового ученика</h5>
            <input class="form-control" id="student-input" type="text" placeholder="Имя">
            <input class="form-control" id="student-input-nick" type="text" placeholder="Ник">
            <button class="btn btn-primary" id="student-button">Добавить</button>
        </div>
        <br>
    </div>
</div>
