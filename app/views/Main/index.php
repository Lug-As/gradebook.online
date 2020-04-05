<div class="top-lesson">
    <a class="btn btn-success btn-lg" href="add/">+Новый урок</a>
</div>
<div class="lesson-list">
    <?php foreach ($lessons as $lesson): ?>
    <div class="lesson">
        <ul class="list-unstyled">
            <li class="media">
                <div class="media-body">
                    <h4 class="mt-0 mb-1"><a class="media-link" href="lesson/<?= $lesson->id; ?>"><?= $lesson->name; ?></a></h4>
                    <p>Дата: <strong><?= $lesson->date; ?></strong> Группа: <strong><?= $lesson->group->name; ?></strong></p>
                </div>
            </li>
        </ul>
    </div>
    <?php endforeach; ?>
</div>