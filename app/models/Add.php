<?php


namespace app\models;


use app\models\app\AppModel;

class Add extends AppModel
{
    public $attributes = [
        'lesson-name' => '',
        'lesson-group-id' => '',
        'new-lesson-group' => ''
    ];
    public $rules = [
        'required' => [
            ['lesson-name']
        ],
        'requiredWithout' => [
            ['lesson-group-id', 'new-lesson-group'],
            ['new-lesson-group', 'lesson-group-id']
        ],
        'lengthMax' => [
            ['lesson-name', 100],
            ['new-lesson-group', 100],
        ],
        'integer' => [
            ['lesson-group-id'],
        ],
        'max' => [
            ['lesson-group-id', 9999999999]
        ]
    ];
}