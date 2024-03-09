<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Типы сырья</h1>

        <?

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{link} {delete}',
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a('Удалить', ['deletetype', 'id' => $model->id], [
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите удалить этот тип',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                    
                ],
                'summary' => '',
            ]);

            $form = ActiveForm::begin();
            echo $form->field($addModel, 'typeName')->label('Название типа');
            echo Html::submitButton('Добавить', ['class' => 'btn btn-outline-success btn-lg']);
            ActiveForm::end();
        ?>

    </div>

</div>