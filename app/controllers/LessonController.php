<?php


namespace app\controllers;


use app\controllers\app\AppController;
use RedBeanPHP\R;

class LessonController extends AppController
{
    public function viewAction()
    {
        $id = $this->route['id'];
        $lesson = R::load('lesson', $id);
        if (!$lesson) {
            throw new \Exception("Урок не найден", 404);
        }
        $lesson->date = $this->getCurrDate($lesson->date);
        $group = R::load('group', $lesson->group_id);
        $table = $this->getTable($lesson);
        $this->setData( compact("lesson", "group", "table") );
        $this->setMeta($lesson->name, "Урок", "Урок");
    }

    public function markAction()
    {
        $id = $this->getCheckLessonID();
        $student_id = (int) $_POST['student'];
        $theme_id = (int) $_POST['theme'];
        $check = R::find('mark', "`theme_id` = ? AND `student_id` = ?", [$theme_id, $student_id]);
        if ($check) {
            die;
        }
        $total_count = R::count('visit', "`lesson_id` = ?", [$id]);
        $real_count = R::count('mark', "`theme_id` = ?", [$theme_id]);
        $mark = R::dispense('mark');
        $mark->val = $total_count - $real_count;
        $mark->student_id = $student_id;
        $mark->theme_id = $theme_id;
        if ( R::store($mark) !== false ) {
            echo $mark->val;
        }
        die;
    }

    public function studentAction()
    {
        $lesson = $this->getCheckLessonID(true);
        if ( !exist(trim($_POST['name'])) ) {
            die;
        }
        $name = trim($_POST['name']);
        $nick = trim($_POST['nick']);
        $group_id = $lesson->group_id;
        $student = R::dispense('student');
        $student->name = $name;
        $student->nick = $nick;
        $student->group_id = $group_id;
        $student_id = R::store($student);
        if ( $student_id === false ){
            die;
        }
        $visit = R::dispense('visit');
        $visit->student_id = $student_id;
        $visit->lesson_id = $id;
        if ( R::store($visit) === false ){
            die;
        }
        $visits = R::find('visit', "`lesson_id` = ?", [$id]);
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
        $id = $this->getCheckLessonID();
        $name = (string) trim($_POST['theme']);
        if ( $name == "" ) {
            die;
        }
        $theme = R::dispense('theme');
        $theme->name = $name;
        $theme->lesson_id = $id;
        if ( R::store($theme) === false ) {
            die;
        }
        $lesson = R::load('lesson', $id);
        if ( $lesson ){
            $table = $this->getTable($lesson);
            echo $table;
        }
        die;
    }

    public function delstudentAction()
    {
        $lesson = $this->getCheckLessonID(true);
        if ( !exist(trim($_POST['student'])) ) {
            die;
        }
        $student_id = (int) trim($_POST['student']);
        $student = R::load('student', $student_id);
        if ( !$student ){
            die;
        }
        R::trash($student);
        $visits = R::find('visit', "`lesson_id` = ?", [$id]);
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
        $id = $this->getCheckLessonID();
        $type = (string) trim($_POST['type']);
        if ( $type !== "name" and $type !== "nick" ){
            die;
        }
        $value = (string) trim($_POST['value']);
        if ( $value == "" or strlen($value) > 200 ){
            die;
        }
        $student_id = (int) trim($_POST['student']);
        $student = R::load('student', $student_id);
        if ( !$student ){
            die;
        }
        $visit = R::find('visit', '`student_id` = ? AND `lesson_id` = ?', [$student_id, $id]);
        if ( !$visit ){
            die;
        }
        if ( !key_exists($type, $student->getProperties()) or $student->$type == $value ){
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
        if ( $th_ids ) {
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

    protected function getCheckLessonID($lessonReturn = false)
    {
        $referer = $this->getClearReferer();
        if( !preg_match("#^".PATH."/lesson/(?P<id>[0-9]+)$#", $referer, $matches) ) {
            die;
        }
        $id = (int) $matches['id'];
        $out = $this->checkLesson($id, $lessonReturn);
        return $out;
    }

    protected function checkLesson($id, $lessonReturn = false)
    {
        if (!$lessonReturn) {
            $lesson = R::count('lesson', "`id` = ?", [$id]);
            $out = $id;
        } else {
            $lesson = R::load('lesson', $id);
            $out = $lesson;
        }
        if ( !$lesson ) {
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