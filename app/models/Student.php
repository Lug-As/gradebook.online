<?php


namespace app\models;


use app\models\app\AppModel;

class Student extends AppModel
{
    public $attributes = [
        'name' => '',
        'nick' => '',
        'group_id' => '',
    ];
    public $rules = [
        'required' => [
            ['name'],
            ['nick'],
        ],
        'integer' => [
            ['group_id'],
        ],
        'lengthMax' => [
            ['name', 100],
            ['nick', 100],
        ]
    ];
}