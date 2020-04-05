<table class="table table-hover" id="main-table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Ученик</th>
            <th scope="col">Ник</th>
            <?php
            foreach ($themes as $theme): ?>
            <th scope="col"><?= safeHtmlChrs($theme->name); ?></th>
            <? endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($students as $student): ?>
        <tr>
            <th scope="row"><?= $i; ?></th>
            <td><?= safeHtmlChrs($student->name); ?></td>
            <td><?= safeHtmlChrs($student->nick); ?></td>
            <?php
            foreach ($themes as $theme): ?>
            <td>
                <?php
                $not_find = true;
                foreach ($marks as $mark) {
                    if ($mark->student_id == $student->id and $mark->theme_id == $theme->id) {
                        echo $mark->val;
                        $not_find = false;
                        break;
                    }
                }
                if ($not_find): ?>
                <button class="btn btn-success plus-btn" data-student="<?= $student->id; ?>" data-theme="<?= $theme->id; ?>">+</button>
                <?php endif; ?>
            </td>
            <? endforeach; ?>
        </tr>
        <?php
        $i++;
        endforeach; ?>
    </tbody>
</table>