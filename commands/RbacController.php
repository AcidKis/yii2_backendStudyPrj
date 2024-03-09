<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

//yii migrate --migrationPath=@yii/rbac/migrations
//yii rcab/init

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');
        $authManager->add($admin);
        $authManager->add($user);


        $historyCheck = $authManager->createPermission('historyCheck');
        $historyCheck->description = "Просмотр истории";
        $adminRule = $authManager->createPermission('adminRule');
        $adminRule->description = "Просмотр админки";
        $authManager->add($historyCheck);
        $authManager->add($adminRule);

        $authManager->addChild($user, $historyCheck);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $adminRule);

        $authManager->assign($admin, 1);
    }
}