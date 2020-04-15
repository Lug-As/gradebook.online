<div class="top-lesson">
    <a class="btn btn-success btn-lg" href="add/">+Новый урок</a>
</div>
<div class="lesson-list">
    <div class="row">
        <div class="col-md-12">
            <?php if (!$lessons): ?>
            <div class="alert alert-secondary no-lessons">
                <p>Пока что нет уроков</p>
            </div>
            <?php else: ?>
                <?php foreach ($lessons as $lesson): ?>
                    <ul class="list-unstyled">
                        <li class="media">
                            <div class="media-body">
                                <div class="lesson">
                                    <h4 class="mt-0 mb-1"><a class="media-link" href="lesson/<?= $lesson->id; ?>"><?= safeHtmlChars($lesson->name); ?></a>
                                    </h4>
                                    <p>Дата: <strong><?= $lesson->date; ?></strong> Группа:
                                        <strong><?= safeHtmlChars($lesson->group->name); ?></strong></p>
                                    <div class="del-btn-box">
                                        <button class="btn btn-outline-danger del-btn">
                                            <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                 data-lesson="<?= $lesson->id; ?>">
                                                <path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>