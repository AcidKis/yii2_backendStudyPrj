<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\Controller;
use app\models\Raw_types;

class TypesController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = new Raw_types();
            return $response->getTypes();
        } elseif ($request->isPost) {
            $type = $request->post('type');
            $response = new Raw_types();
            return $response->addType($type);
        } elseif ($request->isDelete) {
            $type = $request->get('type');
            $response = new Raw_types();
            return $response->deleteType($type);
        } else {
            return "Ошибка запроса";
        }
    }
}