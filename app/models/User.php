<?php


namespace app\models;


use app\models\app\AppModel;
use RedBeanPHP\R;

class User extends AppModel
{
    public $attributes = [
        'name' => '',
        'login' => '',
        'email' => '',
        'password' => '',
    ];
    public $rules = [
        'required' => [
            ['name'],
            ['login'],
            ['email'],
            ['password'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthBetween' => [
            ['password', 6, 50],
        ],
        'lengthMax' => [
            ['login', 100],
            ['name', 100],
            ['email', 100],
        ]
    ];

    public function checkUnique()
    {
        $users = R::find('user', "`login` = ? OR `email` = ?", [
            $this->attributes['login'],
            $this->attributes['email'],
        ]);
        if ($users){
            foreach ($users as $user) {
                if ($this->attributes['login'] == $user->login){
                    $this->errors['unique'][] = "Такой логин уже занят";
                }
                if ($this->attributes['email'] == $user->email){
                    $this->errors['unique'][] = "Такой email уже занят";
                }
            }
            return false;
        }
        return true;
    }
}