<?php


namespace app\controllers\app;


use app\models\app\AppModel;
use app\models\User;
use gradebook\App;
use gradebook\base\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        User::authentication();
        if (App::$app->getProperty('user_id') === 0 and $this->route['controller'] != "User"){
            redirect(PATH . "/user/login");
        }
    }

    protected function getCurrDate($date)
    {
        $date = strtotime($date);
        $date = date("d.m.Y", $date);
        return $date;
    }
}