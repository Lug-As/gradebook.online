<?php


namespace app\controllers\app;


use app\models\app\AppModel;
use gradebook\base\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
    }

    protected function getCurrDate($date)
    {
        $date = strtotime($date);
        $date = date("d.m.Y", $date);
        return $date;
    }
}