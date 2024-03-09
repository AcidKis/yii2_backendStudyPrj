<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Данные пользователя</h1>

        <?
        echo GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'username',
                    'email',
                    'password',
                ],
                'summary' => '',
            ]
        );
        $form = ActiveForm::begin();
        echo $form->field($modelUpd, 'username')->label('Введите изменненные данные или оставьте пустым')->hint(
            'Имя пользователя'
        );
        echo $form->field($modelUpd, 'email')->label('Введите изменненные данные или оставьте пустым')->hint(
            'Почта пользователя'
        );
        echo $form->field($modelUpd, 'password')->label('Введите изменненные данные или оставьте пустым')->hint(
            'Пароль пользователя'
        );
        echo $form->field($modelUpd, 'adminrule')->checkbox(['labelOptions' => ['label' => 'Админка']]);

        echo Html::submitButton('Изменить', ['class' => 'btn btn-outline-success btn-lg']);
        ActiveForm::end();
        ?>

    </div>

</div>