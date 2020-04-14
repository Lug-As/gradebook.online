<?php


namespace app\controllers;


use app\controllers\app\AppController;
use app\models\Student;
use gradebook\App;
use RedBeanPHP\R;

class AddController extends AppController
{
    public function indexAction()
    {
        $user_id = App::$app->getProperty('user_id');
        $groups = R::find('group', "`user_id` = ?", [$user_id]);
        $this->setData(compact("groups"));
        $this->setMeta("Добавить новую статью", "Добавить новую статью", "Добавить новую статью");
    }

    public function studentsAction()
    {
        if (!key_exists('group_id', $_SESSION) or !is_int($_SESSION['group_id'])) {
            redirect();
        } else {
            $group_id = $_SESSION['group_id'];
            $students = R::find('student', "`group_id` = ?", [$group_id]);
        }
        $this->setData(compact('students'));
        $this->setMeta("Добавление учеников", "Добавление учеников", "Добавление учеников");
    }

    public function lessonAction()
    {
        if (empty($_POST)) {
            $this->errorsRedirect("Введите нужную информацию");
        }
        $data = $_POST;
        $user_id = App::$app->getProperty('user_id');
        if (!key_exists('lesson-name', $data) or trim($data['lesson-name']) === "") {
            $this->errorsRedirect("Название урока обязательно для заполнения");
        }
        if (key_exists('lesson-group-id', $data) and is_numeric($data['lesson-group-id']) and (int)$data['lesson-group-id'] > 0) {
            $group_id = (int)$data['lesson-group-id'];
            $count = R::count('group', "`id` = ? AND `user_id` = ?", [$group_id, $user_id]);
            if (!$count) {
                $this->errorsRedirect("Искомой группы не сущестует");
            }
        } elseif (key_exists('new-lesson-group', $data) and is_string($data['new-lesson-group']) and trim($data['new-lesson-group']) !== "" and strlen(trim($data['new-lesson-group'])) < 100) {
            $group_name = trim($data['new-lesson-group']);
            $group = R::dispense('group');
            $group->name = $group_name;
            $group->user_id = $user_id;
            $group_id = R::store($group);
            if (!$group_id) {
                $this->errorsRedirect("Произошла ошибка. Повторите попытку позже");
            }
        } else {
            $this->errorsRedirect("Правильно укажите группу для урока");
        }
        $lesson = R::dispense('lesson');
        $lesson->name = trim($data['lesson-name']);
        $lesson->group_id = $group_id;
        $lesson->user_id = $user_id;
        $lesson_id = R::store($lesson);
        if (!$lesson_id) {
            $this->errorsRedirect("Произошла ошибка. Повторите попытку позже");
        }
        $_SESSION['lesson_id'] = $lesson_id;
        $_SESSION['group_id'] = $group_id;
        redirect(PATH . "/add/students");
    }

    public function newAction()
    {
        if (!key_exists('name', $_POST) or !key_exists('nick', $_POST) or trim($_POST['name']) === "" or trim($_POST['nick']) === "") {
            $_SESSION['errors'][] = 'Необходимо заполнить имя и ник ученика';
            die;
        }
        if (!key_exists('group_id', $_SESSION) or !is_numeric($_SESSION['group_id'])) {
            die;
        }
        $group_id = (int)$_SESSION['group_id'];
        $user_id = App::$app->getProperty('user_id');
        $group = R::findOne('group', "`id` = ? AND `user_id` = ?", [$group_id, $user_id]);
        if (!$group) {
            die;
        }
        $data = [
            'name' => trim($_POST['name']),
            'nick' => trim($_POST['nick']),
            'group_id' => $group_id,
        ];
        $student = new Student();
        $student->load($data);
        if (!$student->validate($data)) {
            $_SESSION['errors'][] = $student->errors;
        } elseif (!$student->save('student')) {
            $_SESSION['errors'][] = "Произошла ошибка. Повторите попытку позже.";
        }
        die;
    }

    public function visitsAction()
    {
        if (!key_exists('lesson_id', $_SESSION) or !key_exists('group_id', $_SESSION)) {
            redirect();
        }
        $lesson_id = (int)$_SESSION['lesson_id'];
        $group_id = (int)$_SESSION['group_id'];
        $data = $_POST;
        $ids = [];
        foreach ($data as $key => $value) {
            if (preg_match("#^student-(?P<id>[0-9]+)$#", $key, $matches)) {
                $ids[] = $matches['id'];
            }
        }
        if (!$ids) {
            $this->errorsRedirect('Необходимо выбрать хотя бы одного ученика');
        }
        $visits = R::dispense('visit', count($ids), true);
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $exec_array = R::getRow("SELECT `group_id` FROM `student` WHERE `id` = ?", [$id]);
            if (key_exists('group_id', $exec_array)){
                if ($exec_array['group_id'] == $group_id){
                    $visits[$i]->lesson_id = $lesson_id;
                    $visits[$i]->student_id = $id;
                }
            }
        }
        R::storeAll($visits);
        $lesson_id = $_SESSION['lesson_id'];
        unset($_SESSION['lesson_id']);
        unset($_SESSION['group_id']);
        redirect(PATH . "/lesson/{$lesson_id}");
    }

    protected function errorsRedirect($errorText = "")
    {
        if ($errorText) {
            $_SESSION['errors'][] = $errorText;
        }
        redirect();
    }
}