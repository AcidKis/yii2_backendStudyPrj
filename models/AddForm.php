<?php

namespace app\models;

use yii\base\Model;

class AddForm extends Model
{
    public $monthName;
    public $tonnageValue;
    public $typeName;

    public function rules(){
        return [
            [['monthName', 'tonnageValue', 'typeName'], 'safe'],
            ['tonnageValue', 'integer']
        ];
    }

}