<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\History;
use app\models\AdminHistorySearch;
use app\models\User;
use app\models\UserSearch;
use app\models\Months;
use app\models\Tonnages;
use app\models\Raw_types;
use app\models\Prices;
use app\models\PriceSearch;
use app\models\PriceForm;
use app\models\UpdateForm;
use app\models\AddForm;
use yii\rbac\ManagerInterface;
use yii\helpers\ArrayHelper;

class AdminController extends Controller
{

    public function actionHistory()
    {
        if (Yii::$app->user->can('adminRule')) {
            $dataProvider = new ActiveDataProvider(
                [
                    'query' => History::find(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            $searchModel = new AdminHistorySearch();

            $dataProvider = $searchModel->search(Yii::$app->request->get());

            return $this->render('historypage', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        }
        return $this->goHome();
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $delete = History::find()
                ->where(['id' => $id])
                ->one();
            $delete->delete();

            return $this->redirect('history');
        }
        return $this->goHome();
    }

    public function actionFullhistory($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $oldTable = History::find()
                ->select(['priceTable'])
                ->where(['id' => $id])
                ->one();
            $priceArray = json_decode($oldTable->priceTable);

            $tableProvider = new ArrayDataProvider(
                [
                    'allModels' => $priceArray,
                ]
            );

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => History::find()->where(['id' => $id]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            return $this->render('fullhistory', ['tableProvider' => $tableProvider, 'dataProvider' => $dataProvider]);
        }
        return $this->goHome();
    }

    public function actionUserslist()
    {
        if (Yii::$app->user->can('adminRule')) {
            $dataProvider = new ActiveDataProvider(
                [
                    'query' => User::find(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            $searchModel = new UserSearch();

            $dataProvider = $searchModel->search(Yii::$app->request->get());

            return $this->render('users', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        }
        return $this->goHome();
    }

    public function actionDeleteuser($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $delete = User::find()
                ->where(['id' => $id])
                ->one();
            $delete->delete();

            return $this->redirect('userslist');
        }
        return $this->goHome();
    }

    public function actionUpdateuser($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $dataProvider = new ActiveDataProvider(
                [
                    'query' => User::find()->where(['id' => $id]),
                ]
            );

            $modelUpd = new UpdateForm;
            $userData = User::find()->where(['id' => $id])->one();
            $rolesByUser = Yii::$app->authManager->getRolesByUser($id);
            $userRoles = ArrayHelper::getColumn($rolesByUser, 'name');
            if (in_array('admin', $userRoles)) {
                $modelUpd->adminrule = true;
            } else {
                $modelUpd->adminrule = false;
            }
            //check отправки
            if ($modelUpd->load(Yii::$app->request->post()) && $modelUpd->validate()) {
                if (!empty($modelUpd->username)) {
                    $userData->username = $modelUpd->username;
                }
                if (!empty($modelUpd->email)) {
                    $userData->email = $modelUpd->email;
                }

                if (!empty($modelUpd->password)) {
                    $userData->password = Yii::$app->security->generatePasswordHash($modelUpd->password);
                }

                $auth = Yii::$app->authManager;
                $admin = $auth->getRole('admin');

                if ($modelUpd->adminrule && !in_array('admin', $userRoles)) {
                    $auth->assign($admin, $id); // Устанавливаем роль админа
                }

                if (!$modelUpd->adminrule) {
                    $auth->revoke($admin, $id); // Устанавливаем роль админа
                }

                $userData->save();
                $modelUpd->password = '';
                $modelUpd->username = '';
                $modelUpd->email = '';
            }


            return $this->render('updatepage', ['id' => $id, 'modelUpd' => $modelUpd, 'dataProvider' => $dataProvider]);
        }
        return $this->goHome();
    }

    public function actionMonths()
    {
        if (Yii::$app->user->can('adminRule')) {
            $addModel = new AddForm;

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => Months::find(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            if ($addModel->load(Yii::$app->request->post()) && !empty($addModel->monthName)) {
                $add = new Months();
                $add->name = $addModel->monthName;
                $add->save();
                return $this->refresh();
            }

            return $this->render('monthspage', ['dataProvider' => $dataProvider, 'addModel' => $addModel]);
        }
        return $this->goHome();
    }

    public function actionDeletemonth($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $add = Months::find()
                ->where(['id' => $id])
                ->one();
            $add->delete();

            return $this->redirect('months');
        }
        return $this->goHome();
    }

    public function actionTonnages()
    {
        if (Yii::$app->user->can('adminRule')) {
            $addModel = new AddForm;

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => Tonnages::find(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            if ($addModel->load(Yii::$app->request->post()) && $addModel->validate(
                ) && !empty($addModel->tonnageValue)) {
                $add = new Tonnages();
                $add->value = $addModel->tonnageValue;
                $add->save();
                return $this->refresh();
            }

            return $this->render('tonnagespage', ['dataProvider' => $dataProvider, 'addModel' => $addModel]);
        }
        return $this->goHome();
    }

    public function actionDeletetonnage($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $add = Tonnages::find()
                ->where(['id' => $id])
                ->one();
            $add->delete();

            return $this->redirect('tonnages');
        }
        return $this->goHome();
    }

    public function actionTypes()
    {
        if (Yii::$app->user->can('adminRule')) {
            $addModel = new AddForm;

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => Raw_types::find(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            if ($addModel->load(Yii::$app->request->post()) && !empty($addModel->typeName)) {
                $add = new Raw_types();
                $add->name = $addModel->typeName;
                $add->save();
                return $this->refresh();
            }

            return $this->render('typespage', ['dataProvider' => $dataProvider, 'addModel' => $addModel]);
        }
        return $this->goHome();
    }

    public function actionDeletetype($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $add = Raw_types::find()
                ->where(['id' => $id])
                ->one();
            $add->delete();

            return $this->redirect('types');
        }
        return $this->goHome();
    }

    public function actionPrices()
    {
        if (Yii::$app->user->can('adminRule')) {
            $model = new PriceForm;

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

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => Prices::find()->joinWith(['months', 'tonnages', 'raw_types']),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]
            );

            $searchModel = new PriceSearch();

            $dataProvider = $searchModel->search(Yii::$app->request->get());

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $exists = Prices::find()
                    ->joinWith(['months', 'tonnages', 'raw_types'])
                    ->where(
                        [
                            'raw_types.name' => $model->type,
                            'months.name' => $model->month,
                            'tonnages.value' => $model->tonnage
                        ]
                    )
                    ->exists();

                if ($exists) {
                    $add = Prices::find()
                        ->joinWith(['months', 'tonnages', 'raw_types'])
                        ->where(
                            [
                                'raw_types.name' => $model->type,
                                'months.name' => $model->month,
                                'tonnages.value' => $model->tonnage
                            ]
                        )
                        ->one();
                    $add->price = $model->price;
                    $add->save();
                } else {
                    $monthId = Months::find()
                        ->where(['name' => $model->month])
                        ->one();
                    $typeId = Raw_types::find()
                        ->where(['name' => $model->type])
                        ->one();
                    $tonnageId = Tonnages::find()
                        ->where(['value' => $model->tonnage])
                        ->one();
                    $add = new Prices();
                    $add->price = $model->price;
                    $add->month_id = $monthId->id;
                    $add->raw_type_id = $typeId->id;
                    $add->tonnage_id = $tonnageId->id;
                    $add->save();
                }
                return $this->refresh();
            }

            return $this->render(
                'pricespage',
                [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'tonnageArray' => $tonnageArray,
                    'monthArray' => $monthArray,
                    'typeArray' => $typeArray
                ]
            );
        }
        return $this->goHome();
    }

    public function actionDeleteprice($id)
    {
        if (Yii::$app->user->can('adminRule')) {
            $add = Prices::find()
                ->where(['id' => $id])
                ->one();
            $add->delete();

            return $this->redirect('prices');
        }
        return $this->goHome();
    }
}