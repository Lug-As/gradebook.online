<?php


namespace app\controllers;


use app\controllers\app\AppController;
use gradebook\App;
use RedBeanPHP\R;

class MainController extends AppController
{
	public function indexAction()
	{
	    $lessons = R::findAll('lesson', "ORDER BY `date` DESC");
        foreach ($lessons as $lesson) {
            $lesson->date = $this->getCurrDate($lesson->date);
	    }
	    $this->setData( compact("lessons", "groups") );
		$this->setMeta(App::$app->getProperty('app_name'), "Онлайн журнал оценок", "Журнал оценок");
	}

    public function dellessonAction()
    {
        if ( !key_exists('lesson', $_POST) or trim($_POST['lesson']) === "" ){
            die;
        }
        $lesson_id = (int) trim($_POST['lesson']);
        $lesson = R::load('lesson', $lesson_id);
        if ( $lesson ){
            R::trash($lesson);
        }
        die;
	}
}