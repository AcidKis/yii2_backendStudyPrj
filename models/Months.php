<?php

namespace app\models;

use yii\db\ActiveRecord;

class Months extends ActiveRecord
{
    public function getMonths()
    {
        $months = Months::find()
        ->select('name')
        ->orderBy('id')
        ->asArray()
        ->all();
        foreach ($months as $key => $value) {
            $monthslist[] = $value['name'];
        }
        return $monthslist;
    }

    public function addMonth($month)
    {
        $add = new Months();
        $add->name = $month;
        $add->save();
        return 'Успешно добавлено';
    }

    public function deleteMonth($month)
    {
        $add = Months::find()
            ->where(['name' => $month])
            ->one();
        $add->delete();
        return 'Успешно удалено';
    }
    
    public static function tableName(): string
    {
        return '{{%months}}';
    }

}