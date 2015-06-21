<?php
/**
 * @var $this \yii\web\View
 * @var $model app\forms\RegisterForm
 */
?>
<br>
<div class="col-xs-6 col-xs-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            Регистрация
        </div>
        <div class="panel-body">
            <?php $form = \yii\bootstrap\ActiveForm::begin([
                'action' => [ 'user/register' ]
            ]) ?>
            <?= $form->field($model, 'login')->textInput() ?>
            <?= $form->field($model, 'surname')->textInput() ?>
            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'repeat_password')->passwordInput() ?>
            <?= \yii\helpers\Html::submitButton("Отправить", [
                "class" => "btn btn-danger"
            ]) ?>
            <?= \yii\helpers\Html::a('Назад', [ 'site/login' ], [
                'class' => 'btn btn-primary'
            ]) ?>
            <?php $form->end() ?>
        </div>
    </div>
    <?= \app\widgets\FlashMessenger::widget() ?>
</div>