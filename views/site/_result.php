<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

//добавить таблицу
?>

    <h2>Результат расчета</h2>
    <h2><?
        print_r($result->price) ?></h2>
<?php
$dataProvider = new ArrayDataProvider(
    [
        'allModels' => $tableData,
    ]
);
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'summary' => '',
    ]
);