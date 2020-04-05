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
        $lesson = R::count('lesson', "`id` = ?", [$id]);
        if ( !$lesson ) {
            die;
        }
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

    public function themeAction()
    {
        $id = $this->getCheckLessonID();
        $name = (string) $_POST['theme'];
        if ( trim($name) == "" ) {
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

    public function getCheckLessonID()
    {
        $referer = $this->getClearReferer();
        if( !preg_match("#^".PATH."/lesson/(?P<id>[0-9]+)$#", $referer, $matches) ) {
            die;
        }
        $id = (int) $matches['id'];
        return $id;
    }

    public function getTable($lesson)
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
        foreach ($visits as $visit) {
            $student_ids[] = $visit->student_id;
        }
        $students = R::loadAll('student', $student_ids);
        ob_start();
        require APP . "/views/Lesson/table.php";
        $table = ob_get_clean();
        return $table;
    }

    protected function getClearReferer()
    {
        $referer = trim($_SERVER['HTTP_REFERER'], "/");
        $referer = explode("?", $referer);
        $referer = $referer[0];
        return $referer;
    }
}