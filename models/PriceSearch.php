<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Months;
use app\models\Tonnages;
use app\models\Raw_types;
use app\models\Prices;

class PriceSearch extends Prices
{   
    public $id;
    public $tonnage;
    public $month;
    public $type;
    public $price;

    public function rules()
    {
        return [
            [['id','tonnage','price'], 'integer', 'message' => 'Цыферками!!!'],
            [['type', 'month'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = Prices::find()->joinWith(['months','tonnages','raw_types']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                    'tonnage' => [
                        'asc' => ['tonnages.value' => SORT_ASC],
                        'desc' => ['tonnages.value' => SORT_DESC],
                    ],
                    'month' => [
                        'asc' => ['months.name' => SORT_ASC],
                        'desc' => ['months.name' => SORT_DESC],
                    ],
                    'type' => [
                        'asc' => ['raw_types.name' => SORT_ASC],
                        'desc' => ['raw_types.name' => SORT_DESC],
                    ],
                    'price',
                    // Другие атрибуты
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        } 

        $query->andFilterWhere(['prices.id' => $this->id])
            ->andFilterWhere(['like', 'months.name', $this->month])
            ->andFilterWhere(['like', 'tonnages.value', $this->tonnage])
            ->andFilterWhere(['like', 'raw_types.name', $this->type])
            ->andFilterWhere(['price' => $this->price]);

        return $dataProvider;
    }
}