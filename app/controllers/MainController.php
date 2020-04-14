<?php


namespace app\controllers;


use app\controllers\app\AppController;
use gradebook\App;
use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction()
    {
        $user_id = App::$app->getProperty('user_id');
        $lessons = R::find('lesson', "`user_id` = ? ORDER BY `date` DESC", [$user_id]);
        foreach ($lessons as $lesson) {
            $lesson->date = $this->getCurrDate($lesson->date);
        }
        $this->setData(compact("lessons", "groups"));
        $this->setMeta(App::$app->getProperty('app_name'), "Онлайн журнал оценок", "Журнал оценок");
    }

    public function dellessonAction()
    {
        if (!key_exists('lesson', $_POST) or trim($_POST['lesson']) === "") {
            die;
        }
        $user_id = App::$app->getProperty('user_id');
        $lesson_id = (int)trim($_POST['lesson']);
        $lesson = R::findOne('lesson', "`id` = ?", [$lesson_id]);
        if ($lesson) {
            if ($lesson->user_id === $user_id) {
                R::trash($lesson);
            }
        }
        die;
    }
}