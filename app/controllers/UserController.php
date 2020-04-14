<?php


namespace app\controllers;


use app\controllers\app\AppController;
use app\models\User;

class UserController extends AppController
{
    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if (!$user->validate($data) or !$user->checkUnique()) {
                $_SESSION['errors'] = $user->errors;
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                $hash = generate_hash();
                $user->attributes['hash'] = $hash;
                $id = $user->save('user');
                if ($id) {
                    setcookie('user_id', $id, time() + 60 * 60 * 24 * 30, "/");
                    setcookie('user_hash', $hash, time() + 60 * 60 * 24 * 30, "/", null, false, true);
                    $_SESSION['user'] = $user->attributes;
                    redirect(PATH);
                } else {
                    $_SESSION['errors'][] = "Произошла ошибка. Повторите попытку позже.";
                }
            }
            redirect();
        }
        $this->setMeta("Регистрация");
    }

    public function loginAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            if ($user->login($data)) {
                redirect(PATH);
            } else {
                $_SESSION['errors'][] = $user->errors;
                redirect();
            }
        }
        $this->setMeta("Вход в аккаунт");
    }

    public function logoutAction()
    {
        if (key_exists('user', $_SESSION)) {
            unset($_SESSION['user']);
        }
        setcookie('user_id', 0, time() - 3600, "/");
        setcookie('user_hash', 0, time() - 3600, "/");
        redirect();
    }

}