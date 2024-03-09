<?php

namespace app\models;

use yii\db\ActiveRecord;

class History extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%history}}';
    }

}