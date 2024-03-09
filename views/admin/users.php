<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Все пользователи вашего сайта</h1>

        <?
        echo GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'username',
                    'email',
                    'password',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('Изменить', ['updateuser', 'id' => $model->id]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a(
                                    'Удалить',
                                    ['deleteuser', 'id' => $model->id],
                                    [
                                        'data' => [
                                            'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
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

</div>
