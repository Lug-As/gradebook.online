<?php


namespace app\controllers;


use app\controllers\app\AppController;
use app\models\User;

class UserController extends AppController
{
    public function signupAction()
    {
        if ( !empty($_POST) ){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if ( !$user->validate($data) ){
                $user->getErrors();

            }
            else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if ( $user->save('user') ) {
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
        
    }

    public function logoutAction()
    {
        if ( !empty($_SESSION['user']) ) {
            unset($_SESSION['user']);
        }
        redirect();
    }

}