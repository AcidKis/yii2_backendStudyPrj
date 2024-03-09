<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\CalculatorForm;
use app\models\Prices;

class CalculateController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $type = $request->get('type');
        $tonnage = $request->get('tonnage');
        $month = $request->get('month');
        $response = new Prices();
        return $response->PriceList($month, $type, $tonnage);
    }
}

//http://calculator-yii2/web/api/v1/calculate-price?month=январь&type=жмых&tonnage=25

