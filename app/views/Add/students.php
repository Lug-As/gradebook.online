<?php getErrors(); ?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3>Добавить учеников к уроку</h3>
        <br>
        <input type="checkbox" id="select-all">
        <label for="select-all"><h5>Выбрать всех</h5></label>
        <form action="add/visits" method="POST">
            <div class="student-list">
                <?php if ($students): ?>
                    <?php foreach ($students as $student): ?>
                        <div class="student">
                            <input name="student-<?= $student->id; ?>" class="student-radio" type="checkbox" value="<?= $student->id; ?>" id="student-<?= $student->id; ?>">
                            <label for="student-<?= $student->id; ?>"><?= safeHtmlChars($student->name); ?> (<?= safeHtmlChars($student->nick); ?>)</label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-students">Пока нет учеников в группе</p>
                <?php endif; ?>
            </div>
            <br>
            <button class="btn btn-success btn-lg" id="create-btn">Создать урок</button>
        </form>
        <br>
        <div class="add-student">
            <h5>Добавить нового ученика</h5>
            <input id="student-input" name="name" class="form-control" type="text" placeholder="Имя">
            <input id="student-input-nick" name="nick" class="form-control" type="text" placeholder="Ник">
            <button class="btn btn-primary" id="student-button">Добавить</button>
        </div>
        <br>
    </div>
</div>
