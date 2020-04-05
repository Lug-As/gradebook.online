<?php


namespace app\controllers;


use app\controllers\app\AppController;
use gradebook\App;
use RedBeanPHP\R;

class MainController extends AppController
{
	public function indexAction()
	{
	    $lessons = R::findAll('lesson');
        foreach ($lessons as $lesson) {
            $lesson->date = $this->getCurrDate($lesson->date);
	    }
	    $this->setData( compact("lessons", "groups") );
		$this->setMeta(App::$app->getProperty('app_name'), "Онлайн журнал оценок", "Журнал оценок");
	}
}