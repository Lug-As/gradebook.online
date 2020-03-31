<?php


namespace gradebook\base;


use gradebook\DB;
use RedBeanPHP\R;
use Valitron\Validator;

abstract class Model
{
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct()
    {
        DB::instance();
    }

    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            if ( array_key_exists($key, $this->attributes) ){
                $this->attributes[$key] = $value;
            }
        }
    }

    public function save($table)
    {
        $bean = R::dispense($table);
        foreach ($this->attributes as $key => $value) {
            $bean->$key = $value;
        }
        return R::store($bean);
    }

    public function validate(array $data)
    {
        Validator::langDir(WWW . "/valitron/lang");
        Validator::lang('ru');
        $v =  new Validator($data);
        $v->rules($this->rules);
        if( !$v->validate() ){
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    public function getErrors(){
        $list = "<ul>";
        foreach ($this->errors as $error) {
            foreach ($error as $value) {
                $list .= "<li>{$value}</li>";
            }
        }
        $list .= "</ul>";
        $_SESSION['errors'] = $list;
    }
}