<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\Controller;
use app\models\Months;

class MonthsController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = new Months;
            return $response->getMonths();
        } elseif ($request->isPost) {
            $month = $request->post('month');
            $response = new Months();
            return $response->AddMonth($month);
        } elseif ($request->isDelete) {
            $month = $request->get('month');
            $response = new Months;
            return $response->deleteMonth($month);
        } else {
            return "Ошибка запроса";
        }
    }
}