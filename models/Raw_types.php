<?php

namespace app\models;

use yii\db\ActiveRecord;

class Raw_types extends ActiveRecord
{
    public function getTypes()
    {
        $types = Raw_types::find()
        ->select('name')
        ->orderBy('id')
        ->asArray()
        ->all();
        foreach ($types as $key => $value) {
            $typeslist[] = $value['name'];
        }
        return $typeslist;
    }

    public function addType($type)
    {
        $add = new Raw_types();
        $add->name = $type;
        $add->save();
        return 'Успешно добавлено';
    }

    public function deleteType($type)
    {
        $add = Raw_types::find()
            ->where(['name' => $type])
            ->one();
        $add->delete();
        return 'Успешно удалено';
    }

    public static function tableName(): string
    {
        return '{{%raw_types}}';
    }

}