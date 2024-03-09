<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Подробная история</h1>

        <?
        echo GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'username',
                    'month',
                    'tonnage',
                    'raw_type',
                    'price',
                    'created_at',
                ],
                'summary' => '',
            ]
        );
        ?>
        <h2 class="display-4">Таблица прайсов на момент калькуляции</h2>
        <?
        echo GridView::widget(
            [
                'dataProvider' => $tableProvider,
                'summary' => ''
            ]
        );
        ?>

    </div>

</div>

