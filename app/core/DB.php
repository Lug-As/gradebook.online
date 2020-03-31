<?php


namespace gradebook;


use RedBeanPHP\R;

class DB
{
    use TSingleton;

    protected function __construct()
    {
        $config = require CONF . '/db_config.php';
        R::setup($config['dsn'], $config['user'], $config['password']);
        if ( !R::testConnection() ){
            throw new \Exception("Ошибка подключения к базе данных. DSN: {$config['dsn']}, user: {$config['user']}, pass: {$config['password']}",  500);
        }
        R::freeze(!DEBUG);
        R::debug(DEBUG, 1);
    }
}