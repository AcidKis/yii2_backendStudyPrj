<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\History;

class AdminHistorySearch extends History
{   
    public $id;
    public $username;
    public $month;
    public $tonnage;
    public $raw_type;
    public $price;
    public $created_at;

    public function rules()
    {
        return [
            [['id'], 'integer', 'message' => 'Цыферками!!!'],
            [['username', 'month', 'tonnage', 'raw_type', 'price', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = History::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'tonnage', $this->tonnage])
            ->andFilterWhere(['like', 'raw_type', $this->raw_type])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}