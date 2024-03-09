<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\History;
use app\models\HistorySearch;

class UserController extends Controller
{

    public function actionHistory()
    {
        if (Yii::$app->user->can('historyCheck')) {
            $user = Yii::$app->user->identity->username;

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => History::find()->where(['username' => $user]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            $searchModel = new HistorySearch();

            $dataProvider = $searchModel->search(Yii::$app->request->get());

            return $this->render('historypage', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        }
        return $this->goHome();
    }

    public function actionFullhistory($id)
    {
        if (Yii::$app->user->can('historyCheck')) {
            $user = Yii::$app->user->identity->username;

            $oldTable = History::find()
                ->select(['priceTable'])
                ->where(['username' => $user, 'id' => $id])
                ->one();

            $priceArray = json_decode($oldTable->priceTable);

            $tableProvider = new ArrayDataProvider(
                [
                    'allModels' => $priceArray,
                ]
            );

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => History::find()->where(['username' => $user, 'id' => $id]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            return $this->render('fullhistory', ['tableProvider' => $tableProvider, 'dataProvider' => $dataProvider]);
        }
        return $this->goHome();
    }

    public function actionProfile()
    {
        if (Yii::$app->user->can('historyCheck')) {
            $user = Yii::$app->user->identity->username;

            return $this->render('profile', ['user' => $user]);
        }
        return $this->goHome();
    }


}