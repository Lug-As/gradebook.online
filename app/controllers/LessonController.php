<?php


namespace app\controllers;


use app\controllers\app\AppController;
use app\models\Student;
use gradebook\App;
use RedBeanPHP\R;

class LessonController extends AppController
{
    public function viewAction()
    {
        $lesson_id = $this->route['id'];
        $user_id = App::$app->getProperty('user_id');
        $lesson = R::findOne('lesson', "`id` = ?", [$lesson_id]);
        if (!$lesson) {
            throw new \Exception("Урок не найден", 404);
        }
        if ($lesson->user_id != $user_id) {
            throw new \Exception("Запрашиваемый урок принадлежит не вам", 403);
        }
        $lesson->date = $this->getCurrDate($lesson->date);
        $group = R::load('group', $lesson->group_id);
        $table = $this->getTable($lesson);
        $this->setData(compact("lesson", "group", "table"));
        $this->setMeta($lesson->name, "Урок", "Урок");
    }

    public function markAction()
    {
        if (!key_exists('student', $_POST) or !key_exists('theme', $_POST) or trim($_POST['student']) === "" or trim($_POST['theme']) === "") {
            die;
        }
        $user_id = App::$app->getProperty('user_id');
        $lesson_id = $this->getLessonOrID($user_id);
        $student_id = (int)trim($_POST['student']);
        $theme_id = (int)trim($_POST['theme']);
        $theme = R::count('theme', "`id` = ? AND `lesson_id` = ?", [$theme_id, $lesson_id]);
        $visit = R::count('visit', "`student_id` = ? AND `lesson_id` = ?", [$student_id, $lesson_id]);
        $check = R::count('mark', "`theme_id` = ? AND `student_id` = ?", [$theme_id, $student_id]);
        if ($check or !$visit or !$theme) {
            die;
        }
        $total_count = R::count('visit', "`lesson_id` = ?", [$lesson_id]);
        $real_count = R::count('mark', "`theme_id` = ?", [$theme_id]);
        $mark = R::dispense('mark');
        $mark->val = $total_count - $real_count;
        $mark->student_id = $student_id;
        $mark->theme_id = $theme_id;
        if (R::store($mark)) {
            echo $mark->val;
        }
        die;
    }

    public function studentAction()
    {
        if (!key_exists('name', $_POST) or !key_exists('nick', $_POST) or trim($_POST['name']) === "" or trim($_POST['nick']) === "") {
            die;
        }
        $user_id = App::$app->getProperty('user_id');
        $lesson = $this->getLessonOrID($user_id, true);
        $group_id = $lesson->group_id;
        $data = [
            'name' => trim($_POST['name']),
            'nick' => trim($_POST['nick']),
            'group_id' => $group_id,
        ];
        $student = new Student();
        $student->load($data);
        if (!$student->validate($data)) {
            die;
        }
        $student_id = $student->save('student');
        if (!$student_id) {
            die;
        }
        $visit = R::dispense('visit');
        $visit->student_id = $student_id;
        $visit->lesson_id = $lesson->id;
        if (!R::store($visit)) {
            die;
        }
        $visits = R::find('visit', "`lesson_id` = ?", [$lesson->id]);
        $st_ids = [];
        foreach ($visits as $visit) {
            $st_ids[] = $visit->student_id;
        }
        if ($st_ids) {
            R::exec("UPDATE `mark` SET `val` = `val` + 1 WHERE `val` IS NOT NULL AND `student_id` IN (" . R::genSlots($st_ids) . ")", $st_ids);
        }
        $table = $this->getTable($lesson);
        echo $table;
        die;
    }

    public function themeAction()
    {
        if (!key_exists('theme', $_POST) or trim($_POST['theme']) == ""){
            die;
        }
        $user_id = App::$app->getProperty('user_id');
        $lesson = $this->getLessonOrID($user_id, true);
        $name = (string)trim($_POST['theme']);
        $theme = R::dispense('theme');
        $theme->name = $name;
        $theme->lesson_id = $lesson->id;
        if (!R::store($theme)) {
            die;
        }
        if ($lesson) {
            $table = $this->getTable($lesson);
            echo $table;
        }
        die;
    }

