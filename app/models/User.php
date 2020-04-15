<?php


namespace app\models;


use app\models\app\AppModel;
use gradebook\App;
use RedBeanPHP\R;

class User extends AppModel
{
    public $attributes = [
        'name' => '',
        'login' => '',
        'password' => '',
    ];
    public $rules = [
        'required' => [
            ['name'],
            ['login'],
            ['password'],
        ],
        'lengthBetween' => [
            ['password', 6, 50],
        ],
        'lengthMax' => [
            ['login', 100],
            ['name', 100],
        ]
    ];

    public static function authentication()
    {
        App::$app->setProperty('user_id', 0);
        if (!key_exists('user_id', $_COOKIE) or !key_exists('user_hash', $_COOKIE)) {
            return false;
        }
        $id = $_COOKIE['user_id'];
        $hash = $_COOKIE['user_hash'];
        if (checkUserHash($id, $hash)) {
            setcookie('user_id', $id, time() + 60 * 60 * 24 * 30, "/");
            setcookie('user_hash', $hash, time() + 60 * 60 * 24 * 30, "/", null, false, true);
            App::$app->setProperty('user_id', $id);
            if (!key_exists('user', $_SESSION)) {
                $user = R::load('user', $id);
                $_SESSION['user'] = $user;
            }
            return true;
        } else {
            if (key_exists('user', $_SESSION)) {
                unset($_SESSION['user']);
            }
            setcookie('user_id', 0, time() - 3600, "/");
            setcookie('user_hash', 0, time() - 3600, "/");
            header("Refresh: 0");
            die;
        }
    }

    public function checkUnique()
    {
        $users = R::find('user', "`login` = ?", [
            $this->attributes['login'],
        ]);
        if ($users) {
            foreach ($users as $user) {
                if ($this->attributes['login'] == $user->login) {
                    $this->errors['unique'][] = "Такой логин уже занят";
                }
            }
            return false;
        }
        return true;
    }

    public function login($data)
    {
        if (!key_exists('login', $data) or trim($data['login']) === "") {
            $this->errors['login'][] = "Введите логин";
            return false;
        }
        if (!key_exists('password', $data) or trim($data['password']) === "") {
            $this->errors['password'][] = "Введите пароль";
            return false;
        }
        $login = trim($data['login']);
        $password = $data['password'];
        $user = R::findOne('user', "`login` = ?", [$login]);
        if (!$user) {
            $this->errors['login'][] = "Такого логина не существует";
            return false;
        }
        if (!password_verify($password, $user->password)) {
            $this->errors['password'][] = "Неверный пароль";
            return false;
        }
        $hash = generate_hash();
        $user->hash = $hash;
        $id = R::store($user);
        if ($id){
            setcookie('user_id', $id, time() + 60 * 60 * 24 * 30, "/");
            setcookie('user_hash', $hash, time() + 60 * 60 * 24 * 30, "/", null, false, true);
            $_SESSION['user'] = $user;
        }
        return true;
    }
}