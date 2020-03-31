<?php


namespace app\controllers;


use app\controllers\app\AppController;
use gradebook\App;

class MainController extends AppController
{
	public function indexAction()
	{
		$this->setMeta(App::$app->getProperty('app_name'), "Онлайн журнал оценок", "Журнал оценок");
	}
}