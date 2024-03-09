<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php
$this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin(
        [
            'brandLabel' => 'Проект Стажировки',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top navbar-expand-lg navbar-dark bg-dark justify-content-end',
            ],
        ]
    );

    // Элементы слева
    $leftItems = [
        ['label' => 'Калькулятор', 'url' => ['/site/calculator']],
    ];

    // Элементы справа
    if (Yii::$app->user->isGuest) {
        // Для неавторизованного пользователя
        $rightItems[] = ['label' => 'Вход', 'url' => ['/site/login'],];
    } else {
        $items = [
            ['label' => 'Профиль', 'url' => ['/user/profile']],
            ['label' => 'История расчетов', 'url' => ['/user/history']],
            ['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
        ];

        if (Yii::$app->user->can('adminRule')) {
            $adminItems = [
                ['label' => 'Пользователи', 'url' => ['/admin/userslist']],
                ['label' => 'Полная история расчетов', 'url' => ['/admin/history']],
                ['label' => 'Типы сырья', 'url' => ['/admin/types']],
                ['label' => 'Тоннажи', 'url' => ['/admin/tonnages']],
                ['label' => 'Месяцы', 'url' => ['/admin/months']],
                ['label' => 'Цены', 'url' => ['/admin/prices']],
            ];
        }

        if (Yii::$app->user->can('adminRule')) {
            $rightItems[] = [
                'label' => "Админка",
                'items' => $adminItems,
            ];
        }

        $rightItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => $items,
        ];
    }

    // Вывод NavBar
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => $leftItems,
        ]
    );

    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right ms-auto'],
            'items' => $rightItems,
        ]
    );

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php
        if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php
        endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>


<?php
$this->endBody() ?>
</body>
</html>
<?php
$this->endPage() ?>
