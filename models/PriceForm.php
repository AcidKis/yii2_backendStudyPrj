<?php

namespace app\models;

use yii\base\Model;


class PriceForm extends Model
{
    public $month;
    public $type;
    public $tonnage;
    public $price;

    public function rules(){
        return [
            ['type', 'required', 'message' => 'Необходимо указать тип'],
            ['month', 'required', 'message' => 'Необходимо указать месяц'],
            ['tonnage', 'required', 'message' => 'Необходимо указать тоннаж'],
            ['price', 'required', 'message' => 'Необходимо указать цену'],
        ];
    }

}