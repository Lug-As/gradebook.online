<div class="errors">
    <?php
    if ( isset($_SESSION['errors']) ) {
        debug($_SESSION['errors'], 'errors');
        unset($_SESSION['errors']);
    }
    ?>
</div>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="add-form">
            <h2 class="add-form-header">Создание нового урока</h2>
            <form action="add/lesson" method="POST">
                <div class="form-group">
                    <input type="text" name="lesson-name" class="form-control" id="lesson-name" placeholder="Введите название урока..." autocomplete="off" required>
                </div>
                <div class="form-group">
                    <h5>Группа</h5>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="form-check">
                                <input class="form-check-input group-radio-input" type="radio" name="lesson-group-radio" id="old-group-radio" data-show="old-group" checked>
                                <label class="form-check-label" for="old-group-radio">Имеющаяся</label>
                            </div>
                        </div>
                        <div class="form-group col-md-7">
                            <select class="form-control group-input" id="old-group" name="lesson-group-id" required>
                                <option value="">Выберете группу</option>
                                <?php foreach ($groups as $group): ?>
                                <option value="<?= $group->id; ?>"><?= $group->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input group-radio-input" type="radio" name="lesson-group-radio" id="new-group-radio" data-show="new-group">
                                    <label class="form-check-label" for="new-group-radio">Новая</label>
                                </div>
                            </div>
                            <div class="form-group col-md-7">
                                <input type="text" id="new-group" name="new-lesson-group" class="form-control group-input" placeholder="Введите название новой группы..." disabled hidden required autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать новый урок</button>
            </form>
        </div>
    </div>
</div>
