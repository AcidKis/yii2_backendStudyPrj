<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function actionGetSpec()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/x-yaml');

        ob_start();

        include_once Yii::getAlias('@app') . '/swagger/spec.yml';

        return ob_get_clean();
    }
}
