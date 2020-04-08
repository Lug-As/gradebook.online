<?php


namespace app\controllers;


use app\controllers\app\AppController;
use app\models\Add;
use RedBeanPHP\R;

class AddController extends AppController
{
    public function indexAction()
    {
        $groups = R::findAll('group');
        $this->setData( compact("groups") );
        $this->setMeta("Добавить новую статью", "Добавить новую статью", "Добавить новую статью");
    }

    public function lessonAction()
    {
        if ( empty($_POST) ){
            redirect();
        }
        $data = $_POST;
        if ( !exist( trim($data['lesson-name']) ) ) {
            $_SESSION['errors'][] = "Название урока обязательно для заполнения";
            redirect();
        }
        if (array_key_exists('lesson-group-id', $data) and is_int( (int) $data['lesson-group-id']) and (int) $data['lesson-group-id']>0){
            $group_id = (int) $data['lesson-group-id'];
            $count = R::count('group', "`id` = ?", [$group_id]);
            if ( !$count ){
                $_SESSION['errors'][] = "Искомой группы не сущестует";
                redirect();
            }
        } elseif ( array_key_exists('new-lesson-group', $data) and is_string($data['new-lesson-group']) and trim($data['new-lesson-group']) !== "" and strlen(trim($data['new-lesson-group'])) < 100){
            $group_name = trim($data['new-lesson-group']);
            $group = R::dispense('group');
            $group->name = $group_name;
            $group->user_id = 1;
            $group_id = R::store($group);
            if( !$group_id ) {
                $_SESSION['errors'][] = "Произошла ошибка. Повторите попытку позже";
                redirect();
            }
        } else {
            $_SESSION['errors'][] = "Правильно укажите группу для урока";
            redirect();
        }
        $lesson = R::dispense('lesson');
        $lesson->name = trim($data['lesson-name']);
        $lesson->group_id = $group_id;
        $lesson->user_id = 1;
        $lesson_id = R::store($lesson);
        if( !$lesson_id ) {
            $_SESSION['errors'][] = "Произошла ошибка. Повторите попытку позже";
            redirect();
        }
        $_SESSION['lesson_id'] = $lesson_id;
        $_SESSION['group_id'] = $group_id;
        redirect(PATH . "/add/students");
    }

    public function studentsAction()
    {
        if ( isset($_SESSION['group_id']) and is_int($_SESSION['group_id']) ) {
            $group_id = $_SESSION['group_id'];
            $students = R::find('student', "`group_id` = ?", [$group_id]);
        } else {
            redirect();
        }
        $this->setData( compact('students') );
        $this->setMeta("Добавление учеников", "Добавление учеников", "Добавление учеников");
    }

    public function newAction()
    {
        $name = trim($_POST['name']);
        $nick = trim($_POST['nick']);
        $student = R::dispense('student');
        $student->name = $name;
        $student->nick = $nick;
        $student->group_id = $_SESSION['group_id'];
        $id = R::store($student);
        $student = R::load('student', $id);
        echo "<div class='student'>
                <input type='checkbox' value='" . $student->id . "' id='student-" . $student->id . "'>
                <label for='student-" . $student->id . "'>" . $student->name . " (" . $student->nick . ")</label>
            </div>";
        die;
    }

    public function visitsAction()
    {
        $data = $_POST;
        foreach ($data as $key => $value) {
            if ( preg_match("#^student-(?P<id>[0-9]+)$#", $key, $matches) ) {
                $ids[] = $matches['id'];
            }
        }
        $visits = R::dispense('visit', count($ids));
        if ( !is_array($visits) ) {
            $info = $visits;
            $visits = [];
            $visits[] = $info;
        }
        for ($i = 0; $i < count($ids); $i++) {
            $visits[$i]->lesson_id = $_SESSION['lesson_id'];
            $visits[$i]->student_id = $ids[$i];
        }
        R::storeAll($visits);
        $lesson_id = $_SESSION['lesson_id'];
        unset($_SESSION['lesson_id']);
        unset($_SESSION['group_id']);
        redirect(PATH . "/lesson/{$lesson_id}");
    }
}