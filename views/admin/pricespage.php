<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Цены</h1>

        <?
        echo GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'month',
                        'value' => 'months.name',
                    ],
                    [
                        'attribute' => 'tonnage',
                        'value' => 'tonnages.value',
                    ],
                    [
                        'attribute' => 'type',
                        'value' => 'raw_types.name',
                    ],
                    'price',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a(
                                    'Удалить',
                                    ['deleteprice', 'id' => $model->id],
                                    [
                                        'data' => [
                                            'confirm' => 'Вы уверены, что хотите удалить эту цену',
                                            'method' => 'post',
                                        ],
                                    ]
                                );
                            },
                        ],
                    ],
                ],
                'summary' => '',

            ]
        );

        ?>

    </div>
    <?php
    $form = ActiveForm::begin(); ?>
    <h1 class="text-center">Изменить цену</h1>
    <div class="container text-center">
        <div class="row g-2 py-5">
            <div class="col">
                <div class="form-floating">
                    <?= $form->field($model, 'month')->dropDownList(
                        $monthArray,
                        ['prompt' => 'Выберите месяц']
                    )->label('') ?>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <?= $form->field($model, 'type')->dropDownList(
                        $typeArray,
                        ['prompt' => 'Выберите тип']
                    )->label('') ?>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <?= $form->field($model, 'tonnage')->dropDownList(
                        $tonnageArray,
                        ['prompt' => 'Выберите тоннаж']
                    )->label('') ?>
                </div>
            </div>
            <div class="row">
                <div class="form-floating"><?= $form->field($model, 'price')->label('Укажите новую цену') ?></div>
            </div>
        </div>
        <div class="row justify-content-md-center py-5">
            <div class="col">
                <?= Html::submitButton(
                    'Изменить или добавить цену',
                    ['class' => 'btn btn-outline-success btn-lg', 'id' => 'calculateButton']
                ) ?>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>
</div>