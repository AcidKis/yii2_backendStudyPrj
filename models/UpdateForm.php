<?php

namespace app\models;

use yii\base\Model;

class UpdateForm extends Model
{
    public $username;
    public $email;
    public $password;
    public bool $adminrule;

    public function rules(){
        return [
            ['username', 'match', 'pattern' => '/^[a-zA-Zа-яА-Я]+$/u', 'message' => 'Имя должно содержать только буквы.'],
            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Эта почта уже занята'],
            ['email', 'email'],
            ['password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d]+$/', 'message' => 'Пароль должен содержать буквы и хотя бы одну цифру.'],
            ['adminrule', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'adminrule' => 'Админка',
        ];
    }   

}
