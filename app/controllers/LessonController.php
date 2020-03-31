<?php


namespace app\controllers;


use app\controllers\app\AppController;

class LessonController extends AppController
{
    public function viewAction()
    {
        $this->setMeta("Урок", "Урок", "Урок");
    }
}