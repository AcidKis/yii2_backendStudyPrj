<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
$form = ActiveForm::begin() ?>
<?= $form->field($model, 'email')->label('Ваша почта') ?>
<?= $form->field($model, 'password')->passwordInput()->label('Ваш пароль') ?>
<div class="form-group">
    <div>
        <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php
ActiveForm::end() ?>
<a href="signup">Регистрация</a>
