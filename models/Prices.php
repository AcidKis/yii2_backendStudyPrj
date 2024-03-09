<?php

namespace app\models;

use yii\db\ActiveRecord;

class Prices extends ActiveRecord
{
    public function PriceList($month,$type,$tonnage ){
        $result = Prices::find()
            ->joinWith(['months','tonnages','raw_types'])
            ->where(['raw_types.name' => $type,'months.name'=>$month,'tonnages.value'=>$tonnage])
            ->One();
        $arrayList = Prices::find()
            ->joinWith(['months','tonnages','raw_types'])
            ->select(['month' => 'months.name','tonnage' => 'tonnages.value','price'])
            ->where(['raw_types.name' => $type])
            ->asArray()
            ->all();
        foreach ($arrayList as $key => $value){
            $pricesList[$value["tonnage"]] = (int)$value["price"];
            $monthList[$value["month"]] = $pricesList;
            $list[$type] = $monthList;
        }
        $response = ['price' => $result->price,'price_list' => $list];
        return $response;
    }

    public function updatePrice($req)
    {
        $price = Prices::find()
            ->joinWith(['months','tonnages','raw_types'])
            ->where(['raw_types.name' => $req['type'],'months.name'=>$req['month'],'tonnages.value'=>$req['tonnage']])
            ->One();
        $price->price = $req['price'];
        $price->save();
        return 'Цена успешно обновлена';
    }

    public function addPrice($req)
    {
        $monthId = Months::find()
            ->where(['name' => $req['month']])
            ->one();
        $typeId = Raw_types::find()
            ->where(['name' => $req['type']])
            ->one();
        $tonnageId = Tonnages::find()
            ->where(['value' => $req['tonnage']])
            ->one();
        $add = new Prices();
        $add->price = $req['price'];
        $add->month_id = $monthId->id;
        $add->raw_type_id = $typeId->id;
        $add->tonnage_id = $tonnageId->id;
        $add->save();
        return 'Цена успешно добавлена';
    }


    public function getTonnages()
    {
        return $this->hasOne(Tonnages::className(), ['id' => 'tonnage_id']);
    }

    public function getMonths()
    {
        return $this->hasOne(Months::className(), ['id' => 'month_id']);
    }

    public function getRaw_types()
    {
        return $this->hasOne(Raw_types::className(), ['id' => 'raw_type_id']);
    }

    public static function tableName(): string
    {
        return '{{%prices}}';
    }

}