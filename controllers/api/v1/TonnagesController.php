<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\Controller;
use app\models\Tonnages;

class TonnagesController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = new Tonnages();
            return $response->getTonnages();
        } elseif ($request->isPost) {
            $tonnage = $request->post('tonnage');
            $response = new Tonnages();
            return $response->addTonnage($tonnage);
        } elseif ($request->isDelete) {
            $tonnage = $request->get('tonnage');
            $response = new Tonnages();
            return $response->deleteTonnage($tonnage);
        } else {
            return "Ошибка запроса";
        }
    }
}