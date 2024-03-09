<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tonnages extends ActiveRecord
{

    public function getTonnages()
    {
        $tonnages = Tonnages::find()
        ->select('value')
        ->orderBy('value')
        ->asArray()
        ->all();
        foreach ($tonnages as $key => $value) {
            $tonnageslist[] = (int)$value['value'];
        }
        return $tonnageslist;
    }
    
    public function addTonnage($tonnage)
    {
        $add = new Tonnages();
        $add->value = $tonnage;
        $add->save();
        return 'Успешно добавлено';
    }

    public function deleteTonnage($tonnage)
    {
        $add = Tonnages::find()
            ->where(['value' => $tonnage])
            ->one();
        $add->delete();
        return 'Успешно удалено';
    }

    public static function tableName(): string
    {
        return '{{%tonnages}}';
    }

}