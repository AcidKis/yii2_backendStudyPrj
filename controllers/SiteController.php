<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CalculatorForm;
use app\models\SignUpForm;
use app\models\Prices;
use app\models\Months;
use app\models\Raw_types;
use app\models\Tonnages;
use app\models\User;
use app\models\History;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $session = Yii::$app->session;
            $session->open();
            $session->set('showSuccessAlert', true);
            return $this->redirect('calculator');
        }

        $model->email = Yii::$app->session->get('registredEmail');
        $model->password = '';

        return $this->render(
            'signin',
            [
                'model' => $model,
            ]
        );
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCalculator()
    {
        $model = new CalculatorForm();

        $tonnageList = new Tonnages;
        $monthList = new Months;
        $typesList = new Raw_types;
        //массивы для формы
        $monthArray = [];
        foreach ($monthList->getMonths() as $value) {
            $monthArray[$value] = $value;
        }

        $tonnageArray = [];
        foreach ($tonnageList->getTonnages() as $value) {
            $tonnageArray[$value] = $value;
        }

        $typeArray = [];
        foreach ($typesList->getTypes() as $value) {
            $typeArray[$value] = $value;
        }
        // Проверка, был ли отправлен AJAX-запрос
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // результат
            $result = Prices::find()
                ->joinWith(['months', 'tonnages', 'raw_types'])
                ->where(
                    [
                        'raw_types.name' => $model->type,
                        'months.name' => $model->month,
                        'tonnages.value' => $model->tonnage
                    ]
                )
                ->one();
            // создание таблицы прайсов
            foreach ($monthList->getMonths() as $key => $value) {
                $i = $key;
                $tableData[$key]["месяц"] = $value;
                $currentMonth = $value;
                foreach ($tonnageList->getTonnages() as $key => $value) {
                    $tableData[$i][$value] = Prices::find()
                        ->joinWith(['months', 'tonnages', 'raw_types'])
                        ->select(['price'])
                        ->where(
                            [
                                'raw_types.name' => $model->type,
                                'months.name' => $currentMonth,
                                'tonnages.value' => $value
                            ]
                        )
                        ->scalar();
                }
            }
            // сохранение в историю
            if (!Yii::$app->user->isGuest) {
                $add = new History();
                $add->username = Yii::$app->user->identity->username;
                $add->month = $model->month;
                $add->tonnage = $model->tonnage;
                $add->raw_type = $model->type;
                $add->price = $result->price;
                $add->priceTable = json_encode($tableData);
                $add->save();
            }

            return $this->renderPartial(
                '_result',
                [
                    'model' => $model,
                    'result' => $result,
                    'tableData' => $tableData
                ]
            );
        }

        return $this->render(
            'calculator',
            [
                'model' => $model,
                'tonnageArray' => $tonnageArray,
                'monthArray' => $monthArray,
                'typeArray' => $typeArray
            ]
        );
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userReg = new User();
            $userReg->username = $model->username;
            $userReg->email = $model->email;
            Yii::$app->session->set('registredEmail', $model->email);
            $userReg->password = Yii::$app->security->generatePasswordHash($model->password);
            $userReg->save();
            if ($userReg->save()) {
                $auth = Yii::$app->authManager;
                $user = $auth->getRole('user');
                $auth->assign($user, $userReg->id);
                return $this->redirect('login');
            }
        }

        return $this->render('signup', compact('model'));
    }

}