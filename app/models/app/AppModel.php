<?php


namespace app\models\app;


use gradebook\base\Model;
use app\widgets\currency\Currency;
use gradebook\App;
use gradebook\Cache;
use RedBeanPHP\R;

class AppModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
}