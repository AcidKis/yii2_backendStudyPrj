<?php

namespace app\models;

use yii\base\Model;


class CalculatorForm extends Model
{
    public $month;
    public $type;
    public $tonnage;

    public function rules(){
        return [
            ['type', 'required', 'message' => 'Необходимо указать тип'],
            ['month', 'required', 'message' => 'Необходимо указать месяц'],
            ['tonnage', 'required', 'message' => 'Необходимо указать тоннаж'],
        ];
    }

    

}