    public function delstudentAction()
    {
        if (!key_exists('student', $_POST) or trim($_POST['student']) == "") {
            die;
        }
        $user_id = App::$app->getProperty('user_id');
        $lesson = $this->getLessonOrID($user_id, true);
        $student_id = (int)trim($_POST['student']);
        $student = R::findOne('student', "`id` = ?", [$student_id]);
        $visit = R::count('visit', '`student_id` = ? AND `lesson_id` = ?', [$student_id, $lesson->id]);
        if (!$student or !$visit) {
            die;
        }
        R::trash($student);
        $visits = R::find('visit', "`lesson_id` = ?", [$lesson->id]);
        $st_ids = [];
        foreach ($visits as $visit) {
            $st_ids[] = $visit->student_id;
        }
        if ($st_ids) {
            R::exec("UPDATE `mark` SET `val` = `val` - 1 WHERE `val` IS NOT NULL AND `student_id` IN (" . R::genSlots($st_ids) . ")", $st_ids);
        }
        $table = $this->getTable($lesson);
        echo $table;
        die;
    }

    public function editstudentAction()
    {
        if (!key_exists('type', $_POST) or !key_exists('value', $_POST) or !key_exists('student', $_POST)) {
            die;
        }
        $user_id = App::$app->getProperty('user_id');
        $lesson_id = $this->getLessonOrID($user_id);
        $type = (string)trim($_POST['type']);
        if ($type !== "name" and $type !== "nick") {
            die;
        }
        $value = (string)trim($_POST['value']);
        if ($value === "" or strlen($value) > 200) {
            die;
        }
        $student_id = (int)trim($_POST['student']);
        $student = R::findOne('student', "`id` = ?", [$student_id]);
        if (!$student) {
            die;
        }
        $visit = R::count('visit', '`student_id` = ? AND `lesson_id` = ?', [$student_id, $lesson_id]);
        if (!$visit) {
            die;
        }
        if (!key_exists($type, $student->getProperties()) or $student->$type == $value) {
            die;
        }
        $student->$type = $value;
        R::store($student);
        echo $value;
        die;
    }

    protected function getTable($lesson)
    {
        $themes = R::find('theme', "`lesson_id` = ?", [$lesson->id]);
        $th_ids = [];
        foreach ($themes as $theme) {
            $th_ids[] = $theme->id;
        }
        if ($th_ids) {
            $marks = R::find('mark', "`theme_id` IN (" . R::genSlots($th_ids) . ")", $th_ids);
        }
        $visits = R::find('visit', "`lesson_id` = ?", [$lesson->id]);
        $student_ids = [];
        foreach ($visits as $visit) {
            $student_ids[] = $visit->student_id;
        }
        $students = R::loadAll('student', $student_ids);
        ob_start();
        require APP . "/views/Lesson/table.php";
        $table = ob_get_clean();
        return $table;
    }

    protected function getLessonOrID($user_id, $lessonReturn = false)
    {
        $referer = $this->getClearReferer();
        if (!preg_match("#^" . PATH . "/lesson/(?P<id>[0-9]+)$#", $referer, $matches)) {
            die;
        }
        $lesson_id = (int)$matches['id'];
        $out = $this->checkLesson($lesson_id, $user_id, $lessonReturn);
        return $out;
    }

    protected function checkLesson($lesson_id, $user_id, $lessonReturn = false)
    {
        if (!$lessonReturn) {
            $lesson = R::count('lesson', "`id` = ? AND `user_id` = ?", [$lesson_id, $user_id]);
            $out = $lesson_id;
        } else {
            $lesson = R::findOne('lesson', "`id` = ? AND `user_id` = ?", [$lesson_id, $user_id]);
            $out = $lesson;
        }
        if (!$lesson) {
            die;
        }
        return $out;
    }

    protected function getClearReferer()
    {
        $referer = trim($_SERVER['HTTP_REFERER'], "/");
        $referer = explode("?", $referer);
        $referer = $referer[0];
        return $referer;
    }
}