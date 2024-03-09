<?php
namespace app\models;
use yii\base\Model;
 
class SignUpForm extends Model{
    
    public $username;
    public $password;
    public $passwordConfirm;
    public $email;
    
    public function rules() {
        return [
            [['username', 'password', 'email', 'passwordConfirm'], 'required', 'message' => 'Заполните поле'],
            ['username', 'match', 'pattern' => '/^[a-zA-Zа-яА-Я]+$/u', 'message' => 'Имя должно содержать только буквы.'],
            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Эта почта уже занята'],
            ['email', 'email'],
            ['password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z\d]+$/', 'message' => 'Пароль должен содержать буквы и хотя бы одну цифру.'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'username' => 'Ваше имя',
            'password' => 'Ваш пароль',
            'email' => 'Ваша почта',
            'passwordConfirm' => 'Подтверждение пароля',
        ];
    }
    
}