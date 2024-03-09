<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\Controller;
use app\models\Prices;

class PriceController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        if ($request->isPut) {
            $req['type'] = $request->post('type');
            $req['tonnage'] = $request->post('tonnage');
            $req['month'] = $request->post('month');
            $req['price'] = $request->post('price');
            $response = new Prices();
            return $response->updatePrice($req);
        } elseif ($request->isPost) {
            $req['type'] = $request->post('type');
            $req['tonnage'] = $request->post('tonnage');
            $req['month'] = $request->post('month');
            $req['price'] = $request->post('price');
            $response = new Prices();
            return $response->addPrice($req);
        } else {
            return "Ошибка запроса";
        }
    }
}