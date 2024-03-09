<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>


<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Ваша история калькуляций</h1>

        <?
        echo GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'month',
                    'tonnage',
                    'raw_type',
                    'price',
                    'created_at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{link}',
                        'buttons' => [
                            'link' => function ($url, $model, $key) {
                                return Html::a('Посмотреть полностью', ['fullhistory', 'id' => $key]);
                            },
                        ],
                    ],

                ],
                'summary' => '',
            ]
        );
        ?>

    </div>

</div>
