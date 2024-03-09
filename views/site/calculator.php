<?php

use yii\bootstrap5\Alert;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php
$session = Yii::$app->session;
$session->open();
?>

<?php
if ($session->get('showSuccessAlert')): ?>
    <!-- Показываем уведомление об успешной авторизации -->
    <?= Alert::widget(
        [
            'options' => ['class' => 'alert-success'],
            'body' => 'Здравствуйте, ' . Yii::$app->user->identity->username . ', вы авторизовались в системе расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в журнале расчетов (' . Html::a(
                    'журнале расчетов',
                    ['user/history']
                ) . ').',
            'closeButton' => ['class' => 'btn-close', 'data-dismiss' => 'alert'],
        ]
    );
    $session->remove('showSuccessAlert') ?>
<?php
endif; ?>

<?php
$form = ActiveForm::begin(['id' => 'calculator-form']); ?>
    <h1>Калькулятор стоимости доставки сырья</h1>
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
        </div>
        <div class="row justify-content-md-center py-5">
            <div class="col">
                <?= Html::submitButton(
                    'Рассчитать',
                    ['class' => 'btn btn-outline-success btn-lg', 'id' => 'calculateButton']
                ) ?>
            </div>
        </div>
        <div class="row justify-content-md-center py-5" id="result-container"></div>
    </div>
<?php
ActiveForm::end(); ?>


<?php
$js = <<<JS
$('#calculator-form').on('beforeSubmit', function(){
    var data = $(this).serialize();
    $.ajax({
        url: '/site/calculator', // сюда необходимо подставить URL на ваш контроллер и действие
        type: 'POST',
        data: data,
        success: function(res) {
            $('#result-container').html(res);
        },
        error: function() {
            alert('Error! Please try again later.');
        }
    });
    return false; // чтобы предотвратить отправку формы
});
JS;
$this->registerJs($js);

?>